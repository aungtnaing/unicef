<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TypeReportController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index(Request $request)
	{
		
		if($request->input('township_id')) {

			$q = "SELECT state_division, township_name";
		
		} else {
		
			$q = "SELECT state_division";
		
		}
	
		$q .= " FROM v_state_township WHERE state_id = ".$request->input('state_id')." AND (township_id = '".$request->input('township_id')."' OR '' = '".$request->input('township_id')."') GROUP BY state_id";
		
		$region = DB::select(DB::raw($q));

		$type_report = DB::select(DB::raw("SELECT location, school_level, count(school_level) AS TotalSchools FROM v_school WHERE state_divsion_id = ".$request->input('state_id')." AND (township_id = '".$request->input('township_id')."' OR '' = '".$request->input('township_id')."') AND school_year = '".$request->input('academic_year')."' GROUP BY location, school_level ORDER BY location, sort_code"));

		return view('students.type_report', compact('type_report', 'region'));
	
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('students.type_report');
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Responseemployee
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
