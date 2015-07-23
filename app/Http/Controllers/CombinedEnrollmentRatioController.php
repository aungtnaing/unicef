<?php
namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;


class CombinedEnrollmentRatioController extends Controller
{
	public function create()
	{
		return view('gross.combined_enrollment_ratio_levels');
	}

	public function search()
	{

		$state=Request::input('state_id');
		$town=Request::input('township_id');
		$year=Request::input('academic_year');

		if(Request::input('township_id')) {

			$q = "SELECT state_division, township_name";
		
		} else {
		
			$q = "SELECT state_division";
		
		}

		$q .= " FROM v_state_township WHERE state_id = ".Request::input('state_id')." AND (township_id = '".Request::input('township_id')."' OR '' = '".Request::input('township_id')."') GROUP BY state_id";

		$region = DB::select(DB::raw($q));

		try {
			
		$total_intake_com=DB::select(DB::raw("SELECT SUM(total_boy+total_girl) AS total_students_com FROM `student_intake` INNER JOIN v_school ON v_school.school_id=student_intake.school_id AND v_school.school_year=student_intake.school_year  WHERE (student_intake.grade='01' OR student_intake.grade='02' OR student_intake.grade='03' OR student_intake.grade='04' OR student_intake.grade='05' OR student_intake.grade='06' OR student_intake.grade='07' OR student_intake.grade='08' OR student_intake.grade='09') AND (student_intake.school_year ='".$year."') AND (v_school.state_divsion_id ='".$state."') AND  (v_school.township_id ='".$town."' OR ''='".$town."')"));

		$total_populations=DB::select(DB::raw("SELECT SUM(age5_9boy+age5_9girl+age10_13boy+age10_13girl) AS total_pop_com FROM population WHERE (townshipid ='".$town."' OR ''='".$town."') AND (academic_year='".$year."')"));
		return view('gross.combined_enrollment_ratio_levels',compact('region','total_intake_com','total_populations'));

		} catch (Exception $e) {
			$record="<h4>Please Check in Searching!</h4>";
			return view('gross.combined_enrollment_ratio_levels',compact('region','record'));
		}
		
	}
	public function export()
	{
		$state=Request::input('state_id');
		$town=Request::input('township_id');
		$year=Request::input('academic_year');

		if(Request::input('township_id')) {

			$q = "SELECT state_division, township_name";
		
		} else {
		
			$q = "SELECT state_division";
		
		}

		$q .= " FROM v_state_township WHERE state_id = ".Request::input('state_id')." AND (township_id = '".Request::input('township_id')."' OR '' = '".Request::input('township_id')."') GROUP BY state_id";

		$region = DB::select(DB::raw($q));

		try {
			
		$total_intake_com=DB::select(DB::raw("SELECT SUM(total_boy+total_girl) AS total_students_com FROM `student_intake` INNER JOIN v_school ON v_school.school_id=student_intake.school_id AND v_school.school_year=student_intake.school_year  WHERE (student_intake.grade='01' OR student_intake.grade='02' OR student_intake.grade='03' OR student_intake.grade='04' OR student_intake.grade='05' OR student_intake.grade='06' OR student_intake.grade='07' OR student_intake.grade='08' OR student_intake.grade='09') AND (student_intake.school_year ='".$year."' ) AND (v_school.state_divsion_id ='".$state."') AND  (v_school.township_id ='".$town."' OR ''='".$town."')"));

		
		$total_populations=DB::select(DB::raw("SELECT SUM(age5_9boy+age5_9girl+age10_13boy+age10_13girl) AS total_pop_com FROM population WHERE (townshipid ='".$town."' OR ''='".$town."') AND (academic_year='".$year."')"));

		foreach ($total_populations as $population) {
			$arr_population=get_object_vars($population);
		}

		foreach ($total_intake_com as $intake_com) {
			$arr_com=get_object_vars($intake_com);
		}

		
		$state_naem=DB::select(DB::raw("SELECT state_division FROM state_division WHERE id=".$state));
		$township_name=DB::select(DB::raw("SELECT township_name FROM township WHERE id=".$town));
		$request_input=array($state_naem[0]->state_division,$township_name[0]->township_name,$year);
	
	Excel::create('Combined (Primary and Middel School Levels)', function($excel) use($arr_population,$arr_com,$request_input) {

    		$excel->sheet('Combined Enrollment Ratio', function($sheet) use($arr_population,$arr_com,$request_input) {

    		//$sheet->fromArray($post[0]);
    		$sheet->prependRow(array('Township Education Management Information System'))->mergeCells('A1:D1',function($cells){
    				$cells->setFontWeight('bold');
    				$cells->setFontSize(18);
    				$cells->setAlignment('center');
    				 $cells->setValignment('middle');
    			});
    		$sheet->appendRow(array('Combined (Primary and Middel School Levels) Report'))->mergeCells('A2:D2',function($cells){
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
    		$sheet->appendRow(array('Academic Year :'.$request_input[2]))->mergeCells('A5:B5',function($cell){
    			$cell->setFontWeight('bold');
    			$cell->setFontSize(18);
    			$cell->setAlignment('left');
    			$cell->setValignment('middle');
    		});
    		
		$sheet->appendRow(array('School Levels','Total Students','Population','Gross Enrollment Ratio'));
    	
    	$count=$sheet->getHighestRow()+1;
		$sheet->cell('A'.$count,function($cell){
			$cell->setValue('Primary and Middle Levels(Grade 1 to Grade 9)');
			$cell->setFontSize(12);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});
		
		$sheet->cell('B'.$count,function($cell) use($arr_com){
			if($arr_com['total_students_com']>0)
			{
				$com=$arr_com['total_students_com'];
			}
			else
			{
				$com="0";
			}
			$cell->setValue($com);
			$cell->setFontSize(12);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});

		$sheet->cell('C'.$count,function($cell) use($arr_population){
			if($arr_population['total_pop_com']>0)
			{
				$pop_com=$arr_population['total_pop_com'];
			}
			else
			{
				$pop_com="0";
			}
			$cell->setValue($pop_com);
			$cell->setFontSize(12);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});

		$sheet->cell('D'.$count,function($cell) use($arr_population,$arr_com){
			if ($arr_population['total_pop_com']>0 && $arr_com['total_students_com']>0) {
						$com_ratio=$arr_com['total_students_com']/$arr_population['total_pop_com'] *100;
						$com_ratio.='%';
					}
					elseif ($arr_com['total_students_com']==0) {
						 $com_ratio="There is no student for primary level.";
					}
					else
					{
						$com_ratio="There is no population record(age5-9)";
					}
			$cell->setValue(round($com_ratio,2));
			$cell->setFontSize(12);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});
		$sheet->setBorder('A1'.':D'.$sheet->getHighestRow(), 'thin');

    	});

	})->export('xlsx');


		} catch (Exception $e) {
			$record="<h4>Please Check in Searching!</h4>";
			return view('gross.combined_enrollment_ratio_levels',compact('region','record'));
		}
	}
}
 