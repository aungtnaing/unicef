<?php namespace App\Http\Controllers;

use Redirect;
use Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RepetitionRateController extends Controller {

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

			$repeater = DB::select(DB::raw("SELECT intake.grade, (SUM(repeat_boy) + SUM(repeat_girl)) AS repeaters FROM student_intake AS intake INNER JOIN v_school AS s ON intake.school_id = s.school_id AND s.school_year = intake.school_year WHERE (s.state_divsion_id = '".Input::get('state_id')."' OR '' = '".Input::get('state_id')."') AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') AND s.school_year = '".Input::get('academic_year')."' GROUP BY intake.grade"));

			$total_std = DB::select(DB::raw("SELECT intake.grade, (SUM(total_boy) + SUM(total_girl)) AS students FROM student_intake AS intake INNER JOIN v_school AS s ON intake.school_id = s.school_id AND s.school_year = intake.school_year WHERE (s.state_divsion_id = '".Input::get('state_id')."' OR '' = '".Input::get('state_id')."') AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') AND s.school_year = '".Input::get('previous_year')."' GROUP BY intake.grade"));

			return view('student_flow_rate.repetition_rate',compact('region','repeater','total_std'));

		}
		catch(Exception $ex)
		{
			$record="<h4>There is no Data Records.Please Check in Searching.</h4>";
			return view('student_flow_rate.repetition_rate',compact('region','record'));
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('student_flow_rate.repetition_rate');
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

				$q = "SELECT *";
				
			} else {
			
				$q = "SELECT state_id, state_division";
				
			}
			
			$q .= " FROM v_state_township WHERE state_id = ".Input::get('state_id')." AND (township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') GROUP BY state_id";
				
			$region = DB::select(DB::raw($q));

			$repeater = DB::select(DB::raw("SELECT intake.grade, (SUM(repeat_boy) + SUM(repeat_girl)) AS repeaters,s.location FROM student_intake AS intake INNER JOIN v_school AS s ON intake.school_id = s.school_id AND s.school_year = intake.school_year WHERE (s.state_divsion_id = '".Input::get('state_id')."' OR '' = '".Input::get('state_id')."') AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') AND s.school_year = '".Input::get('academic_year')."' GROUP BY intake.grade"));

			$total_std = DB::select(DB::raw("SELECT intake.grade, (SUM(total_boy) + SUM(total_girl)) AS students,s.location FROM student_intake AS intake INNER JOIN v_school AS s ON intake.school_id = s.school_id AND s.school_year = intake.school_year WHERE (s.state_divsion_id = '".Input::get('state_id')."' OR '' = '".Input::get('state_id')."') AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') AND s.school_year = '".Input::get('previous_year')."' GROUP BY intake.grade"));

			foreach ($repeater as $repeats) {
				$repeat[]=get_object_vars($repeats);
			}
			foreach ($total_std as $total_stds) {
				$total[]=get_object_vars($total_stds);
			}
			if(count($repeater)>0 && count($total_std)>0){
			
			
			$state_name=DB::select(DB::raw("SELECT state_division FROM state_division WHERE id=".Input::get('state_id')));

			if(Input::get('township_id')){
				$township_name=DB::select(DB::raw("SELECT township_name FROM township WHERE id=".Input::get('township_id')));	
			}
			$request_input=array($state_name[0]->state_division,isset($township_name[0]->township_name)? $township_name[0]->township_name:'ALL',Input::get('academic_year'),Input::get('previous_year'));

			Excel::create('RepetionRate', function($excel) use($repeat,$total,$request_input){

	    	$excel->sheet('RepetionRate', function($sheet) use($repeat,$total,$request_input){

	    		//$sheet->fromArray($post[0]);
	    		$sheet->prependRow(array('Township Education Management Information System'))->mergeCells('A1:D1',function($cells){
	    				$cells->setFontWeight('bold');
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('center');
	    				 $cells->setValignment('middle');
	    			});
	    		$sheet->appendRow(array('Repetition Rate (Grade One to Eleven)'))->mergeCells('A2:D2',function($cells){
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
	    		
	    		
				$sheet->appendRow(array('Grade','No. of Repeaters in Current Year '.$request_input[2],'No. of Students in previous year '.$request_input[3],'Repetition Rate'));

				for($k = 0; $k < count($repeat); $k++)	{
					for ($j=0; $j < count($total); $j++) { 
						
						if($repeat[$k]['grade']==$total[$j]['grade']){
							$count=$sheet->getHighestRow()+1;
							$sheet->cell('A'.$count,function($cell) use($repeat,$k){
				    			$cell->setValue($repeat[$k]['grade']);
						    	$cell->setFontSize(12);
						    	$cell->setAlignment('left');
						    	$cell->setValignment('middle');
						    });
						    $sheet->cell('B'.$count,function($cell) use($repeat,$k){
				    			$cell->setValue($repeat[$k]['repeaters']);
						    	$cell->setFontSize(12);
						    	$cell->setAlignment('left');
						    	$cell->setValignment('middle');
						    });
						    $sheet->cell('C'.$count,function($cell) use($total,$j){
				    			$cell->setValue($total[$j]['students']);
						    	$cell->setFontSize(12);
						    	$cell->setAlignment('left');
						    	$cell->setValignment('middle');
						    });
						    $sheet->cell('D'.$count,function($cell) use($repeat,$k,$total,$j){
				    			$cell->setValue(round(($repeat[$k]['repeaters']/$total[$j]['students'])*100,2));
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
			}
			//return view('student_flow_rate.repetition_rate',compact('region','repeater','total_std'));

		}
		catch(Exception $ex)
		{
			$record="<h4>There is no Data Records.Please Check in Searching.</h4>";
			return view('student_flow_rate.repetition_rate',compact('region','record'));
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
