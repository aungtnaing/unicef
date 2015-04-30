<?php

class StudentEnrollmentController extends \BaseController
{
	public function create()
	{
		return View::make('students.enrollment');
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

		
		$school_level=DB::select(DB::raw("SELECT id,school_level FROM school_level ORDER BY sort_code"));

		$r_sLevel = DB::select("SELECT school_id,location,school_level,school_no,school_name FROM v_school WHERE  (state_divsion_id = '".$state."' OR ''='".$state."') AND (township_id ='".$town."' OR ''='".$town."') AND (school_year='".$year."' OR ''='".$year."') AND location='Rural' GROUP BY school_id ORDER BY sort_code ASC");

		
		for($i=0;$i<count($r_sLevel);$i++)
		{
			$dtG1Stds[] = DB::select("SELECT school_id,SUM(total_boy+total_girl) AS total_students,school_no,school_name FROM v_StudentAttendance WHERE (state_divsion_id = '".$state."' OR ''='".$state."') AND (township_id ='".$town."' OR ''='".$town."') AND (school_year='".$year."' OR ''='".$year."') AND grade='01' AND Location='Rural' AND school_id=".$r_sLevel[$i]->school_id." GROUP BY school_id");

		$dtPStds[] = DB::select("SELECT school_id,SUM(total_boy+total_girl) AS total_students,school_no,school_name FROM v_StudentAttendance WHERE (state_divsion_id = '".$state."' OR ''='".$state."') AND (township_id ='".$town."' OR ''='".$town."') AND (school_year='".$year."' OR ''='".$year."') AND level=1 AND Location='Rural'  AND school_id=".$r_sLevel[$i]->school_id." GROUP BY school_id");

		$dtMStds[] = DB::select("SELECT school_id ,SUM(total_boy+total_girl) AS total_students FROM v_StudentAttendance WHERE   (state_divsion_id = '".$state."' OR ''='".$state."') AND (township_id ='".$town."' OR ''='".$town."') AND (school_year='".$year."' OR ''='".$year."') AND level=2 AND Location='Rural'  AND school_id=".$r_sLevel[$i]->school_id." GROUP BY school_id");

		$dtHStds[] = DB::select("SELECT school_id,SUM(total_boy+total_girl) AS total_students FROM v_StudentAttendance WHERE  (state_divsion_id = '".$state."' OR ''='".$state."') AND (township_id ='".$town."' OR ''='".$town."') AND (school_year='".$year."' OR ''='".$year."') AND level=3 AND Location='Rural'  AND school_id=".$r_sLevel[$i]->school_id." GROUP BY school_id");
		}
		
		
		$u_sLevel=DB::select("SELECT school_id,location,school_level,school_no,school_name FROM v_school WHERE  (state_divsion_id = '".$state."' OR ''='".$state."') AND (township_id ='".$town."' OR ''='".$town."') AND (school_year='".$year."' OR ''='".$year."') AND location='Urban' GROUP BY school_id ORDER BY sort_code ASC");
		
		
		for($i=0;$i<count($u_sLevel);$i++)
		{
			$dtuG1Stds[] = DB::select("SELECT school_id,SUM(total_boy+total_girl) AS total_students,school_no,school_name FROM v_StudentAttendance WHERE (state_divsion_id = '".$state."' OR ''='".$state."') AND (township_id ='".$town."' OR ''='".$town."') AND (school_year='".$year."' OR ''='".$year."') AND grade='01' AND location='Urban' AND school_id=".$u_sLevel[$i]->school_id." GROUP BY school_id");

		$dtuPStds[] = DB::select("SELECT school_id,SUM(total_boy+total_girl) AS total_students,school_no,school_name FROM v_StudentAttendance WHERE (state_divsion_id = '".$state."' OR ''='".$state."') AND (township_id ='".$town."' OR ''='".$town."') AND (school_year='".$year."' OR ''='".$year."') AND level=1 AND location='Urban'  AND school_id=".$u_sLevel[$i]->school_id." GROUP BY school_id");

		$dtuMStds[] = DB::select("SELECT school_id ,SUM(total_boy+total_girl) AS total_students FROM v_StudentAttendance WHERE   (state_divsion_id = '".$state."' OR ''='".$state."') AND (township_id ='".$town."' OR ''='".$town."') AND (school_year='".$year."' OR ''='".$year."') AND level=2 AND location='Urban'  AND school_id=".$u_sLevel[$i]->school_id." GROUP BY school_id");

		$dtuHStds[] = DB::select("SELECT school_id,SUM(total_boy+total_girl) AS total_students FROM v_StudentAttendance WHERE  (state_divsion_id = '".$state."' OR ''='".$state."') AND (township_id ='".$town."' OR ''='".$town."') AND (school_year='".$year."' OR ''='".$year."') AND level=3 AND location='Urban'  AND school_id=".$u_sLevel[$i]->school_id." GROUP BY school_id");
		}

		return View::make('students.enrollment',compact('r_sLevel','dtG1Stds', 'dtPStds','dtMStds','dtHStds','u_sLevel','dtuG1Stds','dtuPStds','dtuMStds','dtuHStds','region'));
		
	}
}
 