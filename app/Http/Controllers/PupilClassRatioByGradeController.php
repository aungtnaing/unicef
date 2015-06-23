<?php
namespace App\Http\Controllers;

use Input;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PupilClassRatioByGradeController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		try {
			
			if(Input::get('township_id')) {

				$q = "SELECT *";
			
			} else {
			
				$q = "SELECT state_id, state_division";
			
			}

			$q .= " FROM v_state_township WHERE state_id = ".Input::get('state_id')." AND (township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') GROUP BY state_id";

			$region = DB::select(DB::raw($q));

			$sc = DB::select(DB::raw("SELECT a.grade, s.school_id, s.school_no, s.school_name, s.school_level, s.location, SUM(a.total_boy + a.total_girl) AS pupil_no FROM student_intake AS a INNER JOIN v_school AS s ON s.school_id = a.school_id INNER JOIN township AS t ON t.id = s.township_id AND a.school_year = '".Input::get('academic_year')."' AND a.grade= '".Input::get('grade')."' AND s.state_divsion_id = ".Input::get('state_id')." AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') GROUP BY s.school_id ORDER BY s.sort_code ASC"));

			$se = DB::select(DB::raw("SELECT s.school_id, s.school_no, s.school_name, s.school_level, s.location, COUNT(a.class) AS total_class FROM student_intake AS a INNER JOIN v_school AS s ON s.school_id = a.school_id INNER JOIN township AS t ON t.id = s.township_id AND a.school_year = '".Input::get('academic_year')."' AND a.grade= '".Input::get('grade')."' AND s.state_divsion_id = ".Input::get('state_id')." AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') GROUP BY s.school_id ORDER BY s.sort_code ASC"));

			return view('pupil_class_ratio.pupil_class_ratio_by_grade', compact('sc','se','region'));

		} catch (Exception $e) {
			
			$record = "There is no data.";
			return view('pupil_class_ratio.pupil_class_ratio_by_grade', compact('record','region'));
			 
		}
	
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('pupil_class_ratio.pupil_class_ratio_by_grade');
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
		//try {
			
			if(Input::get('township_id')) {

				$q = "SELECT state_division, township_name";
			
			} else {
			
				$q = "SELECT state_division";
			
			}

			$q .= " FROM v_state_township WHERE state_id = ".Input::get('state_id')." AND (township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') GROUP BY state_id";

			$region = DB::select(DB::raw($q));

			$sc = DB::select(DB::raw("SELECT s.school_id, s.school_no, s.school_name, s.school_level, s.location, SUM(a.total_boy + a.total_girl) AS pupil_no FROM student_intake AS a INNER JOIN v_school AS s ON s.school_id = a.school_id INNER JOIN township AS t ON t.id = s.township_id AND a.school_year = '".Input::get('academic_year')."' AND a.grade= '".Input::get('grade')."' AND s.state_divsion_id = ".Input::get('state_id')." AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') GROUP BY s.school_id ORDER BY s.sort_code ASC"));

			$se = DB::select(DB::raw("SELECT s.school_id, s.school_no, s.school_name, s.school_level, s.location, COUNT(a.class) AS total_class FROM student_intake AS a INNER JOIN v_school AS s ON s.school_id = a.school_id INNER JOIN township AS t ON t.id = s.township_id AND a.school_year = '".Input::get('academic_year')."' AND a.grade= '".Input::get('grade')."' AND s.state_divsion_id = ".Input::get('state_id')." AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') GROUP BY s.school_id ORDER BY s.sort_code ASC"));

			foreach ($sc as $sc_key) {
				$sc_keys[]=get_object_vars($sc_key);
			}

			foreach ($se as $se_key) {
				$se_keys[]=get_object_vars($se_key);
			}

			$state_naem=DB::select(DB::raw("SELECT state_division FROM state_division WHERE id=".Input::get('state_id')));

			if(Input::get('township_id'))
			{
				$township_name=DB::select(DB::raw("SELECT township_name FROM township WHERE id=".Input::get('township_id')));	
			}	

			$request_input=array($state_naem[0]->state_division,isset($township_name[0]->township_name)? $township_name[0]->township_name:'ALL',Input::get('academic_year'),Input::get('grade'));

			Excel::create('PupilClassRatioByGrade', function($excel) use($sc_keys,$se_keys,$request_input){

	    	$excel->sheet('PupilClassRatioByGrade', function($sheet) use($sc_keys,$se_keys,$request_input){

    		//$sheet->fromArray($post[0]);
	    		$sheet->prependRow(array('Township Education Management Information System'))->mergeCells('A1:E1',function($cells){
	    				$cells->setFontWeight('bold');
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('center');
	    				 $cells->setValignment('middle');
	    			});
	    		$sheet->appendRow(array('Pupil Class Ratio By Grade'))->mergeCells('A2:E2',function($cells){
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

	    		$sheet->appendRow(array('Grade '.$request_input[3]))->mergeCells('A6:E6',function($cell){
	    			$cell->setFontWeight('bold');
	    			$cell->setFontSize(18);
	    			$cell->setAlignment('left');
	    			$cell->setValignment('middle');
	    		});
	    		
	 			for($i = 0; $i < count($sc_keys); $i++) {

					if($sc_keys[$i]['location'] == "Rural") {
						$rural_level[] = $sc_keys[$i]['school_level'];
					}

					if($sc_keys[$i]['location'] == "Urban") {
						$urban_level[] = $sc_keys[$i]['school_level'];
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

		$sheet->appendRow(array('School No','School Name','Total Number of Pupils','Total Number of Classes or Sections','Pupil Class Ratio'));

	
		for($c = 0; $c < count($sc_keys); $c++)
		 {
			for ($p=0; $p < count($se_keys) ; $p++) 
			{
				if($sc_keys[$c]['location'] == "Rural"  && $se_keys[$p]['location'] == "Rural"  && $sc_keys[$c]['school_level'] == $rural_levels[$k]) 
				{
					if($sc_keys[$c]['school_id'] == $se_keys[$p]['school_id']) 
					{

						$count=$sheet->getHighestRow()+1;
						$sheet->cell('A'.$count,function($cell) use($sc_keys,$c){
		    				$cell->setValue($sc_keys[$c]['school_no']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
				    	$sheet->cell('B'.$count,function($cell) use($sc_keys,$c){
		    				$cell->setValue($sc_keys[$c]['school_name']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
				    	$sheet->cell('C'.$count,function($cell) use($sc_keys,$c){
		    				$cell->setValue($sc_keys[$c]['pupil_no']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
						$sheet->cell('D'.$count,function($cell) use($se_keys,$p){

		    				$cell->setValue($se_keys[$p]['total_class']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
						$sheet->cell('E'.$count,function($cell) use($sc_keys,$c,$se_keys,$p){
							$ratio=(int)($sc_keys[$c]['pupil_no']/$se_keys[$p]['total_class']);
		    				$cell->setValue($ratio);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
					}
				}
			}
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

		$sheet->appendRow(array('School No','School Name','Total Number of Pupils','Total Number of Classes or Sections','Pupil Class Ratio'));

		for($c = 0; $c < count($sc_keys); $c++)
		 {
			for ($p=0; $p < count($se_keys) ; $p++) 
			{
				if($sc_keys[$c]['location'] == "Rural"  && $se_keys[$p]['location'] == "Rural"  && $sc_keys[$c]['school_level'] == $urban_levels[$l]) 
				{
					if($sc_keys[$c]['school_id'] == $se_keys[$p]['school_id']) 
					{

						$count=$sheet->getHighestRow()+1;
						$sheet->cell('A'.$count,function($cell) use($sc_keys,$c){
		    				$cell->setValue($sc_keys[$c]['school_no']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
				    	$sheet->cell('B'.$count,function($cell) use($sc_keys,$c){
		    				$cell->setValue($sc_keys[$c]['school_name']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
				    	$sheet->cell('C'.$count,function($cell) use($sc_keys,$c){
		    				$cell->setValue($sc_keys[$c]['pupil_no']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
						$sheet->cell('D'.$count,function($cell) use($se_keys,$p){

		    				$cell->setValue($se_keys[$p]['total_class']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
						$sheet->cell('E'.$count,function($cell) use($sc_keys,$c,$se_keys,$p){
							$ratio=(int)($sc_keys[$c]['pupil_no']/$se_keys[$p]['total_class']);
							$cell->setValue($ratio);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
					}
				}
			}
		} 

		}
	}
			$sheet->setBorder('A1'.':E'.$sheet->getHighestRow(), 'thin');

	    	});

			 })->download('xlsx');
		/*} catch (Exception $e) {
			
			$record = "There is no data.";
			return view('pupil_class_ratio.pupil_class_ratio_by_grade', compact('record','region'));
			 
		}*/
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
