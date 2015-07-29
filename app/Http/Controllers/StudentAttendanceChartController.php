<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Khill\Lavacharts\Lavacharts;
use Lava;
use Request;
use Input;
use Illuminate\Support\Facades\DB;
use Exception;

class StudentAttendanceChartController extends Controller {

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
		
			$q = "SELECT state_id,state_division";
		
		}

		$q .= " FROM v_state_township WHERE state_id = ".$state_id." AND (township_id = '".$township_id."' OR '' = '".$township_id."') GROUP BY state_id";

		$region = DB::select(DB::raw($q));
		
		try {
			
			$primary = DB::select(DB::raw("SELECT s.location, s.school_level, s.school_no, s.school_name,  (SUM(atts.lessthan_75boy) + SUM(atts.lessthan_75girl)) AS primary_att FROM v_school AS s INNER JOIN student_attendance AS att ON att.school_id = s.school_id AND att.school_year=s.school_year INNER JOIN student_attendance_details AS atts ON atts.student_attendance_id = att.id AND s.state_divsion_id = ".$state_id." AND (s.township_id = '".$township_id."' OR '' = '".$township_id."') AND s.school_year = '".$academic_year."' AND atts.grade BETWEEN 01 AND 05  GROUP BY s.location ORDER BY s.location"));

			$middle = DB::select(DB::raw("SELECT s.location, s.school_level, s.school_no, s.school_name, (SUM(atts.lessthan_75boy) + SUM(atts.lessthan_75girl)) AS middle_att FROM v_school AS s INNER JOIN student_attendance AS att ON att.school_id = s.school_id AND att.school_year=s.school_year INNER JOIN student_attendance_details AS atts ON atts.student_attendance_id = att.id AND s.state_divsion_id = ".$state_id." AND (s.township_id = '".$township_id."' OR '' = '".$township_id."') AND s.school_year = '".$academic_year."' AND atts.grade BETWEEN 06 AND 09  GROUP BY s.location ORDER BY s.location"));

			$high = DB::select(DB::raw("SELECT s.location, s.school_level, s.school_no, s.school_name,  (SUM(atts.lessthan_75boy) + SUM(atts.lessthan_75girl)) AS high_att FROM v_school AS s INNER JOIN student_attendance AS att ON att.school_id = s.school_id AND att.school_year=s.school_year INNER JOIN student_attendance_details AS atts ON atts.student_attendance_id = att.id AND s.state_divsion_id = ".$state_id." AND (s.township_id = '".$township_id."' OR '' = '".$township_id."') AND s.school_year = '".$academic_year."' AND atts.grade BETWEEN 10 AND 11  GROUP BY s.location ORDER BY s.location"));

			$total = DB::select(DB::raw("SELECT s.location, (SUM(atts.total_boy) + SUM(atts.total_girl)) AS total_std FROM v_school AS s INNER JOIN student_attendance AS att ON att.school_id = s.school_id AND att.school_year=s.school_year INNER JOIN student_attendance_details AS atts ON atts.student_attendance_id = att.id AND s.state_divsion_id = ".$state_id." AND (s.township_id = '".$township_id."' OR '' = '".$township_id."') AND s.school_year = '".$academic_year."' GROUP BY s.location ORDER BY s.location"));

			
			/**** Start Rural ****/

			$lava = new Lavacharts; // See note below for Laravel

			$RuralAtt = Lava::DataTable();

			$RuralAtt->addStringColumn('RuralAtts')
			       	->addNumberColumn('Percents')
			       	->addRow(array('SHS', (int)$high[0]->high_att))
			        ->addRow(array('SMS', (int)$middle[0]->middle_att))
			        ->addRow(array('SPS', (int)$primary[0]->primary_att))
			        ->addRow(array('Total class', (int)$total[0]->total_std));

			$RuralChart = Lava::PieChart('RuralAttendance');
			$RuralChart->datatable($RuralAtt)
					->title('Attendance for Rural')
					->is3D(true)
					->slices(array(
	                        Lava::Slice(array(
	                          'offset' => 0.2
	                        )),
	                        Lava::Slice(array(
	                          'offset' => 0.25
	                        )),
	                        Lava::Slice(array(
	                          'offset' => 0.3
	                        ))
	                      ));
/**** Start Urban ****/

			$lava = new Lavacharts; // See note below for Laravel

			$UrbanAtt = Lava::DataTable();

			$UrbanAtt->addStringColumn('UrbanAtts')
			       	->addNumberColumn('Percent')
			       	->addRow(array('SHS', (int)$high[1]->high_att))
			        ->addRow(array('SMS', (int)$middle[1]->middle_att))
			        ->addRow(array('SPS', (int)$primary[1]->primary_att))
			        ->addRow(array('Total class', (int)$total[1]->total_std));

			$UrbanChart = Lava::PieChart('UrbanAttendance');
			$UrbanChart->datatable($UrbanAtt)
					->title('Attendance for Urban')
					->is3D(true)
					->slices(array(
	                        Lava::Slice(array(
	                          'offset' => 0.2
	                        )),
	                        Lava::Slice(array(
	                          'offset' => 0.25
	                        )),
	                        Lava::Slice(array(
	                          'offset' => 0.3
	                        ))
	                      ));	

			return view('students.attendance_chart', compact('RuralChart', 'UrbanChart'));		
			
			$err = "There is no data.";
			throw new Exception($err);

		} catch (Exception $e) {

			$error = "There is no data.";
			return view('students.attendance_chart', compact('error'));

		}

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('students.attendance_chart');
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
