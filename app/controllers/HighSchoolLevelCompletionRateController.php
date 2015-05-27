<?php

class HighSchoolLevelCompletionRateController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		try {
			
			if(Input::get('township_id')) {

			$q = "SELECT state_division, township_name";
		
			} else {
			
				$q = "SELECT state_division";
			
			}

			$q .= " FROM v_state_township WHERE state_id = ".Input::get('state_id')." AND (township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') GROUP BY state_id";

			$region = DB::select(DB::raw($q));

			$current_year = DB::select(DB::raw("SELECT SUM(a.boy_pass + a.girl_pass) AS current_total_std, t.township_name, s.location, t.id FROM student_learning_achievement AS a INNER JOIN v_school AS s ON s.school_id = a.school_id INNER JOIN township AS t ON t.id = s.township_id AND a.school_year = '".Input::get('academic_year')."' and a.grade='11' AND s.state_divsion_id = ".Input::get('state_id')." AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') GROUP BY s.township_id"));
			print_r($current_year);

			$previous_year = DB::select(DB::raw("SELECT SUM(a.total_boy + a.total_girl) AS previous_total_std, t.township_name, s.location, t.id FROM student_intake AS a INNER JOIN v_school AS s ON s.school_id = a.school_id INNER JOIN township AS t ON t.id = s.township_id AND a.school_year = '".Input::get('previous_year')."' and a.grade='10' AND s.state_divsion_id = ".Input::get('state_id')." AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') GROUP BY s.township_id"));
			print_r($previous_year);

			return View::make('student_flow_rate.high_school_level_completion_rate', compact('current_year','previous_year','region'));
		
		} catch (Exception $e) {
			
			$record = "There is no data.";
			return View::make('student_flow_rate.high_school_level_completion_rate', compact('record','region')); 
					
		}
		
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('student_flow_rate.high_school_level_completion_rate');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
