<?php
namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\DB;
class GrossEntrollmentRationLevelsController extends Controller
{
	public function create()
	{
		return view('gross.gross_enrollment_ratio_levels');
	}

	public function search()
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

		try {
			$total_intake_pri=DB::select(DB::raw("SELECT SUM(total_boy)+SUM(total_girl) AS total_students_pri,v_school.location FROM `student_intake` INNER JOIN v_school ON v_school.school_id=student_intake.school_id WHERE (student_intake.grade='01' OR student_intake.grade='02' OR student_intake.grade='03' OR student_intake.grade='04' OR student_intake.grade='05') AND (student_intake.school_year ='".$year."' OR ''='".$year."') AND (v_school.state_divsion_id ='".$state."' OR ''='".$state."') AND  (v_school.township_id ='".$town."' OR ''='".$town."')  GROUP BY v_school.location "));

		$total_populations_pri=DB::select(DB::raw("SELECT SUM(5_years)+SUM(6_years)+SUM(7_years)+SUM(8_years)+SUM(9_years) AS total_population_pri,location FROM population WHERE (state_divsion_id ='".$state."' OR ''='".$state."') AND  (township_id ='".$town."' OR ''='".$town."') AND (academic_year='".$year."' OR ''='".$year."') GROUP BY location"));

		$total_intake_mid=DB::select(DB::raw("SELECT SUM(total_boy)+SUM(total_girl) AS total_students_mid,v_school.location FROM `student_intake` INNER JOIN v_school ON v_school.school_id=student_intake.school_id WHERE (student_intake.grade='06' OR student_intake.grade='07' OR student_intake.grade='08' OR student_intake.grade='09') AND (student_intake.school_year ='".$year."' OR ''='".$year."') AND (v_school.state_divsion_id ='".$state."' OR ''='".$state."') AND  (v_school.township_id ='".$town."' OR ''='".$town."')  GROUP BY v_school.location "));

		$total_populations_mid=DB::select(DB::raw("SELECT SUM(10_years)+SUM(11_years)+SUM(12_years)+SUM(13_years) AS total_populations_mid,location FROM population WHERE (state_divsion_id ='".$state."' OR ''='".$state."') AND  (township_id ='".$town."' OR ''='".$town."') AND (academic_year='".$year."' OR ''='".$year."') GROUP BY location"));


		$total_intake_high=DB::select(DB::raw("SELECT SUM(total_boy)+SUM(total_girl) AS total_students_high,v_school.location FROM `student_intake` INNER JOIN v_school ON v_school.school_id=student_intake.school_id WHERE (student_intake.grade='10' OR student_intake.grade='11') AND (student_intake.school_year ='".$year."' OR ''='".$year."') AND (v_school.state_divsion_id ='".$state."' OR ''='".$state."') AND  (v_school.township_id ='".$town."' OR ''='".$town."')  GROUP BY v_school.location "));

		$total_populations_high=DB::select(DB::raw("SELECT SUM(14_years)+SUM(15_years) AS total_populations_high,location FROM population WHERE (state_divsion_id ='".$state."' OR ''='".$state."') AND  (township_id ='".$town."' OR ''='".$town."') AND (academic_year='".$year."' OR ''='".$year."') GROUP BY location"));
			
		//print_r($total_populations_pri);
		return view('gross.gross_enrollment_ratio_levels',compact('region','total_intake_pri','total_populations_pri','total_intake_mid','total_populations_mid','total_intake_high','total_populations_high'));

		} catch (Exception $e) {
			$record="<h4>Please Check in Searching!</h4>";
			return view('gross.gross_enrollment_ratio_levels',compact('region','record'));
		}

		
		
		
	}
}
 