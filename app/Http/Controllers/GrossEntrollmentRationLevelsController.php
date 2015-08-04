<?php
namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class GrossEntrollmentRationLevelsController extends Controller
{
	public function create()
	{
		return view('gross.gross_enrollment_ratio_levels');
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
			
		$total_intake_pri=DB::select(DB::raw("SELECT SUM(total_boy)+SUM(total_girl) AS total_students_pri FROM `student_intake` INNER JOIN v_school ON v_school.school_id=student_intake.school_id AND v_school.school_year=student_intake.school_year  WHERE (student_intake.grade='01' OR student_intake.grade='02' OR student_intake.grade='03' OR student_intake.grade='04' OR student_intake.grade='05') AND (student_intake.school_year ='".$year."') AND (v_school.state_divsion_id ='".$state."') AND  (v_school.township_id ='".$town."' OR ''='".$town."')"));

		$total_populations=DB::select(DB::raw("SELECT SUM(age5_9boy+age5_9girl) AS total5_9,SUM(age10_13boy+age10_13girl) AS total10_13,SUM(age14_15boy+age14_15girl) AS total14_15 FROM population WHERE (townshipid ='".$town."' OR ''='".$town."') AND (academic_year='".$year."')"));

		$total_intake_mid=DB::select(DB::raw("SELECT SUM(total_boy)+SUM(total_girl) AS total_students_mid FROM `student_intake` INNER JOIN v_school ON v_school.school_id=student_intake.school_id AND v_school.school_year=student_intake.school_year WHERE (student_intake.grade='06' OR student_intake.grade='07' OR student_intake.grade='08' OR student_intake.grade='09') AND (student_intake.school_year ='".$year."') AND (v_school.state_divsion_id ='".$state."') AND  (v_school.township_id ='".$town."' OR ''='".$town."')"));		

		$total_intake_high=DB::select(DB::raw("SELECT SUM(total_boy)+SUM(total_girl) AS total_students_high FROM `student_intake` INNER JOIN v_school ON v_school.school_id=student_intake.school_id AND v_school.school_year=student_intake.school_year WHERE (student_intake.grade='10' OR student_intake.grade='11') AND (student_intake.school_year ='".$year."') AND (v_school.state_divsion_id ='".$state."') AND  (v_school.township_id ='".$town."' OR ''='".$town."')"));

		return view('gross.gross_enrollment_ratio_levels',compact('region','total_intake_pri','total_populations','total_intake_mid','total_intake_high'));

		} catch (Exception $e) {
			$record="<h4>Please Check in Searching!</h4>";
			return view('gross.gross_enrollment_ratio_levels',compact('region','record'));
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
			
		$total_intake_pri=DB::select(DB::raw("SELECT SUM(total_boy)+SUM(total_girl) AS total_students_pri FROM `student_intake` INNER JOIN v_school ON v_school.school_id=student_intake.school_id AND v_school.school_year=student_intake.school_year  WHERE (student_intake.grade='01' OR student_intake.grade='02' OR student_intake.grade='03' OR student_intake.grade='04' OR student_intake.grade='05') AND (student_intake.school_year ='".$year."') AND (v_school.state_divsion_id ='".$state."') AND  (v_school.township_id ='".$town."' OR ''='".$town."')"));

		$total_populations=DB::select(DB::raw("SELECT SUM(age5_9boy+age5_9girl) AS total5_9,SUM(age10_13boy+age10_13girl) AS total10_13,SUM(age14_15boy+age14_15girl) AS total14_15 FROM population WHERE (townshipid ='".$town."' OR ''='".$town."') AND (academic_year='".$year."')"));

		$total_intake_mid=DB::select(DB::raw("SELECT SUM(total_boy)+SUM(total_girl) AS total_students_mid FROM `student_intake` INNER JOIN v_school ON v_school.school_id=student_intake.school_id AND v_school.school_year=student_intake.school_year WHERE (student_intake.grade='06' OR student_intake.grade='07' OR student_intake.grade='08' OR student_intake.grade='09') AND (student_intake.school_year ='".$year."') AND (v_school.state_divsion_id ='".$state."') AND  (v_school.township_id ='".$town."' OR ''='".$town."')"));		

		$total_intake_high=DB::select(DB::raw("SELECT SUM(total_boy)+SUM(total_girl) AS total_students_high FROM `student_intake` INNER JOIN v_school ON v_school.school_id=student_intake.school_id AND v_school.school_year=student_intake.school_year WHERE (student_intake.grade='10' OR student_intake.grade='11') AND (student_intake.school_year ='".$year."' OR ''='".$year."') AND (v_school.state_divsion_id ='".$state."') AND  (v_school.township_id ='".$town."' OR ''='".$town."')"));
		
		foreach ($total_populations as $population) {
			$arr_population=get_object_vars($population);
		}

		foreach ($total_intake_pri as $intake_pri) {
			$arr_pri=get_object_vars($intake_pri);
		}

		foreach ($total_intake_mid as $intake_mid) {
			$arr_mid=get_object_vars($intake_mid);
		}

		foreach ($total_intake_high as $intake_high) {
			$arr_high=get_object_vars($intake_high);
		}
		$state_naem=DB::select(DB::raw("SELECT state_division FROM state_division WHERE id=".$state));
		$township_name=DB::select(DB::raw("SELECT township_name FROM township WHERE id=".$town));
		$request_input=array($state_naem[0]->state_division,$township_name[0]->township_name,$year);
	
	Excel::create('Gross Enrollment Ratio with School Level', function($excel) use($arr_population,$arr_pri,$arr_mid,$arr_high,$request_input) {

    		$excel->sheet('Gross Enrollment Ratio', function($sheet) use($arr_population,$arr_pri,$arr_mid,$arr_high,$request_input) {

    		//$sheet->fromArray($post[0]);
    		$sheet->prependRow(array('Township Education Management Information System'))->mergeCells('A1:D1',function($cells){
    				$cells->setFontWeight('bold');
    				$cells->setFontSize(18);
    				$cells->setAlignment('center');
    				 $cells->setValignment('middle');
    			});
    		$sheet->appendRow(array('Gross Enrollment Ratio: Primary, Middle and High School Level Report'))->mergeCells('A2:D2',function($cells){
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
			$cell->setValue('Primary Level');
			$cell->setFontSize(12);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});
		
		$sheet->cell('B'.$count,function($cell) use($arr_pri){
			if($arr_pri['total_students_pri']>0)
			{
				$pri=$arr_pri['total_students_pri'];
			}
			else
			{
				$pri="0";
			}
			$cell->setValue($pri);
			$cell->setFontSize(12);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});

		$sheet->cell('C'.$count,function($cell) use($arr_population){
			if($arr_population['total5_9']>0)
			{
				$pop5_9=$arr_population['total5_9'];
			}
			else
			{
				$pop5_9="0";
			}
			$cell->setValue($pop5_9);
			$cell->setFontSize(12);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});

		$sheet->cell('D'.$count,function($cell) use($arr_population,$arr_pri){
			if ($arr_population['total5_9']>0 && $arr_pri['total_students_pri']>0) {
						$pri_ratio=$arr_pri['total_students_pri']/$arr_population['total5_9'] *100;
						$pri_ratio.='%';
					}
					elseif ($arr_pri['total_students_pri']==0) {
						 $pri_ratio="There is no student for primary level.";
					}
					else
					{
						$pri_ratio="There is no population record(age5-9)";
					}
			$cell->setValue($pri_ratio);
			$cell->setFontSize(12);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});

		$count=$sheet->getHighestRow()+1;
		$sheet->cell('A'.$count,function($cell){
			$cell->setValue('Middle Level');
			$cell->setFontSize(12);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});
		
		$sheet->cell('B'.$count,function($cell) use($arr_mid){
			if($arr_mid['total_students_mid']>0)
			{
				$mid=$arr_mid['total_students_mid'];
			}
			else
			{
				$mid="0";
			}
			$cell->setValue($mid);
			$cell->setFontSize(12);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});

		$sheet->cell('C'.$count,function($cell) use($arr_population){
			if($arr_population['total10_13']>0)
			{
				$pop10_13=$arr_population['total10_13'];
			}
			else
			{
				$pop10_13="0";
			}
			$cell->setValue($pop10_13);
			$cell->setFontSize(12);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});

		$sheet->cell('D'.$count,function($cell) use($arr_population,$arr_mid){
			if ($arr_population['total10_13']>0 && $arr_mid['total_students_mid']>0) {
						$mid_ratio=$arr_population['total10_13']/$arr_mid['total_students_mid'] *100;
						$mid_ratio.='%';
					}
					elseif ($arr_mid['total_students_mid']==0) {
						 $mid_ratio="There is no student for primary level.";
					}
					else
					{
						$mid_ratio="There is no population record(age5-9)";
					}
			$cell->setValue($mid_ratio);
			$cell->setFontSize(12);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});

		$count=$sheet->getHighestRow()+1;
		$sheet->cell('A'.$count,function($cell) {
			$cell->setValue('High Level');
			$cell->setFontSize(12);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});
		
		$sheet->cell('B'.$count,function($cell) use($arr_high){
			
			$cell->setValue(($arr_high['total_students_high']>0)? $arr_high['total_students_high']:'0');
			$cell->setFontSize(12);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});

		$sheet->cell('C'.$count,function($cell) use($arr_population){
			$cell->setValue(($arr_population['total14_15']>0)? $arr_population['total14_15']:'0');
			$cell->setFontSize(12);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});

		$sheet->cell('D'.$count,function($cell) use($arr_population,$arr_high){
			if ($arr_population['total14_15']>0 && $arr_high['total_students_high']>0) {
						$pri_ratio=$arr_high['total_students_high']/$arr_population['total14_15'] *100;
						$pri_ratio.='%';
					}
					elseif ($arr_high['total_students_high']==0) {
						 $pri_ratio="There is no student for primary level.";
					}
					else
					{
						$pri_ratio="There is no population record(age5-9)";
					}
			$cell->setValue($pri_ratio);
			$cell->setFontSize(12);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});
		$sheet->setBorder('A1'.':D'.$sheet->getHighestRow(), 'thin');

    	});

	})->export('xlsx');

		} catch (Exception $e) {
			$record="<h4>Please Check in Searching!</h4>";
			return view('gross.gross_enrollment_ratio_levels',compact('region','record'));
		}
	}
}
 