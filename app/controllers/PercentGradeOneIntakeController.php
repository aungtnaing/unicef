<?php

class PercentGradeOneIntakeController extends \BaseController
{
	public function create()
	{
		return View::make('gross.gradeonepercent');
	}

	public function search()
	{

		$state=Input::get('state_id');
		$town=Input::get('township_id');
		$year=Input::get('academic_year');

		if(Input::get('township_id')) {

			$q = "SELECT state_division, township_name";
		
		} else {
		
			$q = "SELECT state_division";
		
		}

		$q .= " FROM v_state_township WHERE state_id = ".Input::get('state_id')." AND (township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') GROUP BY state_id";

		$region = DB::select(DB::raw($q));

		
		// $dtSchool = DB::select("SELECT school_id,location,school_level,school_no,school_name FROM v_school WHERE  (state_divsion_id = '".$state."' OR ''='".$state."') AND (township_id ='".$town."' OR ''='".$town."') AND (school_year='".$year."' OR ''='".$year."')  ORDER BY sort_code,school_id ASC");

		// foreach ($dtSchool as $class) {
			
		// 	$school_id[] = $class->school_id;

		// }
		// print_r(count($dtSchool));
		// // $schools_id = "'".implode("','", $school_id)."'";			
		$tStudents=DB::select(DB::raw("SELECT intake.total_boy,intake.total_girl,intake.ppeg1_boy,intake.ppeg1_girl,intake.school_id,v_school.school_no,v_school.school_name,v_school.location,v_school.school_level FROM student_intake AS intake INNER JOIN v_school ON v_school.school_id=intake.school_id WHERE (v_school.state_divsion_id = '".$state."' OR ''='".$state."') AND (v_school.township_id ='".$town."' OR ''='".$town."') AND (intake.school_year='".$year."' OR ''='".$year."') AND intake.grade='01' GROUP BY intake.school_id "));
		
		return View::make('gross.gradeonepercent',compact('region','tStudents'));
		
		
	}
}
 