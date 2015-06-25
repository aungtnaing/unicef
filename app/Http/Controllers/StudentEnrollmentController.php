<?php
namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Input;
use Session;
use Illuminate\Support\Facades\DB;

class StudentEnrollmentController extends Controller
{
	public function create()
	{
		if((Session::get('state_id') && Session::get('academic_year')) || Session::get('township_id')) {
			return Redirect::action('StudentEnrollmentController@search');
		} else {
		return view('students.enrollment');
		}
	}

	public function search()
	{
		/*try
		{*/
			if (((Session::get('state_id')) && Session::get('academic_year')) || Session::get('township_id'))
		{
			$state_id = Session::get('state_id');
			$township_id = Session::get('township_id');
			$academic_year = Session::get('academic_year');
		}
		else
		{
			$state_id = Input::get('state_id');
			$township_id = Input::get('township_id');
			$academic_year = Input::get('academic_year');
			
		}
		if(isset($township_id)) {

			$q = "SELECT *";
		
		} else {
		
			$q = "SELECT state_id,state_division";
		
		}

		$q .= " FROM v_state_township WHERE state_id = ".$state_id." AND (township_id = '".$township_id."' OR '' = '".$township_id."') GROUP BY state_id";

		$region = DB::select(DB::raw($q));
		/*
		SELECT school_id,location,school_level,school_no,school_name FROM v_school WHERE  (state_divsion_id = '".$state."' OR ''='".$state."') AND (township_id ='".$town."' OR ''='".$town."') AND (school_year='".$year."' OR ''='".$year."') GROUP BY school_id ORDER BY sort_code,location,school_id ASC;*/

		$dtSchool = DB::select("SELECT school_id,location,school_level,school_no,school_name FROM v_school WHERE  (state_divsion_id = '".$state_id."' OR ''='".$state_id."') AND (township_id ='".$township_id."' OR ''='".$township_id."') AND (school_year='".$academic_year."' OR ''='".$academic_year."') GROUP BY school_id ORDER BY sort_code ASC ") ;

		foreach ($dtSchool as $class) {
			
			$school_id[] = $class->school_id;

		}

		//print_r($dtSchool);
		$schools_id = "'".implode("','", $school_id)."'";
		/*echo "SELECT SUM(total_boy)+SUM(total_girl) AS total_students,school_id,location,school_level FROM `v_studentattendance` WHERE v_studentattendance.school_id IN ({$schools_id}) AND v_studentattendance.grade='01' AND (school_year='".$year."' OR ''='".$year."') GROUP BY school_id ORDER BY location,school_id,school_level ASC";*/

		
		$dtG1Stds = DB::select("SELECT SUM(total_boy)+SUM(total_girl) AS total_students,school_id,location,school_level FROM `v_studentattendance` WHERE v_studentattendance.school_id IN ({$schools_id}) AND v_studentattendance.grade='01' AND (school_year='".$academic_year."' OR ''='".$academic_year."') GROUP BY school_id");

		$dtPStds = DB::select("SELECT SUM(total_boy)+SUM(total_girl) AS total_students,school_id,location,school_level FROM `v_studentattendance` WHERE school_id IN ({$schools_id}) AND  level='1' AND (school_year='".$academic_year."' OR ''='".$academic_year."') GROUP BY school_id ");
 
		$dtMStds = DB::select("SELECT SUM(total_boy)+SUM(total_girl) AS total_students,school_id,location,school_level FROM `v_studentattendance` WHERE school_id IN ({$schools_id}) AND level='2'  AND (school_year='".$academic_year."' OR ''='".$academic_year."') GROUP BY school_id ");

		$dtHStds = DB::select("SELECT SUM(total_boy)+SUM(total_girl) AS total_students,school_id,location,school_level FROM `v_studentattendance` WHERE school_id IN ({$schools_id}) AND level='3'  AND (school_year='".$academic_year."' OR ''='".$academic_year."') GROUP BY school_id ");

		return view('students.enrollment',compact('region','dtSchool','dtG1Stds', 'dtPStds','dtMStds','dtHStds'));
		/*}
		catch(\Exception $ex)
		{
			$record="There is no data record.Please check Searching!";
			return view('students.enrollment',compact('region','record'));

		}*/
		
	}

	public function export()
	{
		Excel::create('Filename', function($excel) {

    	$excel->sheet('Sheetname', function($sheet) {

        	$sheet->fromArray(array(
            array('data1', 'data2'),
            array('data3', 'data4')
       	 ));

    	});

		})->export('xls');
	}
}
 