<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Khill\Lavacharts\Lavacharts;
use Lava;
use Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermenantTemporaryChartController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		$state_id = Input::get('state_id');
		$township_id = Input::get('township_id');
		$academic_year = Input::get('academic_year');
			
			if(isset($township_id)) {

				$q = "SELECT *";
			
			} else {
			
				$q = "SELECT state_id, state_division";
			
			}
		
			$q .= " FROM v_state_township WHERE (state_id = '".$state_id."' OR ''='".$state_id."') AND (township_id = '".$township_id."' OR '' = '".$township_id."') GROUP BY state_id";
			
			$region = DB::select(DB::raw($q));
			
			$classroom = DB::select(DB::raw("SELECT s.location, s.school_level, s.school_level_id, SUM(st.total_boy) AS boys, SUM(st.total_girl) AS girls FROM v_school AS s INNER JOIN student_intake AS st ON s.school_id = st.school_id AND s.school_year = st.school_year WHERE (s.state_divsion_id = '".$state_id."' OR '' = '".$state_id."') AND (s.township_id = '".$township_id."' OR '' = '".$township_id."') AND s.school_year = '".$academic_year."' GROUP BY s.school_level, s.location ORDER BY s.sort_code ASC"));

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
			
			$rural_walls = DB::select(DB::raw("SELECT (SUM(b.permanent_wall) + SUM(b.temporary_wall)) AS rooms, v.school_level_id FROM school_building AS b INNER JOIN v_school AS v ON v.school_id = b.school_id AND v.school_year = b.school_year WHERE v.school_level_id IN ({$rural_levels_id}) AND (v.state_divsion_id = '".$state_id."' OR '' = '".$state_id."') AND (v.township_id = '".$township_id."' OR '' = '".$township_id."') AND v.school_year = '".$academic_year."' GROUP BY v.school_level_id"));

			$urban_walls = DB::select(DB::raw("SELECT (SUM(b.permanent_wall) + SUM(b.temporary_wall)) AS rooms, v.school_level_id FROM school_building AS b INNER JOIN v_school AS v ON v.school_id = b.school_id AND v.school_year = b.school_year WHERE v.school_level_id IN ({$urban_levels_id}) AND (v.state_divsion_id = '".$state_id."' OR '' = '".$state_id."') AND (v.township_id = '".$township_id."' OR '' = '".$township_id."') AND v.school_year = '".$academic_year."' GROUP BY v.school_level_id"));

/** ------------------- **/
		
		for($i = 0; $i < count($classroom); $i++) {

			if($classroom[$i]->location == "Rural") {
				$rural_level[] = $classroom[$i]->school_level;
			}

			if($classroom[$i]->location == "Urban") {
				$urban_level[] = $classroom[$i]->school_level;
			}

		}

		$rural_levels = array_values(array_unique($rural_level));
		$urban_levels = array_values(array_unique($urban_level));


/**----- start rural -----**/

		$classrooms = Lava::DataTable();

		$classrooms->addStringColumn('School Level')
            	   ->addNumberColumn('Classroom Ratio');

		for($k = 0; $k < count($rural_levels); $k++) {	
			foreach($classroom as $c) {
				if($c->location == "Rural" && $c->school_level == $rural_levels[$k]) {

					$totalstd = $c->boys + $c->girls;
						
					foreach($rural_walls as $w) {
						if($w->school_level_id == $c->school_level_id) {
							if($w->rooms) {	
									
								$classratio[] = round(($totalstd/$w->rooms), 2);
					
							} else {
								$classratio[] = 0;
							}	
						}		
					}
				}}
				
				$rowData = array(
				     			$rural_levels[$k], $classratio[$k]
				   			);

				$classrooms->addRow($rowData);
			}	

		$RuralChart = Lava::ColumnChart('Classes');
		$RuralChart->datatable($classrooms)
					->colors(array('#0066ff'))
					->fontSize(14);

/**----- start urban -----**/

		$urbanclassrooms = Lava::DataTable();

		$urbanclassrooms->addStringColumn('School Level')
            	   ->addNumberColumn('Classroom Ratio');

		for($l = 0; $l < count($urban_levels); $l++) {	
			foreach($classroom as $c) {
				if($c->location == "Urban" && $c->school_level == $urban_levels[$l]) {

					$totalstd = $c->boys + $c->girls;
						
					foreach($urban_walls as $w) {
						if($w->school_level_id == $c->school_level_id) {
							if($w->rooms) {	
									
								$classratio[] = round(($totalstd/$w->rooms), 2);
					
							} else {
								$classratio[] = 0;
							}	
						}		
					}
				}}
				
				$rowData = array(
				     			$urban_levels[$l], $classratio[$l]
				   			);

				$urbanclassrooms->addRow($rowData);
			}	

		$UrbanChart = Lava::ColumnChart('UrbanClasses');
		$UrbanChart->datatable($urbanclassrooms)
					->colors(array('#0066ff'))
					->fontSize(14);			

		return view('students.ClassroomChart', compact('RuralChart', 'UrbanChart'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('students.ClassroomChart');
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
