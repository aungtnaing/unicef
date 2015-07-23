<?php
namespace App\Http\Controllers;

use Redirect;
use Input;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermenantTemporaryController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		$state_id = Input::get('state_id');
		$township_id = Input::get('township_id');
		$academic_year = Input::get('academic_year');
			
			if(isset($township_id)) {

				$q = "SELECT *";
			
			} else {
			
				$q = "SELECT state_id, state_division";
			
			}
		
			$q .= " FROM v_state_township WHERE (state_id = '".$state_id."' OR ''='".$state_id."') AND (township_id = '".$township_id."' OR '' = '".$township_id."') GROUP BY state_id";
			
			$region = DB::select(DB::raw($q));
			
			$classroom = DB::select(DB::raw("SELECT s.location, s.school_level, s.school_level_id, SUM(st.total_boy) AS boys, SUM(st.total_girl) AS girls FROM v_school AS s INNER JOIN student_intake AS st ON s.school_id = st.school_id AND s.school_year = st.school_year WHERE (s.state_divsion_id = '".$state_id."' OR '' = '".$state_id."') AND (s.township_id = '".$township_id."' OR '' = '".$township_id."') AND s.school_year = '".$academic_year."' GROUP BY s.school_level, s.location ORDER BY s.sort_code ASC"));

			foreach ($classroom as $class) {
				
				if($class->location == "Rural") {
					$rural_level_id[] = $class->school_level_id;
				}

				if($class->location == "Urban") {
					$urban_level_id[] = $class->school_level_id;
				}
			}
			
			$rural_levels_id = "'".implode("','", $rural_level_id)."'";
			$urban_levels_id = "'".implode("','", $urban_level_id)."'";
			
			$rural_walls = DB::select(DB::raw("SELECT (SUM(b.permanent_wall) + SUM(b.temporary_wall)) AS rooms, v.school_level_id FROM school_building AS b INNER JOIN v_school AS v ON v.school_id = b.school_id AND v.school_year = b.school_year WHERE v.school_level_id IN ({$rural_levels_id}) AND (v.state_divsion_id = '".$state_id."') AND (v.township_id = '".$township_id."' OR '' = '".$township_id."') AND v.school_year = '".$academic_year."' GROUP BY v.school_level_id"));

			$urban_walls = DB::select(DB::raw("SELECT (SUM(b.permanent_wall) + SUM(b.temporary_wall)) AS rooms, v.school_level_id FROM school_building AS b INNER JOIN v_school AS v ON v.school_id = b.school_id AND v.school_year = b.school_year WHERE v.school_level_id IN ({$urban_levels_id}) AND (v.state_divsion_id = '".$state_id."') AND (v.township_id = '".$township_id."' OR '' = '".$township_id."') AND v.school_year = '".$academic_year."' GROUP BY v.school_level_id"));
		
			return view('students.classroom', compact('classroom', 'rural_walls', 'urban_walls', 'region'));	
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{ 
		
		return view('students.classroom');
		
		
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
		
		//try{
				
		$state_id = Input::get('state_id');
		$township_id = Input::get('township_id');
		$academic_year = Input::get('academic_year');
		 
		if($township_id) {

			$q = "SELECT *";
		
		} else {
		
			$q = "SELECT state_id, state_division";
		
		}
	
		$q .= " FROM v_state_township WHERE state_id = ".$state_id." AND (township_id = '".$township_id."' OR '' = '".$township_id."') GROUP BY state_id";
		
		$region = DB::select(DB::raw($q));
		

		$classroom = DB::select(DB::raw("SELECT s.location, s.school_level, s.school_level_id, SUM(st.total_boy) AS boys, SUM(st.total_girl) AS girls FROM v_school AS s INNER JOIN student_intake AS st ON s.school_id = st.school_id AND (s.state_divsion_id = '".$state_id."' OR '' = '".$state_id."') AND (s.township_id = '".$township_id."' OR '' = '".$township_id."') AND s.school_year = '".$academic_year."' GROUP BY s.school_level, s.location ORDER BY s.sort_code ASC"));

		foreach ($classroom as $class) {
			$classes[]=get_object_vars($class);
			if($class->location == "Rural") {
				$rural_level_id[] = $class->school_level_id;
			}

			if($class->location == "Urban") {
				$urban_level_id[] = $class->school_level_id;
			}
		}
		
		$rural_levels_id = "'".implode("','", $rural_level_id)."'";
		$urban_levels_id = "'".implode("','", $urban_level_id)."'";
		
		$rural_walls = DB::select(DB::raw("SELECT (SUM(b.permanent_wall) + SUM(b.temporary_wall)) AS rooms, v.school_level_id FROM school_building AS b INNER JOIN v_school AS v ON v.school_id = b.school_id AND v.school_level_id IN ({$rural_levels_id}) AND (v.state_divsion_id = '".$state_id."' OR '' = '".$state_id."') AND (v.township_id = '".$township_id."' OR '' = '".$township_id."') AND v.school_year = '".$academic_year."' GROUP BY v.school_level_id"));

		$urban_walls = DB::select(DB::raw("SELECT (SUM(b.permanent_wall) + SUM(b.temporary_wall)) AS rooms, v.school_level_id FROM school_building AS b INNER JOIN v_school AS v ON v.school_id = b.school_id AND v.school_level_id IN ({$urban_levels_id}) AND (v.state_divsion_id = '".$state_id."' OR '' = '".$state_id."') AND (v.township_id = '".$township_id."' OR '' = '".$township_id."') AND v.school_year = '".$academic_year."' GROUP BY v.school_level_id"));

		foreach ($rural_walls as $rural_wall) {
			$rural_building[]=get_object_vars($rural_wall);
		}

		foreach ($urban_walls as $urban_wall) {
			$urban_building[]=get_object_vars($urban_wall);
		}

		$state_naem=DB::select(DB::raw("SELECT state_division FROM state_division WHERE id=".Input::get('state_id')));

		if(Input::get('township_id')){
			$township_name=DB::select(DB::raw("SELECT township_name FROM township WHERE id=".Input::get('township_id')));
		}

		$request_input=array($state_naem[0]->state_division,isset($township_name[0]->township_name)? $township_name[0]->township_name:'ALL',Input::get('academic_year'));
		Excel::create('Permenent+Temp Classroom', function($excel) use($classes,$rural_building,$urban_building,$request_input){

    	$excel->sheet('Permenent+Temp Classroom', function($sheet) use($classes,$rural_building,$urban_building,$request_input){

    		//$sheet->fromArray($post[0]);
    		$sheet->prependRow(array('Township Education Management Information System'))->mergeCells('A1:E1',function($cells){
    				
    				$cells->setFontSize(18);
    				$cells->setAlignment('center');
    				$cells->setValignment('middle');
    			});
    		$sheet->appendRow(array('Students /Permenent & Temporary Classroom Ratio Report'))->mergeCells('A2:E2',function($cells){
    				
    				$cells->setFontSize(18);
    				$cells->setAlignment('center');
    				 $cells->setValignment('middle');
    			});
    		$sheet->appendRow(array('Division : '.$request_input[0]))->mergeCells('A3:E3',function($cells){
    			
    				$cells->setFontSize(18);
    				$cells->setAlignment('left');
    				 $cells->setValignment('middle');
    		});
    		$sheet->appendRow(array('Township : '.$request_input[1]))->mergeCells('A4:E4',function($cell){
    			
    				$cell->setFontSize(11);
    				$cell->setAlignment('right');
    				$cell->setValignment('middle');
    		});
    		$sheet->appendRow(array('Academic Year :'.$request_input[2]))->mergeCells('A5:E5',function($cell){
    			
    			$cell->setFontSize(18);
    			$cell->setAlignment('left');
    			$cell->setValignment('middle');
    		});
    		for($i = 0; $i < count($classes); $i++) {

			if($classes[$i]['location'] == "Rural") {
				$rural_level[] = $classes[$i]['school_level'];
			}

			if($classes[$i]['location'] == "Urban") {
				$urban_level[] = $classes[$i]['school_level'];
			}

		}

		$rural_levels = array_values(array_unique($rural_level));
		$urban_levels = array_values(array_unique($urban_level));
    		
		// print_r($rural_levels);
			$sheet->appendRow(array('Location :Rural'))->mergeCells('A6:E6',function($cell){
    			
    			$cell->setFontSize(18);
    			$cell->setAlignment('left');
    			$cell->setValignment('middle');
    		});
			
		$sheet->appendRow(array('School Level','Total Students','Permanent + Temp Classroom','Ratio','School Level ID'));

		//$count=$sheet->getHighestRow()+1;
					
		 for($k = 0; $k < count($rural_levels); $k++){	
			for($c=0;$c<count($classes);$c++){
				if($classes[$c]['location'] == "Rural" && $classes[$c]['school_level'] == $rural_levels[$k]){
					$count=$sheet->getHighestRow()+1;
					
		    		$sheet->cell('A'.$count,function($cell) use($rural_levels,$k){
		    			//$cell->setValue('test1');
		    			$cell->setValue($rural_levels[$k]);
		    			
		    			$cell->setFontSize(18);
		    			$cell->setAlignment('left');
		    			$cell->setValignment('middle');
		    		});
		    		
					$totalstd =$classes[$c]['boys'] + $classes[$c]['girls'];
					//$count=$sheet->getHighestRow()+1;
					$sheet->cell('B'.$count,function($cell) use($totalstd){
		    			$cell->setValue($totalstd);
		    			$cell->setFontSize(18);
		    			$cell->setAlignment('left');
		    			$cell->setValignment('middle');
					});
						for ($w=0; $w < count($rural_building); $w++) { 
							if($rural_building[$w]['school_level_id'] == $classes[$c]['school_level_id']){
				    			//$sheet->cell(array($post[$i]['school_level'],$post[$i]['TotalSchools']));
				    			$sheet->cell('C'.$count,function($cell) use($rural_building,$w){
			    					$cell->setValue($rural_building[$w]['rooms']);
			    					$cell->setFontSize(18);
			    					$cell->setAlignment('left');
		    						$cell->setValignment('middle');
		    					});	
																
								if($rural_building[$w]['rooms']){
									$ratio=round($totalstd/$rural_building[$w]['rooms'],2);
									$sheet->cell('D'.$count,function($cell)use($ratio) {
			    					$cell->setValue($ratio);
			    					$cell->setFontSize(18);
			    					$cell->setAlignment('left');
		    						$cell->setValignment('middle');
		    					});	
									
								}
								
							}
						}

						$sheet->cell('E'.$count,function($cell)use($classes,$c){
			    					$cell->setValue($classes[$c]['school_level_id']);
			    					$cell->setFontSize(18);
			    					$cell->setAlignment('left');
		    						$cell->setValignment('middle');
		    					});	
				 
			}
		}
	
		}
		//<!-- Stat Urban -->
		$count=$sheet->getHighestRow()+1;
		$sheet->appendRow(array('Location :Urban'))->mergeCells('A'.$count.':E'.$count,function($cell){
    			$cell->setFontWeight('bold');
    			$cell->setFontSize(18);
    			$cell->setAlignment('left');
    			$cell->setValignment('middle');
    		});
			
		$sheet->appendRow(array('School Level','Total Students','Permanent + Temp Classroom','Ratio','School Level ID'));

		for($l = 0; $l < count($urban_levels); $l++){
			for($c=0;$c<count($classes);$c++){
				if($classes[$c]['location'] == "Urban" && $classes[$c]['school_level'] == $urban_levels[$l]){
						$count=$sheet->getHighestRow()+1;
					
		    		$sheet->cell('A'.$count,function($cell) use($urban_levels,$l){
		    			//$cell->setValue('test1');
		    			$cell->setValue($urban_levels[$l]);
		    			$cell->setFontSize(18);
		    			$cell->setAlignment('left');
		    			$cell->setValignment('middle');
		    		});
		    		
					$totalstd =$classes[$c]['boys'] + $classes[$c]['girls'];
					//$count=$sheet->getHighestRow()+1;
					$sheet->cell('B'.$count,function($cell) use($totalstd){
		    			$cell->setValue($totalstd);
		    			$cell->setFontSize(18);
		    			$cell->setAlignment('left');
		    			$cell->setValignment('middle');
					});
						
						for ($w=0; $w < count($urban_building); $w++) { 
							if($urban_building[$w]['school_level_id'] == $classes[$c]['school_level_id']){
				    			//$sheet->cell(array($post[$i]['school_level'],$post[$i]['TotalSchools']));
				    			$sheet->cell('C'.$count,function($cell) use($urban_building,$w){
			    					$cell->setValue($urban_building[$w]['rooms']);
			    					$cell->setFontSize(18);
			    					$cell->setAlignment('left');
		    						$cell->setValignment('middle');
		    					});	
																
								if($urban_building[$w]['rooms']){
									$ratio=round($totalstd/$urban_building[$w]['rooms'],2);
									$sheet->cell('D'.$count,function($cell)use($ratio) {
			    					$cell->setValue($ratio);
			    					$cell->setFontSize(18);
			    					$cell->setAlignment('left');
		    						$cell->setValignment('middle');
		    					});	
									
								}
								
							}
						}
						$sheet->cell('E'.$count,function($cell)use($classes,$c){
			    					$cell->setValue($classes[$c]['school_level_id']);
			    					$cell->setFontSize(18);
			    					$cell->setAlignment('left');
		    						$cell->setValignment('middle');
		    					});	

					}
			}
		}

		$sheet->setBorder('A1'.':E'.$sheet->getHighestRow(), 'thin');
	});

		 })->download('xlsx');
		
		//}

		/*catch(\Exception $ex){
			echo "<script type='text/javascript'>alert('Please Choose State/Division At First')</script>";
			return Redirect::route('calssroom');
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
