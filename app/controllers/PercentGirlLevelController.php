<?php

class PercentGirlLevelController extends \BaseController
{
	public function create()
	{
		// $state = State::orderBy('id','desc')->get();
	
		// $academic = Academic::all();

		// //$view->with(compact('state', 'academic'));
		return View::make('gross.percent_girls_levels');
	}

	public function search()
	{

		$state=Input::get('state_id');
		$town=Input::get('township_id');
		$year=Input::get('academic_year');
		$school_level=Input::get('school_level');

		if(Input::get('township_id')) {

			$q = "SELECT state_division, township_name";
		
		} else {
		
			$q = "SELECT state_division";
		
		}

		$q .= " FROM v_state_township WHERE state_id = ".Input::get('state_id')." AND (township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') GROUP BY state_id";

		$region = DB::select(DB::raw($q));

		try
		{
			$dtSchool = DB::select("SELECT school_id,location,school_level,school_no,school_name FROM v_school WHERE  (state_divsion_id = '".$state."' OR ''='".$state."') AND (township_id ='".$town."' OR ''='".$town."') AND (school_year='".$year."' OR ''='".$year."')  ORDER BY sort_code,school_id ASC");
		//print_r($dtSchool);

		foreach ($dtSchool as $class) {
			
			$school_id[] = $class->school_id;

		}
		$schools_id = "'".implode("','", $school_id)."'";
		if(Input::get('school_level')=="Primary"){
			$tStudents=DB::select(DB::raw("SELECT sum(total_boy) AS total_boy,sum(total_girl) AS total_girl FROM `student_intake` WHERE school_id IN ({$schools_id}) AND (school_year='".$year."' OR ''='".$year."') and (grade='01' OR grade='02' OR grade='03' OR grade='04' OR grade='05')  GROUP BY school_id"));
		}			
		elseif (Input::get('school_level')=="Middle") {
			$tStudents=DB::select(DB::raw("SELECT sum(total_boy) AS total_boy,sum(total_girl) AS total_girl FROM `student_intake` WHERE school_id IN ({$schools_id}) AND (school_year='".$year."' OR ''='".$year."') and (grade='06' OR grade='07' OR grade='08' OR grade='09') GROUP BY school_id"));
		}
		elseif (Input::get('school_level')=="High") {
		 	$tStudents=DB::select(DB::raw("SELECT sum(total_boy) AS total_boy,sum(total_girl) AS total_girl FROM `student_intake` WHERE school_id IN ({$schools_id}) AND (school_year='".$year."' OR ''='".$year."') and (grade='10' OR grade='11') GROUP BY school_id"));
		 }
		 else {
			$tStudents=DB::select(DB::raw("SELECT sum(total_boy) AS total_boy,sum(total_girl) AS total_girl FROM `student_intake` WHERE school_id IN ({$schools_id}) AND (school_year='".$year."' OR ''='".$year."') GROUP BY school_id"));
		}
		return View::make('gross.percent_girls_levels',compact('region','dtSchool','tStudents','school_level'));
		}
		catch(Exception $ex)
		{
			$record="<h4>There is no Data Record. Please Check in Searching.</h4>";
			return View::make('gross.percent_girls_levels',compact('region','record','school_level'));
		}
		
		
	}
}
 