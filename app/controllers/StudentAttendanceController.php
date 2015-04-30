<?php

class StudentAttendanceController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		if(Input::get('township_id')) {

			$q = "SELECT state_division, township_name";
		
		} else {
		
			$q = "SELECT state_division";
		
		}

		$q .= " FROM v_state_township WHERE state_id = ".Input::get('state_id')." AND (township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') GROUP BY state_id";

		$region = DB::select(DB::raw($q));

					
		$attendance = DB::select(DB::raw("SELECT sd.location, sl.school_level, s.school_no, s.school_name, SUM(atts.lessthan_75boy) AS boys, SUM(atts.lessthan_75girl) AS girls FROM school AS s INNER JOIN school_details AS sd ON sd.school_id = s.id INNER JOIN student_attendance AS att ON att.school_id = s.id INNER JOIN student_attendance_details AS atts ON atts.student_attendance_id = att.id INNER JOIN grade AS g ON g.id = atts.grade INNER JOIN school_level AS sl ON sl.id = sd.school_level_id AND s.state_divsion_id = ".Input::get('state_id')." AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') AND sd.school_year = '".Input::get('academic_year')."' GROUP BY sl.school_level, atts.student_attendance_id ORDER BY sl.id ASC"));
		
		//GROUP BY sd.location, sl.school_level, s.school_no, s.school_name 

		return View::make('students.attendance', compact('attendance', 'region'));
	
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('students.attendance');
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
