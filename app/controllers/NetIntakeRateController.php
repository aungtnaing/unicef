<?php

class NetIntakeRateController extends \BaseController
{
	public function create()
	{
		return View::make('gross.net_intake_rate');
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

		
			
		
		return View::make('gross.net_intake_rate',compact('region'));
		
		
	}
}
 