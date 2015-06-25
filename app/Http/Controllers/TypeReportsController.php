<?php namespace App\Http\Controllers;

use Redirect;
use Input;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TypeReportsController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{

		if((!Input::get('btn_search'))) {

		if(((Session::has('state_id') && Session::has('academic_year')) || Session::has('township_id'))) {

			$state_id = Session::get('state_id');
			$township_id = Session::get('township_id');
			$academic_year = Session::get('academic_year');
		
		}}
		else
		{

			$state_id = Input::get('state_id');
			$township_id = Input::get('township_id');
			$academic_year = Input::get('academic_year');
			
		}
		
		if($township_id) {

			$q = "SELECT *";
		
		} else {
		
			$q = "SELECT state_id, state_division";
		
		}
	
		$q .= " FROM v_state_township WHERE state_id = ".$state_id." AND (township_id = '".$township_id."' OR '' = '".$township_id."') GROUP BY state_id";
		
		$region = DB::select(DB::raw($q));

		$type_report = DB::select(DB::raw("SELECT location, school_level, count(school_level) AS TotalSchools FROM v_school WHERE state_divsion_id = ".$state_id." AND (township_id = '".$township_id."' OR '' = '".$township_id."') AND school_year = '".$academic_year."' GROUP BY location, school_level ORDER BY location, sort_code"));
	
		return view('students.type_report', compact('type_report', 'region'));
	
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(Request $request)
	{
	
		var_dump($request->input('btn_search'));
		//die();
		if($request->input('btn_search')!=null)
		{
			
			if((Session::has('state_id') && Session::has('academic_year')) || Session::has('township_id')) {
			echo "true";
			//return Redirect::action('TypeReportsController@index');
		}
		}	
		else {
			echo "true";
			return view('students.type_report');
		}
		
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
		try{

			if((!Input::get('btn_search'))) {

		if(((Session::has('state_id') && Session::has('academic_year')) || Session::has('township_id'))) {

			$state_id = Session::get('state_id');
			$township_id = Session::get('township_id');
			$academic_year = Session::get('academic_year');
		
		}}
		else
		{

			$state_id = Input::get('state_id');
			$township_id = Input::get('township_id');
			$academic_year = Input::get('academic_year');
			
		}
			if(isset($township_id)) {

			$q = "SELECT state_division, township_name";
		
		} else {
		
			$q = "SELECT state_division";
		
		}
	
		$q .= " FROM v_state_township WHERE state_id = ".$state_id." AND (township_id = '".$township_id."' OR '' = '".$township_id."') GROUP BY state_id";
		
		$region = DB::select(DB::raw($q));

		$type_report = DB::select(DB::raw("SELECT location, school_level, count(school_level) AS TotalSchools FROM v_school WHERE state_divsion_id = ".$state_id." AND (township_id = '".$township_id."' OR '' = '".$township_id."') AND school_year = '".$academic_year."' GROUP BY location, school_level ORDER BY location, sort_code"));
		foreach ($type_report as $report) {
			$post[]=get_object_vars($report);
		}
		$state_naem=DB::select(DB::raw("SELECT state_division FROM state_division WHERE id=".$state_id));
		$township_name=DB::select(DB::raw("SELECT township_name FROM township WHERE id=".$township_id));
		$request_input=array($state_naem[0]->state_division,$township_name[0]->township_name,$academic_year);
	
	Excel::create('Type Report', function($excel) use($post, $request_input) {

    		$excel->sheet('Type Report', function($sheet) use($post,$request_input) {

    		//$sheet->fromArray($post[0]);
    		$sheet->prependRow(array('Township Education Management Information System'))->mergeCells('A1:B1',function($cells){
    				$cells->setFontWeight('bold');
    				$cells->setFontSize(18);
    				$cells->setAlignment('center');
    				 $cells->setValignment('middle');
    			});
    		$sheet->appendRow(array('No of School by School Type, Urban/Rual Report'))->mergeCells('A2:B2',function($cells){
    				$cells->setFontWeight('bold');
    				$cells->setFontSize(18);
    				$cells->setAlignment('center');
    				 $cells->setValignment('middle');
    			});
    		$sheet->appendRow(array('Division : '.$request_input[0]))->mergeCells('A3:B3',function($cells){
    			$cells->setFontWeight('bold');
    				$cells->setFontSize(18);
    				$cells->setAlignment('left');
    				 $cells->setValignment('middle');
    		});
    		$sheet->appendRow(array('Township : '.$request_input[1]))->mergeCells('A4:B4',function($cell){
    			$cell->setFontWeight('bold');
    				$cell->setFontSize(11);
    				$cell->setAlignment('right');
    				 $cell->setValignment('middle');
    		});
    		$sheet->appendRow(array('Academic Year :'.$request_input[2]))->mergeCells('A5:B5',function($cell){
    			$cell->setFontWeight('bold');
    			$cell->setFontSize(18);
    			$cell->setAlignment('left');
    			$cell->setValignment('middle');
    		});
    		$total="";
    		for($i = 0; $i < count($post); $i++) {

			if($post[$i]['location']== "Rural") {
				$rural_level[] = $post[$i]['location'];
			}

			if($post[$i]['location']== "Urban") {
				$urban_level[] = $post[$i]['location'];
			}

			$total += (int)$post[$i]['TotalSchools'];

		}

		$rural_levels = array_values(array_unique($rural_level));
		$urban_levels = array_values(array_unique($urban_level));
		
		$count=$sheet->getHighestRow()+1;
		$sheet->appendRow(array('Location :'.$rural_levels[0]))->mergeCells('A'.$count.':B'.$count,function($cell){
		$cell->setFontWeight('bold');
    		$cell->setFontSize(18);
    		$cell->setAlignment('left');
    		$cell->setValignment('middle');
		});
		$sheet->appendRow(array('School Level','Total Schools'));
    		for($i=0;$i<count($rural_level);$i++)
    		{
    			$sheet->appendRow(array($post[$i]['school_level'],$post[$i]['TotalSchools']));
    			
    		}
    	$count=$sheet->getHighestRow()+1;	
    	$sheet->appendRow(array('Location :'.$urban_levels[0]))->mergeCells('A'.$count.':B'.$count,function($cell){
			$cell->setFontWeight('bold');
    		$cell->setFontSize(18);
    		$cell->setAlignment('left');
    		$cell->setValignment('middle');
		});
		$sheet->appendRow(array('School Level','Total Schools'));
    	for($i=0;$i<count($urban_level);$i++)
    	{
    		$sheet->appendRow(array($post[count($rural_level)+$i]['school_level'],$post[count($rural_level)+$i]['TotalSchools']));
    	}
    	$count=$sheet->getHighestRow()+1;
    	$sheet->appendRow(array('Total :'.$total))->mergeCells('A'.$count.':B'.$count,function($cell){
			$cell->setFontWeight('bold');
    		$cell->setFontSize(18);
    		$cell->setAlignment('left');
    		$cell->setValignment('middle');
		});
		$sheet->setBorder('A1'.':B'.$sheet->getHighestRow(), 'thin');

    	});

	})->export('xlsx');
		 
	}
		catch(\Exception $ex) {
			echo "<script type='text/javascript'>alert('Please Choose State/Division At First')</script>";
			return Redirect::route('TypeReport');
		}
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
