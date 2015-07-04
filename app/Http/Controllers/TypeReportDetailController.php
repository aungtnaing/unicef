<?php
namespace App\Http\Controllers;

use Redirect;
use Input;
use Session;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TypeReportDetailController extends Controller {

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
			
		
		if($state_id && $township_id &&	$academic_year) {
			
			if($township_id) {

				$q = "SELECT *";
			
			} else {
			
				$q = "SELECT state_id, state_division";
			
			}
		
			$q .= " FROM v_state_township WHERE state_id = ".$state_id." AND (township_id = '".$township_id."' OR '' = '".$township_id."') GROUP BY state_id";
			
			$region = DB::select(DB::raw($q));

			$type_report_detail = DB::select(DB::raw("SELECT location, school_level, school_no, school_name FROM v_school WHERE (state_divsion_id = '".$state_id."' OR '' = '".$state_id."') AND (township_id = '".$township_id."' OR '' = '".$township_id."') AND school_year = '".$academic_year."' ORDER BY location, sort_code"));
			
			}
		
		return view('students.type_report_detail', compact('type_report_detail', 'region'));
	
	}

	public function export()
	{
		
		$state_id=Input::get('state_id');
		$township_id=Input::get('township_id');
		$academic_year=Input::get('academic_year');
			
		
		if(isset($state_id) || isset($township_id)) {
			
			if(isset($township_id)) {

				$q = "SELECT *";
			
			} else {
			
				$q = "SELECT state_id, state_division";
			
			}

			$q .= " FROM v_state_township WHERE (state_id = '".$state_id."' OR '' = '".$state_id."') AND (township_id = '".$township_id."' OR '' = '".$township_id."') GROUP BY state_id";
			
			$region = DB::select(DB::raw($q));

		} else {
			$region = "";
		}

		$type_report_detail = DB::select(DB::raw("SELECT location, school_level, school_no, school_name FROM v_school WHERE (state_divsion_id = '".$state_id."' OR '' = '".$state_id."') AND (township_id = '".$township_id."' OR '' = '".$township_id."') AND school_year = '".$academic_year."' ORDER BY location, sort_code"));
		
		foreach ($type_report_detail as $report) {
			$post[]=get_object_vars($report);
		}
		$state_naem=DB::select(DB::raw("SELECT state_division FROM state_division WHERE id=".Input::get('state_id')));
		$township_name=DB::select(DB::raw("SELECT township_name FROM township WHERE id=".Input::get('township_id')));
		$request_input=array($state_naem[0]->state_division,$township_name[0]->township_name,Input::get('academic_year'));
		Excel::create('Type Report Detail', function($excel) use($post,$request_input){

    	$excel->sheet('Type Report Detail', function($sheet) use($post,$request_input){

    		//$sheet->fromArray($post[0]);
    		$sheet->prependRow(array('Township Education Management Information System'))->mergeCells('A1:B1',function($cells){
    				$cells->setFontWeight('bold');
    				$cells->setFontSize(18);
    				$cells->setAlignment('center');
    				 $cells->setValignment('middle');
    			});
    		$sheet->appendRow(array('No of School by School Type, Urban/Rual Detail Report'))->mergeCells('A2:B2',function($cells){
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
    		
 			for($i = 0; $i < count($post); $i++) {

			if($post[$i]['location'] == "Rural") {
				$rural_level[] = $post[$i]['school_level'];
			}

			if($post[$i]['location'] == "Urban") {
				$urban_level[] = $post[$i]['school_level'];
			}

		}

		$rural_levels = array_values(array_unique($rural_level));
		$urban_levels = array_values(array_unique($urban_level));

		$count=$sheet->getHighestRow()+1;
			$sheet->appendRow(array('Location : Rural'))->mergeCells('A'.$count.':B'.$count,function($cell){
			$cell->setFontWeight('bold');
    		$cell->setFontSize(18);
    		$cell->setAlignment('left');
    		$cell->setValignment('middle');
		});
	
		for($k = 0; $k < count($rural_levels); $k++) { 
			$count=$sheet->getHighestRow()+1;
			$sheet->appendRow(array('School Level :'.$rural_levels[$k]))->mergeCells('A'.$count.':B'.$count,function($cell){
			$cell->setFontWeight('bold');
    		$cell->setFontSize(18);
    		$cell->setAlignment('left');
    		$cell->setValignment('middle');
		});
			

		$sheet->appendRow(array('School No','School Name'));
		for($i=0;$i<count($post);$i++)
    	{
    		if($post[$i]['location'] == "Rural" && $post[$i]['school_level'] == $rural_levels[$k]) { 
    		$sheet->appendRow(array($post[$i]['school_no'],$post[$i]['school_name']));
    	}
    	}

 		}

	// Stat Urban -->

	$count=$sheet->getHighestRow()+1;
		$sheet->appendRow(array('Location : Urban'))->mergeCells('A'.$count.':B'.$count,function($cell){
		$cell->setFontWeight('bold');
	    $cell->setFontSize(18);
	    $cell->setAlignment('left');
	    $cell->setValignment('middle');
	});
	for($l = 0; $l < count($urban_levels); $l++) { 	
	$count=$sheet->getHighestRow()+1;
			$sheet->appendRow(array('School Level :'.$urban_levels[$l]))->mergeCells('A'.$count.':B'.$count,function($cell){
			$cell->setFontWeight('bold');
    		$cell->setFontSize(18);
    		$cell->setAlignment('left');
    		$cell->setValignment('middle');
		});
		$sheet->appendRow(array('School No','School Name'));
		for($j=0;$j<count($post);$j++)
    	{
    		if($post[$j]['location'] == "Urban" && $post[$j]['school_level'] == $urban_levels[$l]) { 
    		$sheet->appendRow(array($post[$j]['school_no'],$post[$j]['school_name']));
    	}
    	}	
	
		}		// print_r($rural_levels);
		
		
		$sheet->setBorder('A1'.':B'.$sheet->getHighestRow(), 'thin');

    	});

		 })->export('xls');
		
		//}
		/*catch(\Exception $ex){
			echo "<script type='text/javascript'>alert('Please Choose State/Division At First')</script>";
			return Redirect::route('TypeReportDetail');
		}*/	
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		
		return view('students.type_report_detail');
		
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
