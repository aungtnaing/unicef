<?php
namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
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
		/*try
		{*/
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
		/*
		SELECT school_id,location,school_level,school_no,school_name FROM v_school WHERE  (state_divsion_id = '".$state."' OR ''='".$state."') AND (township_id ='".$town."' OR ''='".$town."') AND (school_year='".$year."' OR ''='".$year."') GROUP BY school_id ORDER BY sort_code,location,school_id ASC;*/

		$dtSchool = DB::select("SELECT school_id,location,school_level,school_no,school_name FROM v_school WHERE  (state_divsion_id = '".$state."' OR ''='".$state."') AND (township_id ='".$town."' OR ''='".$town."') AND (school_year='".$year."' OR ''='".$year."') GROUP BY school_id ORDER BY sort_code ASC ") ;

		foreach ($dtSchool as $class) {
			
			$school_id[] = $class->school_id;

		}

		//print_r($dtSchool);
		$schools_id = "'".implode("','", $school_id)."'";
		/*echo "SELECT SUM(total_boy)+SUM(total_girl) AS total_students,school_id,location,school_level FROM `v_studentattendance` WHERE v_studentattendance.school_id IN ({$schools_id}) AND v_studentattendance.grade='01' AND (school_year='".$year."' OR ''='".$year."') GROUP BY school_id ORDER BY location,school_id,school_level ASC";*/


		$dtG1Stds = DB::select("SELECT SUM(total_boy)+SUM(total_girl) AS total_students,school_id,location,school_level FROM `v_studentattendance` WHERE v_studentattendance.school_id IN ({$schools_id}) AND v_studentattendance.grade='01' AND (school_year='".$year."' OR ''='".$year."') GROUP BY school_id");

		$dtPStds = DB::select("SELECT SUM(total_boy)+SUM(total_girl) AS total_students,school_id,location,school_level FROM `v_studentattendance` WHERE school_id IN ({$schools_id}) AND  level='1' AND (school_year='".$year."' OR ''='".$year."') GROUP BY school_id ");
 
		$dtMStds = DB::select("SELECT SUM(total_boy)+SUM(total_girl) AS total_students,school_id,location,school_level FROM `v_studentattendance` WHERE school_id IN ({$schools_id}) AND level='2'  AND (school_year='".$year."' OR ''='".$year."') GROUP BY school_id ");

		$dtHStds = DB::select("SELECT SUM(total_boy)+SUM(total_girl) AS total_students,school_id,location,school_level FROM `v_studentattendance` WHERE school_id IN ({$schools_id}) AND level='3'  AND (school_year='".$year."' OR ''='".$year."') GROUP BY school_id ");

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
 