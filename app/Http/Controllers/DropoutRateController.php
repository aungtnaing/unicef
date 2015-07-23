<?php namespace App\Http\Controllers;

use Redirect;
use Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DropoutRateController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		try{

			if(Input::get('township_id')) {

				$q = "SELECT *";
				
			} else {
			
				$q = "SELECT state_id, state_division";
				
			}
			
			$q .= " FROM v_state_township WHERE state_id = ".Input::get('state_id')." AND (township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') GROUP BY state_id";
				
			$region = DB::select(DB::raw($q));

			$new_total = DB::select(DB::raw("SELECT SUM(new_boy)+SUM(new_girl) AS total_students,student_intake.grade FROM `student_intake` INNER JOIN v_school ON v_school.school_id=student_intake.school_id AND v_school.school_year = student_intake.school_year WHERE (v_school.state_divsion_id ='".Input::get('state_id')."' OR ''='".Input::get('state_id')."') AND (v_school.township_id ='".Input::get('township_id')."' OR ''='".Input::get('township_id')."') AND (student_intake.school_year='".Input::get('academic_year')."' OR ''='".Input::get('academic_year')."') AND student_intake.grade!='01' GROUP BY student_intake.grade"));

			$pre_total = DB::select(DB::raw("SELECT SUM(total_boy)+SUM(total_girl) AS total_students,student_intake.grade FROM `student_intake` INNER JOIN v_school ON v_school.school_id=student_intake.school_id AND v_school.school_year = student_intake.school_year WHERE (v_school.state_divsion_id ='".Input::get('state_id')."' OR ''='".Input::get('state_id')."') AND  (v_school.township_id ='".Input::get('township_id')."' OR ''='".Input::get('township_id')."') AND (student_intake.school_year='".Input::get('previous_year')."' OR ''='".Input::get('previous_year')."') AND student_intake.grade!='11' GROUP BY student_intake.grade"));

			$repeater = DB::select(DB::raw("SELECT intake.grade, (SUM(repeat_boy) + SUM(repeat_girl)) AS repeaters FROM student_intake AS intake INNER JOIN v_school AS s ON intake.school_id = s.school_id AND s.school_year = intake.school_year WHERE (s.state_divsion_id = '".Input::get('state_id')."' OR '' = '".Input::get('state_id')."') AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') AND s.school_year = '".Input::get('academic_year')."' GROUP BY intake.grade"));

			$total_std = DB::select(DB::raw("SELECT intake.grade, (SUM(total_boy) + SUM(total_girl)) AS students FROM student_intake AS intake INNER JOIN v_school AS s ON intake.school_id = s.school_id AND s.school_year = intake.school_year WHERE (s.state_divsion_id = '".Input::get('state_id')."' OR '' = '".Input::get('state_id')."') AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') AND s.school_year = '".Input::get('previous_year')."' GROUP BY intake.grade"));

			return view('student_flow_rate.dropout_rate',compact('region','new_total', 'pre_total', 'repeater','total_std'));

		}
		catch(Exception $ex)
		{
			$record="<h4>There is no Data Records.Please Check in Searching.</h4>";
			return view('student_flow_rate.dropout_rate',compact('region','record'));
		}

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('student_flow_rate.dropout_rate');
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
