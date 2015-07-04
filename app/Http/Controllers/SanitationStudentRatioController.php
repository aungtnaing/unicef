<?php
namespace App\Http\Controllers;

use Request;
use Session;
use Input;
use Illuminate\Support\Facades\DB;

class SanitationStudentRatioController extends Controller

{
	public function create()
	{
		return view('students.sanitation');
	}

	public function search()
	{
		
		$state_id = Input::get('state_id');
		$township_id = Input::get('township_id');
		$academic_year = Input::get('academic_year');
			
		if($township_id) {

			$q = "SELECT *";
		
		} else {
		
			$q = "SELECT state_id,state_division";
		
		}

		$q .= " FROM v_state_township WHERE state_id = ".$state_id." AND (township_id = '".$township_id."' OR '' = '".$township_id."') GROUP BY state_id";

		$region = DB::select(DB::raw($q));

		//try{

			$dtSchool = DB::select("SELECT school_id,location,school_level,school_no,school_name FROM v_school WHERE  (state_divsion_id = '".$state_id."' OR ''='".$state_id."') AND (township_id ='".$township_id."' OR ''='".$township_id."') AND (school_year='".$academic_year."' OR ''='".$academic_year."')  ORDER BY sort_code,school_id ASC");

				
			foreach ($dtSchool as $class) {
				
				$school_id[] = $class->school_id;

			}
			
			$schools_id = "'".implode("','", $school_id)."'";		
			
			
			$tStudents=DB::select(DB::raw("SELECT total_boy+total_girl AS total_students from student_intake WHERE school_id IN ({$schools_id}) GROUP BY school_id"));
			
			$tLatrine=DB::select(DB::raw("SELECT  latrine_totalboy,latrine_totalgirl,latrine_totalboth,latrine_repair_boy,latrine_repair_girl,latrine_repair_both,enough_whole_year,enough_other_use,main_water_safety AS safe_to_drink,main_water_source AS quality FROM school_infrastructure WHERE school_id IN ({$schools_id}) AND school_year='".$academic_year."'"));
				
			return view('students.sanitation',compact('region','dtSchool','tStudents','tLatrine'));
		/*}
		catch(Exception $ex){
			$record="Please check for searching again.";
			return view('students.sanitation',compact('region','record'));
		}*/
		
		
	}
		
}
