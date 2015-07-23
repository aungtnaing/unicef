<?php namespace App\Http\Controllers;

use Redirect;
use Input;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PercentageSchoolLibraryController extends Controller {

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

			$library = DB::select(DB::raw("SELECT s.location, s.school_level, count(infra.school_id) AS school_library FROM school_infrastructure AS infra INNER JOIN v_school AS s ON s.school_id = infra.school_id AND s.school_year = infra.school_year WHERE infra.school_library = 'Yes' AND (s.state_divsion_id = '".Input::get('state_id')."') AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') AND s.school_year = '".Input::get('academic_year')."' GROUP BY s.school_level_id, s.location"));

			$total_std = DB::select(DB::raw("SELECT s.location, s.school_level, count(infra.school_id) AS total_school FROM school_infrastructure AS infra INNER JOIN v_school AS s ON s.school_id = infra.school_id AND s.school_year = infra.school_year WHERE (s.state_divsion_id = '".Input::get('state_id')."') AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') AND s.school_year = '".Input::get('academic_year')."' GROUP BY s.school_level_id, s.location"));

			return view('general_rate_report.percentage_school_library',compact('region','library','total_std'));

		}
		catch(Exception $ex)
		{
			$record="<h4>There is no Data Records.Please Check in Searching.</h4>";
			return view('general_rate_report.percentage_school_library',compact('region','record'));
		}
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('general_rate_report.percentage_school_library');
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

			$library = DB::select(DB::raw("SELECT s.location, s.school_level, count(infra.school_id) AS school_library FROM school_infrastructure AS infra INNER JOIN v_school AS s ON s.school_id = infra.school_id AND s.school_year = infra.school_year WHERE infra.school_library = 'Yes' AND (s.state_divsion_id = '".Input::get('state_id')."') AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') AND s.school_year = '".Input::get('academic_year')."' GROUP BY s.school_level_id, s.location"));

			$total_std = DB::select(DB::raw("SELECT s.location, s.school_level, count(infra.school_id) AS total_school FROM school_infrastructure AS infra INNER JOIN v_school AS s ON s.school_id = infra.school_id AND s.school_year = infra.school_year WHERE (s.state_divsion_id = '".Input::get('state_id')."') AND (s.township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') AND s.school_year = '".Input::get('academic_year')."' GROUP BY s.school_level_id, s.location"));

			foreach ($library as $latries) {
				$school_library[]=get_object_vars($latries);
			}
			foreach ($total_std as $stds) {
				$school_stds[]=get_object_vars($stds);
			}
			if(count($school_library)>0 && count($school_stds)>0){
			
			
			$state_name=DB::select(DB::raw("SELECT state_division FROM state_division WHERE id=".Input::get('state_id')));

			if(Input::get('township_id')){
				$township_name=DB::select(DB::raw("SELECT township_name FROM township WHERE id=".Input::get('township_id')));	
			}
			$request_input=array($state_name[0]->state_division,isset($township_name[0]->township_name)? $township_name[0]->township_name:'ALL',Input::get('academic_year'));

			Excel::create('School library Percentage', function($excel) use($school_library,$school_stds,$request_input){

	    	$excel->sheet('School library Percentage', function($sheet) use($school_library,$school_stds,$request_input){

	    		//$sheet->fromArray($post[0]);
	    		$sheet->prependRow(array('Township Education Management Information System'))->mergeCells('A1:C1',function($cells){
	    				$cells->setFontWeight('bold');
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('center');
	    				 $cells->setValignment('middle');
	    			});
	    		$sheet->appendRow(array('Percentage of Schools with library'))->mergeCells('A2:C2',function($cells){
	    				$cells->setFontWeight('bold');
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('center');
	    				 $cells->setValignment('middle');
	    			});
	    		$sheet->appendRow(array('Division : '.$request_input[0]))->mergeCells('A3:C3',function($cells){
	    			$cells->setFontWeight('bold');
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('left');
	    				 $cells->setValignment('middle');
	    		});
	    		$sheet->appendRow(array('Township : '.$request_input[1]))->mergeCells('A4:C4',function($cell){
	    			$cell->setFontWeight('bold');
	    				$cell->setFontSize(11);
	    				$cell->setAlignment('right');
	    				 $cell->setValignment('middle');
	    		});
	    		$sheet->appendRow(array('Academic Year :'.$request_input[2]))->mergeCells('A5:C5',function($cell){
	    			$cell->setFontWeight('bold');
	    			$cell->setFontSize(18);
	    			$cell->setAlignment('left');
	    			$cell->setValignment('middle');
	    		});
	    		
	    		
			if (isset($school_library) && count($school_stds)>0) {
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
		$sheet->appendRow(array('Location : Rural'))->mergeCells('A'.$count.':C'.$count,function($cell){
			$cell->setFontWeight('bold');
			$cell->setFontSize(18);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});
				
	
	for($k = 0; $k < count($rural_levels); $k++) { 
		$count=$sheet->getHighestRow()+1;
				$sheet->appendRow(array('School Level :'.$rural_levels[$k]))->mergeCells('A'.$count.':C'.$count,function($cell){
				$cell->setFontWeight('bold');
	    		$cell->setFontSize(18);
	    		$cell->setAlignment('left');
	    		$cell->setValignment('middle');
			});

			$sheet->appendRow(array('No. of schools with library','Total schools','Percentage of schools with library'));
			for($s=0;$s<count($school_stds);$s++){
				for($l=0;$l<count($school_library);$l++){
					
					if($school_stds[$s]['location'] == "Rural" && $school_library[$l]['location'] == "Rural" && $school_stds[$s]['school_level'] == $rural_levels[$k]) { 
						if($school_stds[$s]['school_level'] == $school_library[$l]['school_level']) 
						{	
					$count=$sheet->getHighestRow()+1;
					$sheet->cell('A'.$count,function($cell) use($school_library,$l){
	    				$cell->setValue($school_library[$l]['school_library']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('B'.$count,function($cell) use($school_stds,$s){
	    				$cell->setValue($school_stds[$s]['total_school']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('C'.$count,function($cell) use($school_library,$school_stds,$l,$s){
		   				$cell->setValue(round(($school_library[$l]['school_library']/$school_stds[$s]['total_school']) * 100),2);
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
		$sheet->appendRow(array('Location : Urban'))->mergeCells('A'.$count.':C'.$count,function($cell){
			$cell->setFontWeight('bold');
			$cell->setFontSize(18);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});	
	
	for($l = 0; $l < count($urban_levels); $l++) { 
		$count=$sheet->getHighestRow()+1;
				$sheet->appendRow(array('School Level :'.$urban_levels[$l]))->mergeCells('A'.$count.':C'.$count,function($cell){
				$cell->setFontWeight('bold');
	    		$cell->setFontSize(18);
	    		$cell->setAlignment('left');
	    		$cell->setValignment('middle');
			});

			$sheet->appendRow(array('No. of schools with Library','Total schools','Percentage of schools with Library'));
			for($st=0;$st<count($school_stds);$st++){
				for($lt=0;$lt<count($school_library);$lt++){
					
					if($school_stds[$st]['location'] == "Urban" && $school_library[$lt]['location'] == "Urban" && $school_stds[$st]['school_level'] == $urban_levels[$l]) { 
						if($school_stds[$st]['school_level'] == $school_library[$lt]['school_level']) 
						{	
					$count=$sheet->getHighestRow()+1;
					$sheet->cell('A'.$count,function($cell) use($school_library,$lt){
	    				$cell->setValue($school_library[$lt]['school_library']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('B'.$count,function($cell) use($school_stds,$st){
	    				$cell->setValue($school_stds[$st]['total_school']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('C'.$count,function($cell) use($school_library,$school_stds,$lt,$st){
		   				$cell->setValue(round(($school_library[$lt]['school_library']/$school_stds[$st]['total_school']) * 100,2));
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});	
				  }
				 }  
				}
			}	
	}	}
	
										
			$sheet->setBorder('A1'.':C'.$sheet->getHighestRow(), 'thin');

	    	});

			 })->download('xlsx');
			}
			

		}
		catch(Exception $ex)
		{
			$record="<h4>There is no Data Records.Please Check in Searching.</h4>";
			return view('general_rate_report.percentage_school_library',compact('region','record'));
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
