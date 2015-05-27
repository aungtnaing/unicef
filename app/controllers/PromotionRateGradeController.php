<?php

class PromotionRateGradeController extends \BaseController
{
	public function create()
	{
		return View::make('flow.promotion_rate_grade');
	}

	public function search()
	{

		$state=Input::get('state_id');
		$town=Input::get('township_id');
		$year=Input::get('academic_year');
		$pre_year=Input::get('previous_year');
		$grade=Input::get('grade_id');
		$pre_grade=Input::get('grade_id')-1;
		$pre_grade="0".$pre_grade;
		

		if(Input::get('township_id')) {

			$q = "SELECT state_division, township_name";
		
		} else {
		
			$q = "SELECT state_division";
		
		}

		$q .= " FROM v_state_township WHERE state_id = ".Input::get('state_id')." AND (township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') GROUP BY state_id";

		$region = DB::select(DB::raw($q));
		try{
			$new_total=DB::select(DB::raw("SELECT SUM(new_boy)+SUM(new_girl) AS total_students,student_intake.grade,v_school.location FROM `student_intake` INNER JOIN v_school ON v_school.school_id=student_intake.school_id WHERE (v_school.state_divsion_id ='".$state."' OR ''='".$state."') AND (v_school.township_id ='".$town."' OR ''='".$town."') AND (student_intake.school_year='".$year."' OR ''='".$year."') AND student_intake.grade!='01' GROUP BY student_intake.grade,v_school.location"));

		$pre_total=DB::select(DB::raw("SELECT SUM(new_boy)+SUM(new_girl) AS total_students,student_intake.grade,v_school.location FROM `student_intake` INNER JOIN v_school ON v_school.school_id=student_intake.school_id WHERE (v_school.state_divsion_id ='".$state."' OR ''='".$state."') AND  (v_school.township_id ='".$town."' OR ''='".$town."') AND (student_intake.school_year='".$pre_year."' OR ''='".$pre_year."') AND student_intake.grade!='11' GROUP BY student_intake.grade,v_school.location"));		
		 
		return View::make('flow.promotion_rate_grade',compact('region','new_total','pre_total'));		
		}
		catch(Exception $ex)
		{
			$record="<h4>There is no Data Records.Please Check in Searching.</h4>";
			return View::make('flow.promotion_rate_grade',compact('region','record'));
		}
			
	}
}
 