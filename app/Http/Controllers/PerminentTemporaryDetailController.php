<?php
namespace App\Http\Controllers;

use Input;
use Redirect;
use Session;
use View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PerminentTemporaryDetailController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if (!Input::get('btn_search')) {
		if (((Session::has('state_id')) && Session::has('academic_year')) || Session::has('township_id'))
		{
			$state_id = Session::get('state_id');
			$township_id = Session::get('township_id');
			$academic_year = Session::get('academic_year');
		}}
		else
		{
			$state_id = Input::get('state_id');
			$township_id = Input::get('township_id');
			$academic_year = Input::get('academic_year');
			
		}
		
		if($township_id) {

			$q = "SELECT *";
		
		} else {
		
			$q = "SELECT state_id, state_division";
		
		}
	
		$q .= " FROM v_state_township WHERE state_id = ".$state_id." AND (township_id = '".$township_id."' OR '' = '".$township_id."') GROUP BY state_id";
		
		$region = DB::select(DB::raw($q));

		$classroom_detail = DB::select(DB::raw("SELECT s.school_id, s.location, s.school_level, s.school_no, s.school_name, SUM(st.total_boy) AS boys, SUM(st.total_girl) AS girls, (b.permanent_wall + b.temporary_wall) AS class FROM v_school AS s INNER JOIN student_intake AS st ON s.school_id = st.school_id AND (s.state_divsion_id = '".$state_id."' OR '' = '".$state_id."') AND (s.township_id = '".$township_id."' OR '' = '".$township_id."') AND s.school_year = '".$academic_year."' LEFT JOIN school_building AS b ON b.school_id = st.school_id GROUP BY s.school_no ORDER BY s.sort_code, s.school_id ASC"));

		return View::make('students.classroom_detail', compact('classroom_detail', 'region'));
	
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		if (!Input::get('btn_search')) {
		if((Session::has('state_id') && Session::has('academic_year')) || Session::has('township_id')) {
			return Redirect::action('PerminentTemporaryDetailController@index');
		}} else {
			return View::make('students.classroom_detail');
		}
		
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
		if (!Input::get('btn_search')) {
		if (((Session::has('state_id')) && Session::has('academic_year')) || Session::has('township_id'))
		{
			$state_id = Session::get('state_id');
			$township_id = Session::get('township_id');
			$academic_year = Session::get('academic_year');
		}}
		else
		{
			$state_id = Input::get('state_id');
			$township_id = Input::get('township_id');
			$academic_year = Input::get('academic_year');
			
		}
		
		if($township_id) {

			$q = "SELECT *";
		
		} else {
		
			$q = "SELECT state_id, state_division";
		
		}
	
		$q .= " FROM v_state_township WHERE state_id = ".$state_id." AND (township_id = '".$township_id."' OR '' = '".$township_id."') GROUP BY state_id";
		
		$region = DB::select(DB::raw($q));

		$classroom_detail = DB::select(DB::raw("SELECT s.school_id, s.location, s.school_level, s.school_no, s.school_name, SUM(st.total_boy) AS boys, SUM(st.total_girl) AS girls, (b.permanent_wall + b.temporary_wall) AS class FROM v_school AS s INNER JOIN student_intake AS st ON s.school_id = st.school_id AND (s.state_divsion_id = '".$state_id."' OR '' = '".$state_id."') AND (s.township_id = '".$township_id."' OR '' = '".$township_id."') AND s.school_year = '".$academic_year."' LEFT JOIN school_building AS b ON b.school_id = st.school_id GROUP BY s.school_no ORDER BY s.sort_code, s.school_id ASC"));

		foreach ($classroom_detail as $room_detail) 
		{
			$detail[]=get_object_vars($room_detail);
		}
		$state_naem=DB::select(DB::raw("SELECT state_division FROM state_division WHERE id=".Input::get('state_id')));

			if(Input::get('township_id'))
			{
				$township_name=DB::select(DB::raw("SELECT township_name FROM township WHERE id=".Input::get('township_id')));	
			}	

			$request_input=array($state_naem[0]->state_division,isset($township_name[0]->township_name)? $township_name[0]->township_name:'ALL',Input::get('academic_year'));

			Excel::create('ClassroomDetail', function($excel) use($detail,$request_input){

	    	$excel->sheet('ClassroomDetail', function($sheet) use($detail,$request_input){

    		//$sheet->fromArray($post[0]);
	    		$sheet->prependRow(array('Township Education Management Information System'))->mergeCells('A1:E1',function($cells){
	    				$cells->setFontWeight('bold');
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('center');
	    				 $cells->setValignment('middle');
	    			});
	    		$sheet->appendRow(array('Perminent/Temporary Classroom Detail'))->mergeCells('A2:E2',function($cells){
	    				$cells->setFontWeight('bold');
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('center');
	    				 $cells->setValignment('middle');
	    			});
	    		$sheet->appendRow(array('Division : '.$request_input[0]))->mergeCells('A3:E3',function($cells){
	    			$cells->setFontWeight('bold');
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('left');
	    				 $cells->setValignment('middle');
	    		});
	    		$sheet->appendRow(array('Township : '.$request_input[1]))->mergeCells('A4:E4',function($cell){
	    			$cell->setFontWeight('bold');
	    				$cell->setFontSize(11);
	    				$cell->setAlignment('right');
	    				 $cell->setValignment('middle');
	    		});
	    		$sheet->appendRow(array('Academic Year :'.$request_input[2]))->mergeCells('A5:E5',function($cell){
	    			$cell->setFontWeight('bold');
	    			$cell->setFontSize(18);
	    			$cell->setAlignment('left');
	    			$cell->setValignment('middle');
	    		});
	    		
	 			for($i = 0; $i < count($detail); $i++) {

					if($detail[$i]['location'] == "Rural") {
						$rural_level[] = $detail[$i]['school_level'];
					}

					if($detail[$i]['location'] == "Urban") {
						$urban_level[] = $detail[$i]['school_level'];
					}

				}

			
				if(isset($rural_level)) {
					$rural_levels = array_values(array_unique($rural_level));
				}
				
				if(isset($urban_level)) {
					$urban_levels = array_values(array_unique($urban_level));
				}

			$count=$sheet->getHighestRow()+1;
				$sheet->appendRow(array('Location : Rural'))->mergeCells('A'.$count.':E'.$count,function($cell){
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
				$sheet->appendRow(array('School Level :'.$rural_levels[$k]))->mergeCells('A'.$count.':E'.$count,function($cell){
				$cell->setFontWeight('bold');
	    		$cell->setFontSize(18);
	    		$cell->setAlignment('left');
	    		$cell->setValignment('middle');
			});

		$sheet->appendRow(array('School No','School Name','Total Students','Permanent + Temp Classroom','Student Per Classroom Ratio'));

	
		for($c = 0; $c < count($detail); $c++)
		 {
			/*for ($p=0; $p < count($se_posts) ; $p++) 
			{*/
				if($detail[$c]['location'] == "Rural" && $detail[$c]['school_level'] == $rural_levels[$k]) 
				{
					/*if($sc_posts[$c]['school_id'] == $se_posts[$p]['school_id']) 
					{*/

						$count=$sheet->getHighestRow()+1;
						$sheet->cell('A'.$count,function($cell) use($detail,$c){
		    				$cell->setValue($detail[$c]['school_no']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
				    	$sheet->cell('B'.$count,function($cell) use($detail,$c){
		    				$cell->setValue($detail[$c]['school_name']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
				    	$sheet->cell('C'.$count,function($cell) use($detail,$c){
		    				$cell->setValue($detail[$c]['boys']+$detail[$c]['girls']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
						$sheet->cell('D'.$count,function($cell) use($detail,$c){

		    				$cell->setValue((isset($detail[$c]['class']))? $detail[$c]['class']:'-');
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
						$sheet->cell('E'.$count,function($cell) use($detail,$c){
							if (isset($detail[$c]['class'])) {
								$ratio[]=(int)($detail[$c]['boys']+$detail[$c]['girls'])/$detail[$c]['class'];
							}
							else
							{
								$ratio[]='-';
							}
		    				$cell->setValue($ratio[0]);
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
	$sheet->appendRow(array('Location : Urban'))->mergeCells('A'.$count.':E'.$count,function($cell){
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
				$sheet->appendRow(array('School Level :'.$urban_levels[$l]))->mergeCells('A'.$count.':E'.$count,function($cell){
				$cell->setFontWeight('bold');
	    		$cell->setFontSize(18);
	    		$cell->setAlignment('left');
	    		$cell->setValignment('middle');
			});

		$sheet->appendRow(array('School No','School Name','Total Students','Permanent + Temp Classroom','Student Per Classroom Ratio'));

		for($c = 0; $c < count($detail); $c++) 
		{
			if($detail[$c]['location'] == "Urban" && $detail[$c]['school_level'] == $urban_levels[$l]) 
				{
						$count=$sheet->getHighestRow()+1;
						$sheet->cell('A'.$count,function($cell) use($detail,$c){
		    				$cell->setValue($detail[$c]['school_no']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
				    	$sheet->cell('B'.$count,function($cell) use($detail,$c){
		    				$cell->setValue($detail[$c]['school_name']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
				    	$sheet->cell('C'.$count,function($cell) use($detail,$c){
		    				$cell->setValue($detail[$c]['boys']+$detail[$c]['girls']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
						$sheet->cell('D'.$count,function($cell) use($detail,$c){

		    				$cell->setValue((isset($detail[$c]['class']))? $detail[$c]['class']:'-');
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
						$sheet->cell('E'.$count,function($cell) use($detail,$c){
							if (isset($detail[$c]['class'])) {
								$ratio[]=(int)($detail[$c]['boys']+$detail[$c]['girls'])/$detail[$c]['class'];
							}
							else
							{
								$ratio[]='-';
							}
		    				$cell->setValue($ratio[0]);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
				
						//}
					}
				
			} 

		}
	}
			$sheet->setBorder('A1'.':E'.$sheet->getHighestRow(), 'thin');

	    	});

			 })->download('xlsx');
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
