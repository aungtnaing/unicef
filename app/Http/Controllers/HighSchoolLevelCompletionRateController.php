<?php
namespace App\Http\Controllers;
use Input;
use Session;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class HighSchoolLevelCompletionRateController extends Controller {
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
		$pre_year=Input::get('previous_year');	
		
		try {
			
			if(isset($township_id)) {

				$q = "SELECT *";
			
			} else {
			
				$q = "SELECT state_id, state_division";
			
			}

			$q .= " FROM v_state_township WHERE state_id = ".$state_id." AND (township_id = '".$township_id."' OR '' = '".$township_id."') GROUP BY state_id";

			$region = DB::select(DB::raw($q));

			$current_year = DB::select(DB::raw("SELECT SUM(a.new_boy + a.new_girl) AS current_total_std, t.township_name, t.id FROM student_intake AS a INNER JOIN v_school AS s ON s.school_id = a.school_id AND s.school_year = a.school_year INNER JOIN township AS t ON t.id = s.township_id WHERE a.school_year = '".$academic_year."' and a.grade='11' AND s.state_divsion_id = ".$state_id." AND (s.township_id = '".$township_id."' OR '' = '".$township_id."') GROUP BY s.township_id"));
			
			$previous_year = DB::select(DB::raw("SELECT SUM(a.total_boy + a.total_girl) AS previous_total_std, t.township_name, t.id FROM student_intake AS a INNER JOIN v_school AS s ON s.school_id = a.school_id AND s.school_year = a.school_year INNER JOIN township AS t ON t.id = s.township_id WHERE a.school_year = '".$pre_year."' AND a.grade='10' AND s.state_divsion_id = ".$state_id." AND (s.township_id = '".$township_id."' OR '' = '".$township_id."') GROUP BY s.township_id"));

			return view('student_flow_rate.high_school_level_completion_rate', compact('current_year','previous_year','region'));
		
		} catch (Exception $e) {
			
			$record = "There is no data.";
			return view('student_flow_rate.high_school_level_completion_rate', compact('record','region')); 
					
		}
		
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
		return view('student_flow_rate.high_school_level_completion_rate');
		
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
			
			$state_id = Input::get('state_id');
			$township_id = Input::get('township_id');
			$academic_year = Input::get('academic_year');
			$pre_year=Input::get('previous_year');	
		
				
			if(isset($township_id)) {

				$q = "SELECT *";
			
			} else {
			
				$q = "SELECT state_id, state_division";
			
			}

			$q .= " FROM v_state_township WHERE state_id = ".$state_id." AND (township_id = '".$township_id."' OR '' = '".$township_id."') GROUP BY state_id";

			$region = DB::select(DB::raw($q));

			$current_year = DB::select(DB::raw("SELECT SUM(a.new_boy + a.new_girl) AS current_total_std, t.township_name, t.id FROM student_intake AS a INNER JOIN v_school AS s ON s.school_id = a.school_id AND s.school_year = a.school_year INNER JOIN township AS t ON t.id = s.township_id WHERE a.school_year = '".$academic_year."' and a.grade='11' AND s.state_divsion_id = ".$state_id." AND (s.township_id = '".$township_id."' OR '' = '".$township_id."') GROUP BY s.township_id"));
			
			$previous_year = DB::select(DB::raw("SELECT SUM(a.total_boy + a.total_girl) AS previous_total_std, t.township_name, t.id FROM student_intake AS a INNER JOIN v_school AS s ON s.school_id = a.school_id AND s.school_year = a.school_year INNER JOIN township AS t ON t.id = s.township_id WHERE a.school_year = '".$pre_year."' AND a.grade='10' AND s.state_divsion_id = ".$state_id." AND (s.township_id = '".$township_id."' OR '' = '".$township_id."') GROUP BY s.township_id"));
			foreach ($current_year as $current) 
			{
				$current_years[]=get_object_vars($current);
			}

			foreach ($previous_year as $previous) {
				$previous_years[]=get_object_vars($previous);
			}
			
			$state_name=DB::select(DB::raw("SELECT state_division FROM state_division WHERE id=".$state_id));

			if(isset($township_id)){
				$township_name=DB::select(DB::raw("SELECT township_name FROM township WHERE id=".$township_id));	
			}
			$request_input=array($state_name[0]->state_division,isset($township_name[0]->township_name)? $township_name[0]->township_name:'ALL',$academic_year);

			Excel::create('HighSchoolCompletionRate', function($excel) use($current_years,$previous_years,$request_input){

	    	$excel->sheet('HighSchoolCompletionRate', function($sheet) use($current_years,$previous_years,$request_input){

	    		//$sheet->fromArray($post[0]);
	    		$sheet->prependRow(array('Township Education Management Information System'))->mergeCells('A1:D1',function($cells){
	    				$cells->setFontWeight('bold');
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('center');
	    				 $cells->setValignment('middle');
	    			});
	    		$sheet->appendRow(array('Completion Rate : High School Level'))->mergeCells('A2:D2',function($cells){
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
	    		
	    		

				$sheet->appendRow(array('Township Name','Enrolment in Grade 10 in previous year','Successful completers in Grade 11 in current year','Completion Rate'));
	    	for($c = 0; $c < count($current_years); $c++) 
	    	{
				for ($p=0; $p < count($previous_years) ; $p++)
				 {
					
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
				    			if ($current_years[$c]['current_total_std']!=0 && $previous_years[$p]['previous_total_std']!=0) {
				    				$ratio=round($current_years[$c]['current_total_std']/$previous_years[$p]['previous_total_std'] * 100,2);
				    			}
				    			else
				    			{
				    				$ratio='-';
				    			}
		    					$cell->setValue($ratio);
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
		
		} catch (Exception $e) {
			
			$record = "There is no data.";
			return view('student_flow_rate.high_school_level_completion_rate', compact('record','region')); 
					
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
