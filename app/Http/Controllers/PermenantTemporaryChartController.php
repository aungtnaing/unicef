<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Khill\Lavacharts\Lavacharts;
use Lava;
use Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class PermenantTemporaryChartController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		try {

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
			
			$classroom = DB::select(DB::raw("SELECT s.school_level, s.school_level_id, SUM(st.total_boy) AS boys, SUM(st.total_girl) AS girls FROM v_school AS s INNER JOIN student_intake AS st ON s.school_id = st.school_id AND s.school_year = st.school_year WHERE (s.state_divsion_id = '".$state_id."' OR '' = '".$state_id."') AND (s.township_id = '".$township_id."' OR '' = '".$township_id."') AND s.school_year = '".$academic_year."' GROUP BY s.school_level ORDER BY s.sort_code ASC"));

			foreach ($classroom as $class) {
				
				$level_id[] = $class->school_level_id;
				
			}
			
			$levels_id = "'".implode("','", $level_id)."'";
						
			$rural_walls = DB::select(DB::raw("SELECT (SUM(DISTINCT b.permanent_wall) + SUM(DISTINCT b.temporary_wall)) AS rooms, v.school_level_id FROM school_building AS b INNER JOIN v_school AS v ON v.school_id = b.school_id AND v.school_year = b.school_year WHERE v.school_level_id IN ({$levels_id}) AND (v.state_divsion_id = '".$state_id."') AND (v.township_id = '".$township_id."' OR '' = '".$township_id."') AND v.school_year = '".$academic_year."' GROUP BY v.school_level_id"));

/** -------------------------------------- **/

		$classrooms = Lava::DataTable();

		$classrooms->addStringColumn('School Level')
            	   ->addNumberColumn('Classroom Ratio');

				foreach($classroom as $c) {
			
				$totalstd = $c->boys + $c->girls;
						
					foreach($rural_walls as $w) {
						if($w->school_level_id == $c->school_level_id) {
							if($w->rooms) {	
									
								$classratio = round(($totalstd/$w->rooms), 2);
					
							} else {
								$classratio = 0;
							}	
						}		
					}
				
				$rowData = array(
				     			$c->school_level, $classratio
				   			);

				$classrooms->addRow($rowData);
		}	

		$RuralChart = Lava::ColumnChart('Classes');
		$RuralChart->datatable($classrooms)
					->colors(array('#0066ff'))
					->fontSize(14);

		
			if(count($classroom)) {
				
				return view('students.ClassroomChart', compact('RuralChart', 'UrbanChart'));
				
			} else {
				
				$error = "There is no data in this State or Townshiip.";
				return view('students.ClassroomChart', compact('error'));
			
			}

			$err = "There is no data.";
			throw new Exception($err);

		} catch (Exception $e) {

			$error = "There is no data.";
			return view('students.ClassroomChart', compact('error'));

		}
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
