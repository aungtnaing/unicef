<?php
namespace App\Http\Controllers;

use Input;
use Request;
use Illuminate\Support\Facades\DB;

class StudentAttendanceController extends Controller
{

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		if(Request::input('township_id')) {

			$q = "SELECT state_division, township_name";
		
		} else {
		
			$q = "SELECT state_division";
		
		}

		$q .= " FROM v_state_township WHERE state_id = ".Request::input('state_id')." AND (township_id = '".Request::input('township_id')."' OR '' = '".Request::input('township_id')."') GROUP BY state_id";

		$region = DB::select(DB::raw($q));

		try {
			
			$attendance = DB::select(DB::raw("SELECT s.location, s.school_level, s.school_no, s.school_name,  SUM(atts.lessthan_75boy) AS boys, SUM(atts.lessthan_75girl) AS girls FROM v_school AS s INNER JOIN student_attendance AS att ON att.school_id = s.school_id INNER JOIN student_attendance_details AS atts ON atts.student_attendance_id = att.id AND s.state_divsion_id = ".Input::get('state_id')." AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') AND s.school_year = '".Input::get('academic_year')."' GROUP BY atts.student_attendance_id ORDER BY s.school_level_id ASC"));
		
		
			return view('students.attendance', compact('attendance', 'region'));		
		}
		
		catch (Exception $e) {
			$record="<h4>Please check for searching!</h4>";
			return view('students.attendance', compact('record', 'region'));	
		
		}				
		
	
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('students.attendance');
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
