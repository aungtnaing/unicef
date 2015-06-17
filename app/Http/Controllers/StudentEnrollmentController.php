<?php
namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\DB;

class StudentEnrollmentController extends Controller
{
	public function create()
	{
		return view('students.enrollment');
	}

	public function search()
	{
		try
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

		$dtSchool = DB::select("SELECT school_id,location,school_level,school_no,school_name FROM v_school WHERE  (state_divsion_id = '".$state."' OR ''='".$state."') AND (township_id ='".$town."' OR ''='".$town."') AND (school_year='".$year."' OR ''='".$year."') GROUP BY school_id ORDER BY school_level ASC ") ;

		foreach ($dtSchool as $class) {
			
			$school_id[] = $class->school_id;

		}

		$schools_id = "'".implode("','", $school_id)."'";

		$dtG1Stds = DB::select("SELECT SUM(student_attendance_details.total_boy)+SUM(student_attendance_details.total_girl) AS total_students,school_id FROM `student_attendance_details` INNER JOIN student_attendance ON student_attendance.id=student_attendance_details.student_attendance_id WHERE student_attendance.school_id IN ({$schools_id}) AND student_attendance_details.grade='01' AND (student_attendance.school_year='".$year."' OR ''='".$year."') GROUP BY student_attendance.school_id");

		$dtPStds = DB::select("SELECT SUM(student_attendance_details.total_boy)+SUM(student_attendance_details.total_girl) AS total_students,school_id FROM `student_attendance_details` INNER JOIN student_attendance ON student_attendance.id=student_attendance_details.student_attendance_id WHERE student_attendance.school_id IN ({$schools_id}) AND (student_attendance_details.grade='01' OR student_attendance_details.grade='02' OR student_attendance_details.grade='03' OR student_attendance_details.grade='04' OR student_attendance_details.grade='05')  AND (student_attendance.school_year='".$year."' OR ''='".$year."') GROUP BY student_attendance.school_id");

		$dtMStds = DB::select("SELECT SUM(student_attendance_details.total_boy)+SUM(student_attendance_details.total_girl) AS total_students,school_id FROM `student_attendance_details` INNER JOIN student_attendance ON student_attendance.id=student_attendance_details.student_attendance_id WHERE student_attendance.school_id IN ({$schools_id}) AND (student_attendance_details.grade='06' OR student_attendance_details.grade='07' OR student_attendance_details.grade='08' OR student_attendance_details.grade='09')  AND (student_attendance.school_year='".$year."' OR ''='".$year."') GROUP BY student_attendance.school_id");

		$dtHStds = DB::select("SELECT SUM(student_attendance_details.total_boy)+SUM(student_attendance_details.total_girl) AS total_students,school_id FROM `student_attendance_details` INNER JOIN student_attendance ON student_attendance.id=student_attendance_details.student_attendance_id WHERE student_attendance.school_id IN ({$schools_id}) AND (student_attendance_details.grade='10' OR student_attendance_details.grade='11')  AND (student_attendance.school_year='".$year."' OR ''='".$year."') GROUP BY student_attendance.school_id");

		return view('students.enrollment',compact('region','dtSchool','dtG1Stds', 'dtPStds','dtMStds','dtHStds'));
		}
		catch(\Exception $ex)
		{
			$record="There is no data record.";
			return view('students.enrollment',compact('region','record'));

		}
		
	}
}
 