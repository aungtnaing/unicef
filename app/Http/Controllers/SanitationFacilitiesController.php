<?php namespace App\Http\Controllers;

use Redirect;
use Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class SanitationFacilitiesController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		try {

			if(Input::get('township_id')) {

				$q = "SELECT *";
				
			} else {
			
				$q = "SELECT state_id, state_division";
				
			}
			
			$q .= " FROM v_state_township WHERE state_id = ".Input::get('state_id')." AND (township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') GROUP BY state_id";
				
			$region = DB::select(DB::raw($q));

			$latrine = DB::select(DB::raw("SELECT s.location, s.school_level, COUNT(infra.school_id) AS proper_facilities FROM school_infrastructure AS infra INNER JOIN v_school AS s ON s.school_id = infra.school_id AND s.school_year = infra.school_year WHERE (SELECT (SUM(`latrine_totalboy`) + SUM(`latrine_totalgirl`) + SUM(`latrine_totalboth`)) FROM school_infrastructure) > (SELECT SUM(`latrine_repair_boy`) + SUM(`latrine_repair_girl`) + SUM(`latrine_repair_both`) FROM school_infrastructure) AND (s.state_divsion_id = '".Input::get('state_id')."' OR '' = '".Input::get('state_id')."') AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') AND s.school_year = '".Input::get('academic_year')."' GROUP BY s.school_level_id, s.location"));

			$total_std = DB::select(DB::raw("SELECT s.location, s.school_level, count(infra.school_id) AS total_school FROM school_infrastructure AS infra INNER JOIN v_school AS s ON s.school_id = infra.school_id AND s.school_year = infra.school_year WHERE (s.state_divsion_id = '".Input::get('state_id')."' OR '' = '".Input::get('state_id')."') AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') AND s.school_year = '".Input::get('academic_year')."' GROUP BY s.school_level_id, s.location"));

			if(count($latrine) && count($total_std)) {


				return view('students.sanitation_facilities',compact('region','latrine','total_std'));

			} else {

				$error = "There is no data in this State or Townshiip.";
				return view('students.sanitation_facilities', compact('error'));
			}
		}
		catch(Exception $ex)
		{
			$record="<h4>There is no Data Records.</h4>";
			return view('students.sanitation_facilities',compact('region','record'));
		}	

	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('students.sanitation_facilities');
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
		try {

			if(Input::get('township_id')) {

				$q = "SELECT *";
				
			} else {
			
				$q = "SELECT state_id, state_division";
				
			}
			
			$q .= " FROM v_state_township WHERE state_id = ".Input::get('state_id')." AND (township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') GROUP BY state_id";
				
			$region = DB::select(DB::raw($q));

			$latrine = DB::select(DB::raw("SELECT s.location, s.school_level, COUNT(infra.school_id) AS proper_facilities FROM school_infrastructure AS infra INNER JOIN v_school AS s ON s.school_id = infra.school_id AND s.school_year = infra.school_year WHERE (SELECT (SUM(`latrine_totalboy`) + SUM(`latrine_totalgirl`) + SUM(`latrine_totalboth`)) FROM school_infrastructure) > (SELECT SUM(`latrine_repair_boy`) + SUM(`latrine_repair_girl`) + SUM(`latrine_repair_both`) FROM school_infrastructure) AND (s.state_divsion_id = '".Input::get('state_id')."' OR '' = '".Input::get('state_id')."') AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') AND s.school_year = '".Input::get('academic_year')."' GROUP BY s.school_level_id, s.location"));

			$total_std = DB::select(DB::raw("SELECT s.location, s.school_level, count(infra.school_id) AS total_school FROM school_infrastructure AS infra INNER JOIN v_school AS s ON s.school_id = infra.school_id AND s.school_year = infra.school_year WHERE (s.state_divsion_id = '".Input::get('state_id')."' OR '' = '".Input::get('state_id')."') AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') AND s.school_year = '".Input::get('academic_year')."' GROUP BY s.school_level_id, s.location"));

			
			//if(count($latrine)>0 && count($total_stds)>0){
			
			foreach ($latrine as $latrines) {
				$school_latrine[]=get_object_vars($latrines);
			}
			foreach ($total_std as $stds) {
				$school_stds[]=get_object_vars($stds);
			}
			$state_name=DB::select(DB::raw("SELECT state_division FROM state_division WHERE id=".Input::get('state_id')));

			if(Input::get('township_id')){
				$township_name=DB::select(DB::raw("SELECT township_name FROM township WHERE id=".Input::get('township_id')));	
			}
			$request_input=array($state_name[0]->state_division,isset($township_name[0]->township_name)? $township_name[0]->township_name:'ALL',Input::get('academic_year'));

			Excel::create('Sanitation Facilities', function($excel) use($school_latrine,$school_stds,$request_input){

	    	$excel->sheet('Sanitation Facilities', function($sheet) use($school_latrine,$school_stds,$request_input){

	    		//$sheet->fromArray($post[0]);
	    		$sheet->prependRow(array('Township Education Management Information System'))->mergeCells('A1:D1',function($cells){
	    				$cells->setFontWeight('bold');
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('center');
	    				 $cells->setValignment('middle');
	    			});
	    		$sheet->appendRow(array('Schools with Sanitation Facilities'))->mergeCells('A2:D2',function($cells){
	    				$cells->setFontWeight('bold');
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('center');
	    				 $cells->setValignment('middle');
	    			});
	    		$sheet->appendRow(array('Division : '.$request_input[0]))->mergeCells('A3:D3',function($cells){
	    			$cells->setFontWeight('bold');
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('left');
	    				 $cells->setValignment('middle');
	    		});
	    		$sheet->appendRow(array('Township : '.$request_input[1]))->mergeCells('A4:D4',function($cell){
	    			$cell->setFontWeight('bold');
	    				$cell->setFontSize(11);
	    				$cell->setAlignment('right');
	    				 $cell->setValignment('middle');
	    		});
	    		$sheet->appendRow(array('Academic Year :'.$request_input[2]))->mergeCells('A5:D5',function($cell){
	    			$cell->setFontWeight('bold');
	    			$cell->setFontSize(18);
	    			$cell->setAlignment('left');
	    			$cell->setValignment('middle');
	    		});
	    		
	    		
			if (isset($school_stds) && count($school_stds)>0) {
			for($i = 0; $i < count($school_stds); $i++) {

			if($school_stds[$i]['location'] == "Rural") {
				$rural_level[] = $school_stds[$i]['school_level'];
			}

			if($school_stds[$i]['location'] == "Urban") {
				$urban_level[] = $school_stds[$i]['school_level'];
			}

		}

		$rural_levels = array_values(array_unique($rural_level));
		$urban_levels = array_values(array_unique($urban_level));

///	Stat Rural
		$count=$sheet->getHighestRow()+1;
		$sheet->appendRow(array('Location : Rural'))->mergeCells('A'.$count.':D'.$count,function($cell){
			$cell->setFontWeight('bold');
			$cell->setFontSize(18);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});
				
	$sheet->appendRow(array('School Level','No. of schools with proper sanitation facilities','Total schools','Percentage of schools with sanitation facilities'));

	for($k = 0; $k < count($rural_levels); $k++) { 
			for($s=0;$s<count($school_stds);$s++){
				for($l=0;$l<count($school_latrine);$l++){
					
					if($school_stds[$s]['location'] == "Rural" && $school_latrine[$l]['location'] == "Rural" && $school_stds[$s]['school_level'] == $rural_levels[$k]) { 
						if($school_stds[$s]['school_level'] == $school_latrine[$l]['school_level']) 
						{	
					$count=$sheet->getHighestRow()+1;
					$sheet->cell('A'.$count,function($cell) use($rural_levels,$k){
	    				$cell->setValue($rural_levels[$k]);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
					$sheet->cell('B'.$count,function($cell) use($school_latrine,$l){
	    				$cell->setValue($school_latrine[$l]['proper_facilities']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('C'.$count,function($cell) use($school_stds,$s){
	    				$cell->setValue($school_stds[$s]['total_school']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('D'.$count,function($cell) use($school_latrine,$school_stds,$l,$s){
		   				$cell->setValue(round(($school_latrine[$l]['proper_facilities']/$school_stds[$s]['total_school']) * 100,2));
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});	
				  }
				 }  
				}
			}
		} 

/// Stat Urban 
	$count=$sheet->getHighestRow()+1;
		$sheet->appendRow(array('Location : Urban'))->mergeCells('A'.$count.':D'.$count,function($cell){
			$cell->setFontWeight('bold');
			$cell->setFontSize(18);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});	
	$sheet->appendRow(array('School Level','No. of schools with proper sanitation facilities','Total schools','Percentage of schools with sanitation facilities'));

	for($l = 0; $l < count($urban_levels); $l++) { 

			for($st=0;$st<count($school_stds);$st++){
				for($lt=0;$lt<count($school_latrine);$lt++){
					
					if($school_stds[$st]['location'] == "Urban" && $school_latrine[$lt]['location'] == "Urban" && $school_stds[$st]['school_level'] == $urban_levels[$l]) { 
						if($school_stds[$st]['school_level'] == $school_latrine[$lt]['school_level']) 
						{	
					$count=$sheet->getHighestRow()+1;
					$sheet->cell('A'.$count,function($cell) use($urban_levels,$l){
	    				$cell->setValue($urban_levels[$l]);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
					$sheet->cell('B'.$count,function($cell) use($school_latrine,$lt){
	    				$cell->setValue($school_latrine[$lt]['proper_facilities']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('C'.$count,function($cell) use($school_stds,$st){
	    				$cell->setValue($school_stds[$st]['total_school']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('D'.$count,function($cell) use($school_latrine,$school_stds,$lt,$st){
		   				$cell->setValue(round(($school_latrine[$lt]['proper_facilities']/$school_stds[$st]['total_school']) * 100,2));
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});	
				  }
				 }  
				}
			}	
	}	}
	
										
			$sheet->setBorder('A1'.':D'.$sheet->getHighestRow(), 'thin');

	    	});

			 })->download('xlsx');
			
			$err = "There is no data.";
			throw new Exception($err);

		} catch (Exception $e) {

			$error = "There is no data";
			return view('students.sanitation_facilities', compact('error'));

		}

	}

}
