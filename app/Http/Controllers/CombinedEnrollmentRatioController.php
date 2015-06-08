<?php
namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\DB;

class CombinedEnrollmentRatioController extends Controller
{
	public function create()
	{
		return view('gross.combined_enrollment_ratio_levels');
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

		
			
		
		return view('gross.combined_enrollment_ratio_levels',compact('region'));
		
		
	}
}
 