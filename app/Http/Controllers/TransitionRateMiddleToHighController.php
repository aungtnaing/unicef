<?php
namespace App\Http\Controllers;

use Input;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

class TransitionRateMiddleToHighController extends Controller {
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

			$current_year = DB::select(DB::raw("SELECT SUM(a.new_boy + a.new_girl) AS current_total_std, t.township_name, t.id FROM student_intake AS a INNER JOIN v_school AS s ON s.school_id = a.school_id AND s.school_year = a.school_year INNER JOIN township AS t ON t.id = s.township_id WHERE a.school_year = '".Input::get('academic_year')."' AND a.grade='10' AND s.state_divsion_id = ".Input::get('state_id')." AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') GROUP BY s.township_id"));
			
			$previous_year = DB::select(DB::raw("SELECT SUM(a.total_boy + a.total_girl) AS previous_total_std, t.township_name, t.id FROM student_intake AS a INNER JOIN v_school AS s ON s.school_id = a.school_id AND s.school_year = a.school_year INNER JOIN township AS t ON t.id = s.township_id WHERE a.school_year = '".Input::get('previous_year')."' AND a.grade='09' AND s.state_divsion_id = ".Input::get('state_id')." AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') GROUP BY s.township_id"));

			if(count($current_year) && count($previous_year)) {
				
				return view('student_flow_rate.transition_rate_middle_to_high', compact('current_year','previous_year','region'));
				
			} else {
				
				$error = "There is no data in this State or Townshiip.";
				return view('student_flow_rate.transition_rate_middle_to_high', compact('error'));
			
			}

			$err = "There is no data.";
			throw new Exception($err);

		} catch (Exception $e) {

			$error = "There is no data.";
			return view('student_flow_rate.transition_rate_middle_to_high', compact('error'));

		}	
	}	


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('student_flow_rate.transition_rate_middle_to_high');
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
		try {
			
			if(Input::get('township_id')) {

				$q = "SELECT state_division, township_name";
			
			} else {
			
				$q = "SELECT state_division";
			
			}

			$q .= " FROM v_state_township WHERE state_id = ".Input::get('state_id')." AND (township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') GROUP BY state_id";

			$region = DB::select(DB::raw($q));

			$current_year = DB::select(DB::raw("SELECT SUM(a.new_boy + a.new_girl) AS current_total_std, t.township_name, t.id FROM student_intake AS a INNER JOIN v_school AS s ON s.school_id = a.school_id AND s.school_year = a.school_year INNER JOIN township AS t ON t.id = s.township_id WHERE a.school_year = '".Input::get('academic_year')."' AND a.grade='10' AND s.state_divsion_id = ".Input::get('state_id')." AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') GROUP BY s.township_id"));
			
			$previous_year = DB::select(DB::raw("SELECT SUM(a.total_boy + a.total_girl) AS previous_total_std, t.township_name, t.id FROM student_intake AS a INNER JOIN v_school AS s ON s.school_id = a.school_id AND s.school_year = a.school_year INNER JOIN township AS t ON t.id = s.township_id WHERE a.school_year = '".Input::get('previous_year')."' AND a.grade='9' AND s.state_divsion_id = ".Input::get('state_id')." AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') GROUP BY s.township_id"));

			foreach ($current_year as $current) 
			{
				$current_years[]=get_object_vars($current);
			}

			foreach ($previous_year as $previous) {
				$previous_years[]=get_object_vars($previous);
			}
			
			$state_name=DB::select(DB::raw("SELECT state_division FROM state_division WHERE id=".Input::get('state_id')));

			if(Input::get('township_id')){
				$township_name=DB::select(DB::raw("SELECT township_name FROM township WHERE id=".Input::get('township_id')));	
			}
			$request_input=array($state_name[0]->state_division,isset($township_name[0]->township_name)? $township_name[0]->township_name:'ALL',Input::get('academic_year'));

			Excel::create('TRMHS', function($excel) use($current_years,$previous_years,$request_input){

	    	$excel->sheet('TRMHS', function($sheet) use($current_years,$previous_years,$request_input){

	    		//$sheet->fromArray($post[0]);
	    		$sheet->prependRow(array('Township Education Management Information System'))->mergeCells('A1:D1',function($cells){
	    				$cells->setFontWeight('bold');
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('center');
	    				 $cells->setValignment('middle');
	    			});
	    		$sheet->appendRow(array('Transition Rate from Middle to High School Level (TRMHS)'))->mergeCells('A2:D2',function($cells){
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
	    		
	    		

			$sheet->appendRow(array('Township Name','Successful completers in Grade 9 in the previous school-year','New entrants to Grade 10 in current school-year','Transition Rate'));

	    	for($c = 0; $c < count($current_years); $c++) 
	    	{
				for ($p=0; $p < count($previous_years) ; $p++)
				 {
					// if($current_years[$c]['location'] == "Rural" && $previous_years[$p]['location'] == "Rural")
					// 	{
							$count=$sheet->getHighestRow()+1;
							if($current_years[$c]['id'] == $previous_years[$p]['id']) {
							$count=$sheet->getHighestRow()+1;

							$sheet->cell('A'.$count,function($cell) use($current_years,$c){
		    					$cell->setValue($current_years[$c]['township_name']);
				    			$cell->setFontSize(12);
				    			$cell->setAlignment('left');
				    			$cell->setValignment('middle');
				    		});
				    		$sheet->cell('B'.$count,function($cell) use($previous_years,$p){
		    					$cell->setValue($previous_years[$p]['previous_total_std']);
				    			$cell->setFontSize(12);
				    			$cell->setAlignment('left');
				    			$cell->setValignment('middle');
				    		});
				    		$sheet->cell('C'.$count,function($cell) use($current_years,$c){
		    					$cell->setValue($current_years[$c]['current_total_std']);
				    			$cell->setFontSize(12);
				    			$cell->setAlignment('left');
				    			$cell->setValignment('middle');
				    		});
				    		$sheet->cell('D'.$count,function($cell) use($current_years,$previous_years,$p,$c){
		    					$cell->setValue(round($current_years[$c]['current_total_std']/$previous_years[$p]['previous_total_std'] * 100,2));
				    			$cell->setFontSize(12);
				    			$cell->setAlignment('left');
				    			$cell->setValignment('middle');
				    		});
					
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
			return view('student_flow_rate.transition_rate_middle_to_high', compact('error'));

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
