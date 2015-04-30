<?php

class SanitationStudentRatioController extends \BaseController
{
	public function create()
	{
		return View::make('students.sanitation');
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

		
		$dtSchool = DB::select("SELECT school_id,location,school_level,school_no,school_name FROM v_school WHERE  (state_divsion_id = '".$state."' OR ''='".$state."') AND (township_id ='".$town."' OR ''='".$town."') AND (school_year='".$year."' OR ''='".$year."')  ORDER BY sort_code,school_id ASC");

				
		foreach ($dtSchool as $class) {
			
			$school_id[] = $class->school_id;

		}
		
		$schools_id = "'".implode("','", $school_id)."'";		
		
		
		$tStudents=DB::select(DB::raw("SELECT SUM((totalboy+totalgirl )) AS total_students from v_studentstatus WHERE school_id IN ({$schools_id}) GROUP BY school_id"));
		
		$tLatrine=DB::select(DB::raw("SELECT  (case when sum(latrine_totalboy) is NULL then  0 else  sum(latrine_totalboy) end + case when sum(latrine_totalgirl) is NULL then  0 else SUM( latrine_totalgirl) end + case when sum( latrine_totalboth) is NULL then  0 else  sum(latrine_totalboth) end ) AS total_latrine,(case when sum(latrine_totalboy) is NULL then  0 else  sum(latrine_totalboy) end + case when sum(latrine_totalgirl) is NULL then  0 else SUM( latrine_totalgirl) end + case when sum( latrine_totalboth) is NULL then  0 else  sum(latrine_totalboth) end )  - (case when sum(latrine_repair_boy)  is NULL then  0 else  sum(latrine_repair_boy) end + case when SUM(latrine_repair_girl) is NULL then  0 else SUM( latrine_repair_girl )end + case when sum(latrine_repair_both) is NULL then  0 else  sum(latrine_repair_both) end ) AS total_good_latrine,case when (case when  enough_whole_year='1' then 1 else 0 end + case when  enough_other_use='1' then 1 else 0 end) =2 then 'A'  when   (case when  enough_whole_year='1' then 1 else 0 end + case when  enough_other_use='1' then 1 else 0 end) = 1 then 'B' else 'C'  end AS Availability,case when  main_water_safety='1' then 'Yes' else 'No' end AS safe_to_drink,main_water_source AS quality FROM school_infrastructure WHERE school_id IN ({$schools_id}) AND school_year='".$year."' GROUP BY school_id,school_year,enough_whole_year,enough_other_use,main_water_source,main_water_safety "));
			
		return View::make('students.sanitation',compact('region','dtSchool','tStudents','tLatrine'));
		
		}
		
		}
