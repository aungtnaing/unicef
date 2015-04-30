<?php

class PermenantTemporaryController extends \BaseController {

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
		

		$classroom = DB::select(DB::raw("SELECT s.location, s.school_level, s.school_level_id, SUM(st.total_boy) AS boys, SUM(st.total_girl) AS girls FROM v_school AS s INNER JOIN student_intake AS st ON s.school_id = st.school_id AND (s.state_divsion_id = '".Input::get('state_id')."' OR '' = '".Input::get('state_id')."') AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') AND s.school_year = '".Input::get('academic_year')."' GROUP BY s.school_level, s.location ORDER BY s.sort_code ASC"));

		foreach ($classroom as $class) {
			
			if($class->location == "Rural") {
				$rural_level_id[] = $class->school_level_id;
			}

			if($class->location == "Urban") {
				$urban_level_id[] = $class->school_level_id;
			}
		}
		
		$rural_levels_id = "'".implode("','", $rural_level_id)."'";
		$urban_levels_id = "'".implode("','", $urban_level_id)."'";
		
		$rural_walls = DB::select(DB::raw("SELECT SUM(b.permanent_wall + b.temporary_wall) AS rooms, v.school_level_id FROM school_building AS b INNER JOIN v_school AS v ON v.school_id = b.school_id AND v.school_level_id IN ({$rural_levels_id}) GROUP BY v.school_level_id"));

		$urban_walls = DB::select(DB::raw("SELECT SUM(b.permanent_wall + b.temporary_wall) AS rooms, v.school_level_id FROM school_building AS b INNER JOIN v_school AS v ON v.school_id = b.school_id AND v.school_level_id IN ({$rural_levels_id}) GROUP BY v.school_level_id"));

		return View::make('students.classroom', compact('classroom', 'rural_walls', 'urban_walls', 'region'));
	
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return View::make('students.classroom');
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
