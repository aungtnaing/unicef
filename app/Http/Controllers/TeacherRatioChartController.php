<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Khill\Lavacharts\Lavacharts;
use Lava;
use Input;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class TeacherRatioChartController extends Controller {

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
		
			$q = "SELECT state_id,state_division";
		
		}

		$q .= " FROM v_state_township WHERE state_id = ".$state_id." AND (township_id = '".$township_id."' OR '' = '".$township_id."') GROUP BY state_id";

		$region = DB::select(DB::raw($q));

		$dtSchool=DB::select("SELECT SUM(student_intake.total_boy)+SUM(student_intake.total_girl) AS total_students,v_school.school_level,SUM(teacher_count.primary_no) AS total_pri,sum(teacher_count.jat_no) AS total_jat,SUM(teacher_count.sat_no) AS total_sat,SUM(teacher_count.head_no) AS total_head FROM v_school LEFT JOIN student_intake ON v_school.school_id=student_intake.school_id and v_school.school_year=student_intake.school_year LEFT JOIN teacher_count ON v_school.school_id=teacher_count.school_id AND v_school.school_year=teacher_count.school_year WHERE (v_school.state_divsion_id = '".$state_id."' OR ''='".$state_id."') AND (v_school.township_id ='".$township_id."' OR ''='".$township_id."') AND (student_intake.school_year='".$academic_year."' OR ''='".$academic_year."') GROUP BY v_school.school_level ORDER BY v_school.sort_code");

/** ----------------------------------- **/
		
		$teachers = Lava::DataTable();

		$teachers->addStringColumn('School Level')
            	   ->addNumberColumn('Teacher Ratio');

    		for($i=0;$i<count($dtSchool);$i++) {
		
				$total_teachers = $dtSchool[$i]->total_pri+$dtSchool[$i]->total_jat+$dtSchool[$i]->total_sat+$dtSchool[$i]->total_head;

				if($total_teachers) {
				
					$teachersratio = round($dtSchool[$i]->total_students/$total_teachers, 2);
				
				}

				$rowData = array(	
				     			$dtSchool[$i]->school_level, $teachersratio
				   			);

				$teachers->addRow($rowData);
			}

    	$RuralChart = Lava::ColumnChart('RuralTeacher');
		$RuralChart->datatable($teachers)
					->colors(array('#0066ff'))
					->fontSize(14);

			if(count($dtSchool)) {
				
				return view('teacher_report.teacher_ratio_barchart', compact('RuralChart', 'UrbanChart'));	
				
			} else {
				
				$error = "There is no data in this State or Townshiip.";
				return view('teacher_report.teacher_ratio_barchart', compact('error'));
			
			}

			$err = "There is no data.";
			throw new Exception($err);

		} catch (Exception $e) {

			$error = "There is no data.";
			return view('teacher_report.teacher_ratio_barchart', compact('error'));

		}		
	}					
		

	/**d
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('teacher_report.teacher_ratio_barchart');
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
	public function show()
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