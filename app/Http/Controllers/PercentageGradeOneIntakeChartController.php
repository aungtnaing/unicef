<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Khill\Lavacharts\Lavacharts;
use Lava;
use Request;
use Input;
use Illuminate\Support\Facades\DB;
use Exception;

class PercentageGradeOneIntakeChartController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		$state = Input::get('state_id');
		$town = Input::get('township_id');
		$year = Input::get('academic_year');
			
		if($town) {

			$q = "SELECT *";
		
		} else {
		
			$q = "SELECT state_id, state_division";
		
		}
	
		$q .= " FROM v_state_township WHERE state_id = ".$state." AND (township_id = '".$town."' OR '' = '".$town."') GROUP BY state_id";
		
		$region = DB::select(DB::raw($q));
		
		try {
			
			$primary = DB::select(DB::raw("SELECT (SUM(intake.ppeg1_boy) + SUM(intake.ppeg1_girl)) AS primary_ppeg, v_school.school_name, v_school.location, v_school.school_level FROM student_intake AS intake INNER JOIN v_school ON v_school.school_id = intake.school_id AND intake.school_year = v_school.school_year WHERE v_school.state_divsion_id = '".$state."' AND (v_school.township_id ='".$town."' OR ''='".$town."') AND intake.school_year='".$year."' AND intake.grade BETWEEN '01' AND '05' GROUP BY v_school.location ORDER BY v_school.location ASC"));

			$middle = DB::select(DB::raw("SELECT (SUM(intake.ppeg1_boy) + SUM(intake.ppeg1_girl)) AS middle_ppeg, v_school.school_name, v_school.location, v_school.school_level FROM student_intake AS intake INNER JOIN v_school ON v_school.school_id = intake.school_id AND intake.school_year = v_school.school_year WHERE v_school.state_divsion_id = '".$state."' AND (v_school.township_id ='".$town."' OR ''='".$town."') AND intake.school_year='".$year."' AND intake.grade BETWEEN '06' AND '09' GROUP BY v_school.location ORDER BY v_school.location ASC"));

			$high = DB::select(DB::raw("SELECT (SUM(intake.ppeg1_boy) + SUM(intake.ppeg1_girl)) AS high_ppeg, v_school.school_name, v_school.location, v_school.school_level FROM student_intake AS intake INNER JOIN v_school ON v_school.school_id = intake.school_id AND intake.school_year = v_school.school_year WHERE v_school.state_divsion_id = '".$state."' AND (v_school.township_id ='".$town."' OR ''='".$town."') AND intake.school_year='".$year."' AND intake.grade BETWEEN '10' AND '11' GROUP BY v_school.location ORDER BY v_school.location ASC"));

			$total = DB::select(DB::raw("SELECT (SUM(intake.total_boy) + SUM(intake.total_girl)) AS total_std, v_school.school_name, v_school.location, v_school.school_level FROM student_intake AS intake INNER JOIN v_school ON v_school.school_id = intake.school_id AND intake.school_year = v_school.school_year WHERE v_school.state_divsion_id = '".$state."' AND (v_school.township_id ='".$town."' OR ''='".$town."') AND intake.school_year='".$year."' AND intake.grade ='01' GROUP BY v_school.location ORDER BY v_school.location ASC"));

			/**** Start Rural ****/

			$lava = new Lavacharts; // See note below for Laravel

			$RuralStudents = Lava::DataTable();

			$RuralStudents->addStringColumn('Grade 1 Percentage')
			       	->addNumberColumn('Percent')
			       	->addRow(array('SHS', (int)$high[0]->high_ppeg))
			        ->addRow(array('SMS', (int)$middle[0]->middle_ppeg))
			        ->addRow(array('SPS', (int)$primary[0]->primary_ppeg))
			        ->addRow(array('Total grade 01 students', (int)$total[0]->total_std));

			$RuralChart = Lava::PieChart('RuralPercentage');
			$RuralChart->datatable($RuralStudents)
					->title('Percentage of grade 01 intake for Rural')
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

			$UrbanStudents = Lava::DataTable();

			$UrbanStudents->addStringColumn('Grade 1 Percentage')
			       	->addNumberColumn('Percent')
			       	->addRow(array('SHS', (int)$high[1]->high_ppeg))
			        ->addRow(array('SMS', (int)$middle[1]->middle_ppeg))
			        ->addRow(array('SPS', (int)$primary[1]->primary_ppeg))
			        ->addRow(array('Total grade 01 students', (int)$total[1]->total_std));

			$UrbanChart = Lava::PieChart('UrbanPercentage');
			$UrbanChart->datatable($UrbanStudents)
					->title('Percentage of grade 01 intake for Urban')
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

			return view('gross.grade_one_percent_chart',compact('RuralChart', 'UrbanChart'));
		
			$err = "There is no data.";
			throw new Exception($err);

		} catch (Exception $e) {

			$error = "There is no data.";
			return view('gross.grade_one_percent_chart', compact('error'));

		}

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('gross.grade_one_percent_chart');
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
