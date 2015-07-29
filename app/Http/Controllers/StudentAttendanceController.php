<?php
namespace App\Http\Controllers;

use Input;
use Session;
use Request;
use Redirect;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class StudentAttendanceController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		try {

			$state_id = Input::get('state_id');
			$township_id = Input::get('township_id');
			$academic_year = Input::get('academic_year');
				
			if(isset($township_id)) {

				$q = "SELECT *";
			
			} else {
			
				$q = "SELECT state_id,state_division";
			
			}

			$q .= " FROM v_state_township WHERE state_id = ".$state_id." AND (township_id = '".$township_id."' OR '' = '".$township_id."') GROUP BY state_id";

			$region = DB::select(DB::raw($q));
			
			$attendance = DB::select(DB::raw("SELECT s.location, s.school_level, s.school_no, s.school_name,  SUM(atts.lessthan_75boy) AS boys, SUM(atts.lessthan_75girl) AS girls FROM v_school AS s INNER JOIN student_attendance AS att ON att.school_id = s.school_id AND att.school_year=s.school_year INNER JOIN student_attendance_details AS atts ON atts.student_attendance_id = att.id AND s.state_divsion_id = ".$state_id." AND (s.township_id = '".$township_id."' OR '' = '".$township_id."') AND s.school_year = '".$academic_year."' GROUP BY atts.student_attendance_id ORDER BY s.school_level_id ASC"));
			
			if(count($attendance)) {
				
				return view('students.attendance', compact('attendance', 'region'));
				
			} else {
				
				$error = "There is no data in this State or Townshiip.";
				return view('students.attendance', compact('error'));
			
			}

			$err = "There is no data.";
			throw new Exception($err);

		} catch (Exception $e) {

			$error = "There is no data.";
			return view('students.attendance', compact('error'));

		}				
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
		return view('students.attendance');
		
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show()
	{
		$state_id = Input::get('state_id');
		$township_id = Input::get('township_id');
		$academic_year = Input::get('academic_year');
			
		if(isset($township_id)) {

			$q = "SELECT *";
		
		} else {
		
			$q = "SELECT state_id,state_division";
		
		}

		$q .= " FROM v_state_township WHERE state_id = ".$state_id." AND (township_id = '".$township_id."' OR '' = '".$township_id."') GROUP BY state_id";

		$region = DB::select(DB::raw($q));
		
		try {
			$attendance = DB::select(DB::raw("SELECT s.location, s.school_level, s.school_no, s.school_name,  SUM(atts.lessthan_75boy) AS boys, SUM(atts.lessthan_75girl) AS girls FROM v_school AS s INNER JOIN student_attendance AS att ON att.school_id = s.school_id AND att.school_year=s.school_year INNER JOIN student_attendance_details AS atts ON atts.student_attendance_id = att.id AND s.state_divsion_id = ".$state_id." AND (s.township_id = '".$township_id."' OR '' = '".$township_id."') AND s.school_year = '".$academic_year."' GROUP BY atts.student_attendance_id ORDER BY s.school_level_id ASC"));
			
			foreach ($attendance as $att_list) 
			{
				$att_lists[]=get_object_vars($att_list);
			}
		$state_name=DB::select(DB::raw("SELECT state_division FROM state_division WHERE id=".Input::get('state_id')));

			if(Input::get('township_id'))
			{
				$township_name=DB::select(DB::raw("SELECT township_name FROM township WHERE id=".Input::get('township_id')));	
			}	

			$request_input=array($state_name[0]->state_division,isset($township_name[0]->township_name)? $township_name[0]->township_name:'ALL',Input::get('academic_year'));

			Excel::create('Attendance75', function($excel) use($att_lists,$request_input){

	    	$excel->sheet('Attendance75', function($sheet) use($att_lists,$request_input){

	    		$sheet->prependRow(array('Township Education Management Information System'))->mergeCells('A1:D1',function($cells){
	    				$cells->setFontWeight('bold');
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('center');
	    				 $cells->setValignment('middle');
	    			});
	    		$sheet->appendRow(array('Students Attendance < 75'))->mergeCells('A2:D2',function($cells){
	    				$cells->setFontWeight('bold');
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('center');
	    				 $cells->setValignment('middle');
	    			});
	    		$sheet->appendRow(array('Division : '.$request_input[0]))->mergeCells('A3:D3',function($cells){
	    			$cells->setFontWeight('bold');
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('left');
	    				 $cells->setValignment('middle');
	    		});
	    		$sheet->appendRow(array('Township : '.$request_input[1]))->mergeCells('A4:D4',function($cell){
	    			$cell->setFontWeight('bold');
	    				$cell->setFontSize(11);
	    				$cell->setAlignment('right');
	    				 $cell->setValignment('middle');
	    		});
	    		$sheet->appendRow(array('Academic Year :'.$request_input[2]))->mergeCells('A5:D5',function($cell){
	    			$cell->setFontWeight('bold');
	    			$cell->setFontSize(18);
	    			$cell->setAlignment('left');
	    			$cell->setValignment('middle');
	    		});
	    		
	 			for($i = 0; $i < count($att_lists); $i++) {

					if($att_lists[$i]['location'] == "Rural") {
						$rural_level[] = $att_lists[$i]['school_level'];
					}

					if($att_lists[$i]['location'] == "Urban") {
						$urban_level[] = $att_lists[$i]['school_level'];
					}

				}

			
				if(isset($rural_level)) {
					$rural_levels = array_values(array_unique($rural_level));
				}
				
				if(isset($urban_level)) {
					$urban_levels = array_values(array_unique($urban_level));
				}

			$count=$sheet->getHighestRow()+1;
				$sheet->appendRow(array('Location : Rural'))->mergeCells('A'.$count.':D'.$count,function($cell){
				$cell->setFontWeight('bold');
	    		$cell->setFontSize(18);
	    		$cell->setAlignment('left');
	    		$cell->setValignment('middle');
			});

		//	<!-- Stat Rural -->
		
	
	
		if(isset($rural_level))
		 {
			for($k = 0; $k < count($rural_levels); $k++) 
			{ 
		
			$count=$sheet->getHighestRow()+1;
				$sheet->appendRow(array('School Level :'.$rural_levels[$k]))->mergeCells('A'.$count.':D'.$count,function($cell){
				$cell->setFontWeight('bold');
	    		$cell->setFontSize(18);
	    		$cell->setAlignment('left');
	    		$cell->setValignment('middle');
			});

		$sheet->appendRow(array('School No','School Name','Boys','Girls'));

	
		for($c = 0; $c < count($att_lists); $c++)
		 {
				if($att_lists[$c]['location'] == "Rural" && $att_lists[$c]['school_level'] == $rural_levels[$k]) 
				{

						$count=$sheet->getHighestRow()+1;
						$sheet->cell('A'.$count,function($cell) use($att_lists,$c){
		    				$cell->setValue($att_lists[$c]['school_no']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
				    	$sheet->cell('B'.$count,function($cell) use($att_lists,$c){
		    				$cell->setValue($att_lists[$c]['school_name']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
				    	$sheet->cell('C'.$count,function($cell) use($att_lists,$c){
		    				$cell->setValue($att_lists[$c]['boys']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
						$sheet->cell('D'.$count,function($cell) use($att_lists,$c){

		    				$cell->setValue($att_lists[$c]['girls']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
						
					//}
				}
			//}
		} 
			
		}
	}//end if rural_level

	// Start Urban
	$count=$sheet->getHighestRow()+1;
	$sheet->appendRow(array('Location : Urban'))->mergeCells('A'.$count.':D'.$count,function($cell){
		$cell->setFontWeight('bold');
		$cell->setFontSize(18);
		$cell->setAlignment('left');
		$cell->setValignment('middle');
	});
		
	if(isset($urban_level))
	{
		for($l = 0; $l < count($urban_levels); $l++)
		{ 
			$count=$sheet->getHighestRow()+1;
				$sheet->appendRow(array('School Level :'.$urban_levels[$l]))->mergeCells('A'.$count.':D'.$count,function($cell){
				$cell->setFontWeight('bold');
	    		$cell->setFontSize(18);
	    		$cell->setAlignment('left');
	    		$cell->setValignment('middle');
			});

		$sheet->appendRow(array('School No','School Name','Boys','Girls'));

		for($c = 0; $c < count($att_lists); $c++) 
		{
			if($att_lists[$c]['location'] == "Urban" && $att_lists[$c]['school_level'] == $urban_levels[$l]) 
				{
						$count=$sheet->getHighestRow()+1;
						$sheet->cell('A'.$count,function($cell) use($att_lists,$c){
		    				$cell->setValue($att_lists[$c]['school_no']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
				    	$sheet->cell('B'.$count,function($cell) use($att_lists,$c){
		    				$cell->setValue($att_lists[$c]['school_name']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
				    	$sheet->cell('C'.$count,function($cell) use($att_lists,$c){
		    				$cell->setValue($att_lists[$c]['boys']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
						$sheet->cell('D'.$count,function($cell) use($att_lists,$c){

		    				$cell->setValue($att_lists[$c]['girls']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
						
					}
				
			} 

		}
	}
			$sheet->setBorder('A1'.':D'.$sheet->getHighestRow(), 'thin');

	    	});

			 })->download('xlsx');	
			
			$err = "There is no data.";
			throw new Exception($err);

		} catch (Exception $e) {

			$error = "There is no data.";
			return view('students.attendance', compact('error'));

		}	
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}
}
