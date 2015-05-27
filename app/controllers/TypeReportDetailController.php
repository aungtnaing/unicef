<?php

class TypeReportDetailController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if(Input::get('state_id') || Input::get('township_id')) {
			
			if(Input::get('township_id')) {

				$q = "SELECT state_division, township_name";
			
			} else {
			
				$q = "SELECT state_division";
			
			}

			$q .= " FROM v_state_township WHERE (state_id = '".Input::get('state_id')."' OR '' = '".Input::get('state_id')."') AND (township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') GROUP BY state_id";

			$region = DB::select(DB::raw($q));

		} else {
			$region = "";
		}
		

		$type_report_detail = DB::select(DB::raw("SELECT location, school_level, school_no, school_name FROM v_school WHERE (state_divsion_id = '".Input::get('state_id')."' OR '' = '".Input::get('state_id')."') AND (township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') AND school_year = '".Input::get('academic_year')."' ORDER BY location, sort_code"));

		
		return View::make('students.type_report_detail', compact('type_report_detail', 'region'));
	
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('students.type_report_detail');
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
