<?php
namespace App\Http\Controllers;
use Request;
use Illuminate\Support\Facades\DB;

class PercentageOfOversizedClassController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		try {
			
			if(Request::input('township_id')) {

				$q = "SELECT state_division, township_name";
			
			} else {
			
				$q = "SELECT state_division";
			
			}

			$q .= " FROM v_state_township WHERE state_id = ".Request::input('state_id')." AND (township_id = '".Request::input('township_id')."' OR '' = '".Request::input('township_id')."') GROUP BY state_id";

			$region = DB::select(DB::raw($q));

			$sc = DB::select(DB::raw("SELECT DISTINCT s.school_id, s.school_no, s.school_name, s.location, s.school_level, s.location, a.grade, a.class, (a.total_boy + a.total_girl) AS total_std FROM student_intake AS a INNER JOIN v_school AS s ON s.school_id = a.school_id INNER JOIN township AS t ON t.id = s.township_id AND a.school_year = '".Request::input('academic_year')."' AND (a.total_boy + a.total_girl) > 40 AND s.school_level_id = '".Request::input('school_level')."' AND s.state_divsion_id = ".Request::input('state_id')." AND (s.township_id = '".Request::input('township_id')."' OR '' = '".Request::input('township_id')."')"));

			$se = DB::select(DB::raw("SELECT s.location, COUNT(a.class) AS total_class FROM student_intake AS a INNER JOIN v_school AS s ON s.school_id = a.school_id INNER JOIN township AS t ON t.id = s.township_id AND a.school_year = '".Request::input('academic_year')."' AND s.school_level_id = '".Request::input('school_level')."' AND s.state_divsion_id = ".Request::input('state_id')." AND (s.township_id = '".Request::input('township_id')."' OR '' = '".Request::input('township_id')."')"));

			return view('percentage_class_classroom_library.percentage_of_oversized_class', compact('sc','se','region'));

		} catch (Exception $e) {
			
			$record = "There is no data.";
			return view('percentage_class_classroom_library.percentage_of_oversized_class', compact('record','region'));
			 
		}

	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

		return view('percentage_class_classroom_library.percentage_of_oversized_class');
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
