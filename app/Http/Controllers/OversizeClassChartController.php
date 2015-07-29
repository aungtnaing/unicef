<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Khill\Lavacharts\Lavacharts;
use Lava;
use Request;
use Illuminate\Support\Facades\DB;
use Exception;

class OversizeClassChartController extends Controller {

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

			$primary = DB::select(DB::raw("SELECT s.school_id, s.school_no, s.school_name, s.school_level, s.location, count(a.class) AS primary_class FROM student_intake AS a INNER JOIN v_school AS s ON s.school_id = a.school_id AND s.school_year = a.school_year INNER JOIN township AS t ON t.id = s.township_id WHERE a.school_year = '".Request::input('academic_year')."' AND (a.total_boy + a.total_girl) > 40 AND grade BETWEEN 01 AND 05 AND s.state_divsion_id = ".Request::input('state_id')." AND (s.township_id = '".Request::input('township_id')."' OR '' = '".Request::input('township_id')."') GROUP BY s.location ORDER BY s.location"));

			$middle = DB::select(DB::raw("SELECT s.school_id, s.school_no, s.school_name, s.school_level, s.location, count(a.class) AS middle_class FROM student_intake AS a INNER JOIN v_school AS s ON s.school_id = a.school_id AND s.school_year = a.school_year INNER JOIN township AS t ON t.id = s.township_id WHERE a.school_year = '".Request::input('academic_year')."' AND (a.total_boy + a.total_girl) > 40 AND grade BETWEEN 06 AND 09 AND s.state_divsion_id = ".Request::input('state_id')." AND (s.township_id = '".Request::input('township_id')."' OR '' = '".Request::input('township_id')."') GROUP BY s.location ORDER BY s.location"));

			$high = DB::select(DB::raw("SELECT s.school_id, s.school_no, s.school_name, s.school_level, s.location, count(a.class) AS high_class FROM student_intake AS a INNER JOIN v_school AS s ON s.school_id = a.school_id AND s.school_year = a.school_year INNER JOIN township AS t ON t.id = s.township_id WHERE a.school_year = '".Request::input('academic_year')."' AND (a.total_boy + a.total_girl) > 40 AND grade BETWEEN 10 AND 11 AND s.state_divsion_id = ".Request::input('state_id')." AND (s.township_id = '".Request::input('township_id')."' OR '' = '".Request::input('township_id')."') GROUP BY s.location ORDER BY s.location"));

			$total = DB::select(DB::raw("SELECT s.school_id, s.school_no, s.school_name, s.location, count(a.class) AS total_class FROM student_intake AS a INNER JOIN v_school AS s ON s.school_id = a.school_id AND s.school_year = a.school_year INNER JOIN township AS t ON t.id = s.township_id WHERE a.school_year = '".Request::input('academic_year')."' AND s.state_divsion_id = ".Request::input('state_id')." AND (s.township_id = '".Request::input('township_id')."' OR '' = '".Request::input('township_id')."') GROUP BY s.location ORDER BY s.location"));


/**** Start Rural ****/

			$lava = new Lavacharts; // See note below for Laravel

			$RuralClass = Lava::DataTable();

			$RuralClass->addStringColumn('Oversize classes')
			       	->addNumberColumn('Percent')
			       	->addRow(array('SHS', (int)$high[0]->high_class))
			        ->addRow(array('SMS', (int)$middle[0]->middle_class))
			        ->addRow(array('SPS', (int)$primary[0]->primary_class))
			        ->addRow(array('Total class', (int)$total[0]->total_class));

			$RuralChart = Lava::PieChart('RuralOversizeClasses');
			$RuralChart->datatable($RuralClass)
					->title('Percentage of oversize classes for Rural')
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

			$UrbanClass = Lava::DataTable();

			$UrbanClass->addStringColumn('Oversize classes')
			       	->addNumberColumn('Percent')
			       	->addRow(array('SHS', (int)$high[1]->high_class))
			        ->addRow(array('SMS', (int)$middle[1]->middle_class))
			        ->addRow(array('SPS', (int)$primary[1]->primary_class))
			        ->addRow(array('Total class', (int)$total[1]->total_class));

			$UrbanChart = Lava::PieChart('UrbanOversizeClasses');
			$UrbanChart->datatable($UrbanClass)
					->title('Percentage of oversize classes for Urban')
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

				
			return view('percentage_class_classroom_library.percentage_of_oversized_class_chart', compact('RuralChart', 'UrbanChart'));		
				
			$err = "There is no data.";
			throw new Exception($err);

		} catch (Exception $e) {

			$error = "There is no data.";
			return view('teacher_report.teacher_ratio_barchart', compact('error'));

		}	
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('percentage_class_classroom_library.percentage_of_oversized_class_chart');
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
