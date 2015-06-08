<?php
namespace App\Http\Controllers;

use Request;
use Illuminate\Support\Facades\DB;

class TypeReportDetailController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		if(Request::input('state_id') || Request::input('township_id')) {
			
			if(Request::input('township_id')) {

				$q = "SELECT state_division, township_name";
			
			} else {
			
				$q = "SELECT state_division";
			
			}

			$q .= " FROM v_state_township WHERE (state_id = '".Request::input('state_id')."' OR '' = '".Request::input('state_id')."') AND (township_id = '".Request::input('township_id')."' OR '' = '".Request::input('township_id')."') GROUP BY state_id";

			$region = DB::select(DB::raw($q));

		} else {
			$region = "";
		}
		

		$type_report_detail = DB::select(DB::raw("SELECT location, school_level, school_no, school_name FROM v_school WHERE (state_divsion_id = '".Request::input('state_id')."' OR '' = '".Request::input('state_id')."') AND (township_id = '".Request::input('township_id')."' OR '' = '".Request::input('township_id')."') AND school_year = '".Request::input('academic_year')."' ORDER BY location, sort_code"));

		
		return view('students.type_report_detail', compact('type_report_detail', 'region'));
	
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//return View::make('students.type_report_detail');
		return view('students.type_report_detail');
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
