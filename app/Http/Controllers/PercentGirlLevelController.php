<?php
namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\DB;

class PercentGirlLevelController extends Controller
{
	public function create()
	{

		$state = DB::select(DB::raw("SELECT * FROM state_division ORDER BY id DESC"));
	
		$academic = DB::select(DB::raw("SELECT * FROM academicyear"));

		// //$view->with(compact('state', 'academic'));
		return view('gross.percent_girls_levels',compact('state','academic'));
	}

	public function search()
	{

		$state=Request::input('state_id');
		$town=Request::input('township_id');
		$year=Request::input('academic_year');
		$school_level=Request::input('school_level');
		$state = DB::select(DB::raw("SELECT * FROM state_division ORDER BY id DESC"));
	
		$academic = DB::select(DB::raw("SELECT * FROM academicyear"));

		if(Request::input('township_id')) {

			$q = "SELECT state_division, township_name";
		
		} else {
		
			$q = "SELECT state_division";
		
		}

		$q .= " FROM v_state_township WHERE state_id = ".Request::input('state_id')." AND (township_id = '".Request::input('township_id')."' OR '' = '".Request::input('township_id')."') GROUP BY state_id";

		$region = DB::select(DB::raw($q));

		try
		{
			$dtSchool = DB::select("SELECT school_id,location,school_level,school_no,school_name FROM v_school WHERE  (state_divsion_id = '".$state."' OR ''='".$state."') AND (township_id ='".$town."' OR ''='".$town."') AND (school_year='".$year."' OR ''='".$year."')  ORDER BY sort_code,school_id ASC");

		foreach ($dtSchool as $class) {
			
			$school_id[] = $class->school_id;

		}
		$schools_id = "'".implode("','", $school_id)."'";
		if(Request::input('school_level')=="Primary"){
			$tStudents=DB::select(DB::raw("SELECT sum(total_boy) AS total_boy,sum(total_girl) AS total_girl FROM `student_intake` WHERE school_id IN ({$schools_id}) AND (school_year='".$year."' OR ''='".$year."') and (grade='01' OR grade='02' OR grade='03' OR grade='04' OR grade='05')  GROUP BY school_id"));
		}			
		elseif (Request::input('school_level')=="Middle") {
			$tStudents=DB::select(DB::raw("SELECT sum(total_boy) AS total_boy,sum(total_girl) AS total_girl FROM `student_intake` WHERE school_id IN ({$schools_id}) AND (school_year='".$year."' OR ''='".$year."') and (grade='06' OR grade='07' OR grade='08' OR grade='09') GROUP BY school_id"));
		}
		elseif (Request::input('school_level')=="High") {
		 	$tStudents=DB::select(DB::raw("SELECT sum(total_boy) AS total_boy,sum(total_girl) AS total_girl FROM `student_intake` WHERE school_id IN ({$schools_id}) AND (school_year='".$year."' OR ''='".$year."') and (grade='10' OR grade='11') GROUP BY school_id"));
		 }
		 else {
			$tStudents=DB::select(DB::raw("SELECT sum(total_boy) AS total_boy,sum(total_girl) AS total_girl FROM `student_intake` WHERE school_id IN ({$schools_id}) AND (school_year='".$year."' OR ''='".$year."') GROUP BY school_id"));
		}
		return view('gross.percent_girls_levels',compact('region','dtSchool','tStudents','school_level','state','academic'));
		}
		catch(Exception $ex)
		{
			$record="<h4>There is no Data Record. Please Check in Searching.</h4>";
			return view('gross.percent_girls_levels',compact('region','record','school_level','state','academic'));
		}
		
		
	}
}
 