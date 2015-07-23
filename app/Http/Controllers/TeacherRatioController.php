<?php namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Input;
use Session;
use Redirect;
use Illuminate\Support\Facades\DB;

class TeacherRatioController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**d
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('teacher_report.teacher_ratio');
	}

	public function Search()
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

		$dtSchool=DB::select("SELECT SUM(student_intake.total_boy)+SUM(student_intake.total_girl) AS total_students,student_intake.grade,v_school.school_no,v_school.school_name,v_school.location,v_school.school_level,teacher_count.primary_no,teacher_count.jat_no,teacher_count.sat_no,teacher_count.head_no,teacher_count.office_staff_no FROM v_school LEFT JOIN student_intake ON v_school.school_id=student_intake.school_id and v_school.school_year=student_intake.school_year LEFT JOIN teacher_count ON v_school.school_id=teacher_count.school_id AND v_school.school_year=teacher_count.school_year WHERE (v_school.state_divsion_id = '".$state_id."' OR ''='".$state_id."') AND (v_school.township_id ='".$township_id."' OR ''='".$township_id."') AND (student_intake.school_year='".$academic_year."' OR ''='".$academic_year."') GROUP BY v_school.school_no,student_intake.grade ");

		
		return view('teacher_report.teacher_ratio',compact('region','dtSchool'));
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
