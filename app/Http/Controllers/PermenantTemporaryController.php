<?php
namespace App\Http\Controllers;

use Redirect;
use Input;
use Exception;
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
		try {

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
			
			$classroom = DB::select(DB::raw("SELECT s.location, s.school_level, SUM(st.total_boy) AS boys, SUM(st.total_girl) AS girls, (SUM(DISTINCT b.permanent_wall) + SUM(DISTINCT b.temporary_wall)) AS class FROM student_intake AS st INNER JOIN v_school AS s ON s.school_id = st.school_id AND s.school_year = st.school_year AND s.state_divsion_id = '".$state_id."' AND (s.township_id = '".$township_id."' OR '' = '".$township_id."') AND s.school_year = '".$academic_year."' LEFT JOIN school_building AS b ON b.school_id = st.school_id AND b.school_year = st.school_year GROUP BY s.school_level_id, s.location ORDER BY s.school_level_id"));

			if(count($classroom)) {

				return view('students.classroom', compact('classroom', 'region'));

			} else {

				$error = "There is no data in this State or Townshiip.";
				return view('students.classroom', compact('error'));

			}	

			$err = "This is no data.";
			throw new Exception($err);
		
		} catch (Exception $e) {

			$error = "There is no data";
			return view('students.classroom', compact('error'));

		}

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
		
		try{
			
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
			

			$classroom = DB::select(DB::raw("SELECT s.location, s.school_level, SUM(DISTINCT st.total_boy) AS boys, SUM(DISTINCT st.total_girl) AS girls, (SUM(DISTINCT b.permanent_wall) + SUM(DISTINCT b.temporary_wall)) AS class FROM student_intake AS st INNER JOIN v_school AS s ON s.school_id = st.school_id AND s.school_year = st.school_year AND s.state_divsion_id = '".$state_id."' AND (s.township_id = '".$township_id."' OR '' = '".$township_id."') AND s.school_year = '".$academic_year."' LEFT JOIN school_building AS b ON b.school_id = st.school_id AND b.school_year = st.school_year GROUP BY s.school_level_id, s.location ORDER BY s.school_level_id"));

			foreach ($classroom as $class) {
				$classes[]=get_object_vars($class);
			}
			
			$state_naem=DB::select(DB::raw("SELECT state_division FROM state_division WHERE id=".Input::get('state_id')));

			if(Input::get('township_id')){
				$township_name=DB::select(DB::raw("SELECT township_name FROM township WHERE id=".Input::get('township_id')));
			}

			$request_input=array($state_naem[0]->state_division,isset($township_name[0]->township_name)? $township_name[0]->township_name:'ALL',Input::get('academic_year'));
			Excel::create('Permenent+Temp Classroom', function($excel) use($classes,$request_input){

	    	$excel->sheet('Permenent+Temp Classroom', function($sheet) use($classes,$request_input){

	    		//$sheet->fromArray($post[0]);
	    		$sheet->prependRow(array('Township Education Management Information System'))->mergeCells('A1:D1',function($cells){
	    				
	    				$cells->setFontSize(14);
	    				$cells->setAlignment('center');
	    				$cells->setValignment('middle');
	    			});
	    		$sheet->appendRow(array('Students /Permenent & Temporary Classroom Ratio Report'))->mergeCells('A2:D2',function($cells){
	    				
	    				$cells->setFontSize(14);
	    				$cells->setAlignment('center');
	    				 $cells->setValignment('middle');
	    			});
	    		$sheet->appendRow(array('Division : '.$request_input[0]))->mergeCells('A3:D3',function($cells){
	    			
	    				$cells->setFontSize(14);
	    				$cells->setAlignment('left');
	    				 $cells->setValignment('middle');
	    		});
	    		$sheet->appendRow(array('Township : '.$request_input[1]))->mergeCells('A4:D4',function($cell){
	    			
	    				$cell->setFontSize(11);
	    				$cell->setAlignment('right');
	    				$cell->setValignment('middle');
	    		});
	    		$sheet->appendRow(array('Academic Year :'.$request_input[2]))->mergeCells('A5:D5',function($cell){
	    			
	    			$cell->setFontSize(14);
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
	    		
			$sheet->appendRow(array('Location :Rural'))->mergeCells('A6:D6',function($cell){
	    		$cell->setFontSize(14);
	    		$cell->setAlignment('left');
	    		$cell->setValignment('middle');
	    	});
				
			$sheet->appendRow(array('School Level','Total Students','Permanent + Temp Classroom','Ratio'));

			for($k = 0; $k < count($rural_levels); $k++){	
				for($c=0;$c<count($classes);$c++){
					if($classes[$c]['location'] == "Rural" && $classes[$c]['school_level'] == $rural_levels[$k]){
						$count=$sheet->getHighestRow()+1;
						
			    		$sheet->cell('A'.$count,function($cell) use($rural_levels,$k){
			    			$cell->setValue($rural_levels[$k]);
			    			$cell->setFontSize(14);
			    			$cell->setAlignment('left');
			    			$cell->setValignment('middle');
			    		});
			    		
						$totalstd =$classes[$c]['boys'] + $classes[$c]['girls'];
						$sheet->cell('B'.$count,function($cell) use($totalstd){
			    			$cell->setValue($totalstd);
			    			$cell->setFontSize(14);
			    			$cell->setAlignment('left');
			    			$cell->setValignment('middle');
						});
		    			
		    			$sheet->cell('C'.$count,function($cell) use($classes,$c){
	    					$cell->setValue(($classes[$c]['class'])? $classes[$c]['class']:'-');
	    					$cell->setFontSize(14);
	    					$cell->setAlignment('left');
	   						$cell->setValignment('middle');
	   					});	
																	
						$sheet->cell('D'.$count,function($cell)use($classes,$c) {
							$totalstd =$classes[$c]['boys'] + $classes[$c]['girls'];	
				    		$cell->setValue(($classes[$c]['class'])? round(($totalstd/$classes[$c]['class']), 2):'-');
				    		$cell->setFontSize(14);
				    		$cell->setAlignment('left');
			    			$cell->setValignment('middle');
			    		});						 
					}
				}
			}
			//<!-- Stat Urban -->
			$sheet->appendRow(array('Location :Urban'))->mergeCells('A6:D6',function($cell){
	    		$cell->setFontSize(14);
	    		$cell->setAlignment('left');
	    		$cell->setValignment('middle');
	    	});
				
			$sheet->appendRow(array('School Level','Total Students','Permanent + Temp Classroom','Ratio'));

			for($k = 0; $k < count($urban_levels); $k++){	
				for($c=0;$c<count($classes);$c++){
					if($classes[$c]['location'] == "Urban" && $classes[$c]['school_level'] == $urban_levels[$k]){
						$count=$sheet->getHighestRow()+1;
						
			    		$sheet->cell('A'.$count,function($cell) use($urban_levels,$k){
			    			$cell->setValue($urban_levels[$k]);
			    			$cell->setFontSize(14);
			    			$cell->setAlignment('left');
			    			$cell->setValignment('middle');
			    		});
			    		
						$totalstd =$classes[$c]['boys'] + $classes[$c]['girls'];
						$sheet->cell('B'.$count,function($cell) use($totalstd){
			    			$cell->setValue($totalstd);
			    			$cell->setFontSize(14);
			    			$cell->setAlignment('left');
			    			$cell->setValignment('middle');
						});
		    			
		    			$sheet->cell('C'.$count,function($cell) use($classes,$c){
	    					$cell->setValue(($classes[$c]['class'])? $classes[$c]['class']:'-');
	    					$cell->setFontSize(14);
	    					$cell->setAlignment('left');
	   						$cell->setValignment('middle');
	   					});	
																	
						$sheet->cell('D'.$count,function($cell)use($classes,$c) {
							$totalstd =$classes[$c]['boys'] + $classes[$c]['girls'];	
				    		$cell->setValue(($classes[$c]['class'])? round(($totalstd/$classes[$c]['class']), 2):'-');
				    		$cell->setFontSize(14);
				    		$cell->setAlignment('left');
			    			$cell->setValignment('middle');
			    		});						 
					}
				}
			}

			$sheet->setBorder('A1'.':D'.$sheet->getHighestRow(), 'thin');
		});

			 })->download('xlsx');

			$err = "This is no data.";
			throw new Exception($err);
		
		}

		catch(Exception $e){
			$error = "There is no data.";
			return view('students.classroom', compact('error'));
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
