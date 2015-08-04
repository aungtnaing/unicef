<?php namespace App\Http\Controllers;

use Redirect;
use Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class DropoutRateController extends Controller {

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

			$new_total = DB::select(DB::raw("SELECT SUM(new_boy)+SUM(new_girl) AS total_students,student_intake.grade FROM `student_intake` INNER JOIN v_school ON v_school.school_id=student_intake.school_id AND v_school.school_year = student_intake.school_year WHERE (v_school.state_divsion_id ='".Input::get('state_id')."' OR ''='".Input::get('state_id')."') AND (v_school.township_id ='".Input::get('township_id')."' OR ''='".Input::get('township_id')."') AND (student_intake.school_year='".Input::get('academic_year')."' OR ''='".Input::get('academic_year')."') AND student_intake.grade<>'01' GROUP BY student_intake.grade"));

			$pre_total = DB::select(DB::raw("SELECT SUM(total_boy)+SUM(total_girl) AS total_students,student_intake.grade FROM `student_intake` INNER JOIN v_school ON v_school.school_id=student_intake.school_id AND v_school.school_year = student_intake.school_year WHERE (v_school.state_divsion_id ='".Input::get('state_id')."' OR ''='".Input::get('state_id')."') AND  (v_school.township_id ='".Input::get('township_id')."' OR ''='".Input::get('township_id')."') AND (student_intake.school_year='".Input::get('previous_year')."' OR ''='".Input::get('previous_year')."') AND student_intake.grade<>'11' GROUP BY student_intake.grade"));

			$repeater = DB::select(DB::raw("SELECT intake.grade, (SUM(repeat_boy) + SUM(repeat_girl)) AS repeaters FROM student_intake AS intake INNER JOIN v_school AS s ON intake.school_id = s.school_id AND s.school_year = intake.school_year WHERE (s.state_divsion_id = '".Input::get('state_id')."' OR '' = '".Input::get('state_id')."') AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') AND s.school_year = '".Input::get('academic_year')."' GROUP BY intake.grade"));

			$total_std = DB::select(DB::raw("SELECT intake.grade, (SUM(total_boy) + SUM(total_girl)) AS students FROM student_intake AS intake INNER JOIN v_school AS s ON intake.school_id = s.school_id AND s.school_year = intake.school_year WHERE (s.state_divsion_id = '".Input::get('state_id')."' OR '' = '".Input::get('state_id')."') AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') AND s.school_year = '".Input::get('previous_year')."' GROUP BY intake.grade"));

			
			if(count($new_total) && count($pre_total) && count($repeater) && count($total_std)) {
					
				return view('student_flow_rate.dropout_rate',compact('region','new_total', 'pre_total', 'repeater','total_std'));
					
			} else {
					
				$error = "There is no data in this State or Townshiip.";
				return view('student_flow_rate.dropout_rate', compact('error'));
				
			}

				$err = "There is no data.";
				throw new Exception($err);

			} catch (Exception $e) {

				$error = "There is no data.";
				return view('student_flow_rate.dropout_rate', compact('error'));

			}

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('student_flow_rate.dropout_rate');
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


			if(Input::get('township_id')) {

				$q = "SELECT *";
				
			} else {
			
				$q = "SELECT state_id, state_division";
				
			}
			
			$q .= " FROM v_state_township WHERE state_id = ".Input::get('state_id')." AND (township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') GROUP BY state_id";
				
			$region = DB::select(DB::raw($q));

			$new_total = DB::select(DB::raw("SELECT SUM(new_boy)+SUM(new_girl) AS total_students,student_intake.grade FROM `student_intake` INNER JOIN v_school ON v_school.school_id=student_intake.school_id AND v_school.school_year = student_intake.school_year WHERE (v_school.state_divsion_id ='".Input::get('state_id')."' OR ''='".Input::get('state_id')."') AND (v_school.township_id ='".Input::get('township_id')."' OR ''='".Input::get('township_id')."') AND (student_intake.school_year='".Input::get('academic_year')."' OR ''='".Input::get('academic_year')."') AND student_intake.grade<>'01' GROUP BY student_intake.grade"));
			$pre_total = DB::select(DB::raw("SELECT SUM(total_boy)+SUM(total_girl) AS total_students,student_intake.grade FROM `student_intake` INNER JOIN v_school ON v_school.school_id=student_intake.school_id AND v_school.school_year = student_intake.school_year WHERE (v_school.state_divsion_id ='".Input::get('state_id')."' OR ''='".Input::get('state_id')."') AND  (v_school.township_id ='".Input::get('township_id')."' OR ''='".Input::get('township_id')."') AND (student_intake.school_year='".Input::get('previous_year')."' OR ''='".Input::get('previous_year')."') AND student_intake.grade<>'11' GROUP BY student_intake.grade"));
			$repeater = DB::select(DB::raw("SELECT intake.grade, (SUM(repeat_boy) + SUM(repeat_girl)) AS repeaters FROM student_intake AS intake INNER JOIN v_school AS s ON intake.school_id = s.school_id AND s.school_year = intake.school_year WHERE (s.state_divsion_id = '".Input::get('state_id')."' OR '' = '".Input::get('state_id')."') AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') AND s.school_year = '".Input::get('academic_year')."' GROUP BY intake.grade"));
			$total_std = DB::select(DB::raw("SELECT intake.grade, (SUM(total_boy) + SUM(total_girl)) AS students FROM student_intake AS intake INNER JOIN v_school AS s ON intake.school_id = s.school_id AND s.school_year = intake.school_year WHERE (s.state_divsion_id = '".Input::get('state_id')."' OR '' = '".Input::get('state_id')."') AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') AND s.school_year = '".Input::get('previous_year')."' GROUP BY intake.grade"));
			
			foreach ($new_total as $new_totals) {
				$new[]=get_object_vars($new_totals);
			}
			foreach ($pre_total as $pre_totals) {
				$pre[]=get_object_vars($pre_totals);
			}
			foreach ($repeater as $repeats) {
				$repeat[]=get_object_vars($repeats);
			}
			foreach ($total_std as $total_stds) {
				$total[]=get_object_vars($total_stds);
			}
			$state_name=DB::select(DB::raw("SELECT state_division FROM state_division WHERE id=".Input::get('state_id')));

			if(Input::get('township_id')){
				$township_name=DB::select(DB::raw("SELECT township_name FROM township WHERE id=".Input::get('township_id')));	
			}
			$request_input=array($state_name[0]->state_division,isset($township_name[0]->township_name)? $township_name[0]->township_name:'ALL',Input::get('academic_year'));

			Excel::create('DropoutRate', function($excel) use($new,$pre,$repeat,$total,$request_input){

	    	$excel->sheet('DropoutRate', function($sheet) use($new,$pre,$repeat,$total,$request_input){

	    		$sheet->prependRow(array('Township Education Management Information System'))->mergeCells('A1:D1',function($cells){
	    				$cells->setFontWeight('bold');
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('center');
	    				 $cells->setValignment('middle');
	    			});
	    		$sheet->appendRow(array('Dropout Rate Report'))->mergeCells('A2:D2',function($cells){
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
	    		
	    		
				$sheet->appendRow(array('Grade','Promotion Rate','Repetition Rate','Dropout Rate'));

				for($k = 0; $k < count($new); $k++)	{
					$Promotion=0;$Repetition=0;
					$count=$sheet->getHighestRow()+1;
					$sheet->cell('A'.$count,function($cell) use($new,$k,$repeat){
		    			$cell->setValue('Grade '.$new[$k]['grade'].' - Grade '.$repeat[$k]['grade']);
				    	$cell->setFontSize(12);
				    	$cell->setAlignment('left');
				    	$cell->setValignment('middle');
				    });
				    $sheet->cell('B'.$count,function($cell) use($new,$k,$pre){
				    	$Promotion = round(($new[$k]['total_students']/$pre[$k]['total_students']) * 100, 2);
		    			$cell->setValue($Promotion);
				    	$cell->setFontSize(12);
				    	$cell->setAlignment('left');
				    	$cell->setValignment('middle');
				    });
				    $sheet->cell('C'.$count,function($cell) use($k,$repeat,$total){
				    	$Repetition = round(($repeat[$k]['repeaters']/$total[$k]['students']) * 100, 2);
		    			$cell->setValue($Repetition);
				    	$cell->setFontSize(12);
				    	$cell->setAlignment('left');
				    	$cell->setValignment('middle');
				    });
				    $sheet->cell('D'.$count,function($cell) use($new,$k,$pre,$repeat,$total){

				    	$Promotion = round(($new[$k]['total_students']/$pre[$k]['total_students']) * 100, 2);

				    	$Repetition = round(($repeat[$k]['repeaters']/$total[$k]['students']) * 100, 2);
				    	
		    			$cell->setValue($Promotion-$Repetition);
				    	$cell->setFontSize(12);
				    	$cell->setAlignment('left');
				    	$cell->setValignment('middle');
				    });
				}	
		
				
			$sheet->setBorder('A1'.':D'.$sheet->getHighestRow(), 'thin');

	    	});

			 })->download('xlsx');
			$err = "There is no data.";
				throw new Exception($err);

			} catch (Exception $e) {

				$error = "There is no data.";
				return view('student_flow_rate.dropout_rate', compact('error'));

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
