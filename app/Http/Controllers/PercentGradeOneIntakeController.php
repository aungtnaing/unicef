<?php
namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\DB;

class PercentGradeOneIntakeController extends Controller
{
	public function create()
	{
		return view('gross.gradeonepercent');
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
			$tStudents=DB::select(DB::raw("SELECT intake.total_boy,intake.total_girl,intake.ppeg1_boy,intake.ppeg1_girl,intake.school_id,v_school.school_no,v_school.school_name,v_school.location,v_school.school_level FROM student_intake AS intake INNER JOIN v_school ON v_school.school_id=intake.school_id WHERE (v_school.state_divsion_id = '".$state."' OR ''='".$state."') AND (v_school.township_id ='".$town."' OR ''='".$town."') AND (intake.school_year='".$year."' OR ''='".$year."') AND intake.grade='01' GROUP BY intake.school_id "));
		
			return view('gross.gradeonepercent',compact('region','tStudents'));
		} catch (Exception $e) {
			$record="<h4>Please check for searching!</h4>";
			return view('gross.gradeonepercent',compact('region','record'));
		}
		

		
		
		
	}
}
 