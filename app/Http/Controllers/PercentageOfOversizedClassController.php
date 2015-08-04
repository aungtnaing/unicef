<?php
namespace App\Http\Controllers;
use Request;
use Input;
use Exception;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class PercentageOfOversizedClassController extends Controller {
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

			$sc = DB::select(DB::raw("SELECT s.school_id, s.school_no, s.school_name, s.school_level, s.location, count(a.class) AS oversize_class FROM student_intake AS a INNER JOIN v_school AS s ON s.school_id = a.school_id AND s.school_year = a.school_year WHERE a.school_year = '".Request::input('academic_year')."' AND (a.total_boy + a.total_girl) > 40 AND s.state_divsion_id = ".Request::input('state_id')." AND (s.township_id = '".Request::input('township_id')."' OR '' = '".Request::input('township_id')."') GROUP BY s.school_id, s.location ORDER BY s.school_level_id"));

			$se = DB::select(DB::raw("SELECT s.school_id, s.school_no, s.school_name, s.school_level, s.location, count(a.class) AS total_class FROM student_intake AS a INNER JOIN v_school AS s ON s.school_id = a.school_id AND s.school_year = a.school_year WHERE a.school_year = '".Request::input('academic_year')."' AND s.state_divsion_id = ".Request::input('state_id')." AND (s.township_id = '".Request::input('township_id')."' OR '' = '".Request::input('township_id')."') GROUP BY s.school_id, s.location ORDER BY s.school_level_id"));

			if(count($sc) && count($se)) {
				
				return view('percentage_class_classroom_library.percentage_of_oversized_class', compact('sc','se','region'));
				
			} else {
				
				$error = "There is no data in this State or Townshiip.";
				return view('percentage_class_classroom_library.percentage_of_oversized_class', compact('error'));
			
			}

			$err = "There is no data.";
			throw new Exception($err);

		} catch (Exception $e) {
			
			$record = "There is no data.";
			return view('percentage_class_classroom_library.percentage_of_oversized_class', compact('record','region'));
			 
		}

	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{

		return view('percentage_class_classroom_library.percentage_of_oversized_class');
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
		/*try {*/
			
			if(Request::input('township_id')) {

				$q = "SELECT state_division, township_name";
			
			} else {
			
				$q = "SELECT state_division";
			
			}

			$q .= " FROM v_state_township WHERE state_id = ".Request::input('state_id')." AND (township_id = '".Request::input('township_id')."' OR '' = '".Request::input('township_id')."') GROUP BY state_id";

			$region = DB::select(DB::raw($q));

			$sc = DB::select(DB::raw("SELECT s.school_id, s.school_no, s.school_name, s.school_level, s.location, count(a.class) AS oversize_class FROM student_intake AS a INNER JOIN v_school AS s ON s.school_id = a.school_id AND s.school_year = a.school_year WHERE a.school_year = '".Request::input('academic_year')."' AND (a.total_boy + a.total_girl) > 40 AND s.state_divsion_id = ".Request::input('state_id')." AND (s.township_id = '".Request::input('township_id')."' OR '' = '".Request::input('township_id')."') GROUP BY s.school_id, s.location ORDER BY s.school_level_id"));

			$se = DB::select(DB::raw("SELECT s.school_id, s.school_no, s.school_name, s.school_level, s.location, count(a.class) AS total_class FROM student_intake AS a INNER JOIN v_school AS s ON s.school_id = a.school_id AND s.school_year = a.school_year WHERE a.school_year = '".Request::input('academic_year')."' AND s.state_divsion_id = ".Request::input('state_id')." AND (s.township_id = '".Request::input('township_id')."' OR '' = '".Request::input('township_id')."') GROUP BY s.school_id, s.location ORDER BY s.school_level_id"));
			
			foreach ($sc as $obj_sc) 
			{
				$arr_sc[]=get_object_vars($obj_sc);
			}
			foreach ($se as $obj_se) 
			{
				$arr_se[]=get_object_vars($obj_se);
			}
		$state_name=DB::select(DB::raw("SELECT state_division FROM state_division WHERE id=".Input::get('state_id')));

			if(Input::get('township_id'))
			{
				$township_name=DB::select(DB::raw("SELECT township_name FROM township WHERE id=".Input::get('township_id')));	
			}	

			$request_input=array($state_name[0]->state_division,isset($township_name[0]->township_name)? $township_name[0]->township_name:'ALL',Input::get('academic_year'));

			Excel::create('Oversized40Pupil', function($excel) use($arr_se,$arr_sc,$request_input){

	    	$excel->sheet('Oversized40Pupil', function($sheet) use($arr_sc,$arr_se,$request_input){

    		//$sheet->fromArray($post[0]);
	    		$sheet->prependRow(array('Township Education Management Information System'))->mergeCells('A1:E1',function($cells){
	    				$cells->setFontWeight('bold');
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('center');
	    				 $cells->setValignment('middle');
	    			});
	    		$sheet->appendRow(array('Percentage of Oversized Classes (Sections with Over 40 Pupils)'))->mergeCells('A2:E2',function($cells){
	    				$cells->setFontWeight('bold');
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('center');
	    				 $cells->setValignment('middle');
	    			});
	    		$sheet->appendRow(array('Division : '.$request_input[0]))->mergeCells('A3:E3',function($cells){
	    			$cells->setFontWeight('bold');
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('left');
	    				 $cells->setValignment('middle');
	    		});
	    		$sheet->appendRow(array('Township : '.$request_input[1]))->mergeCells('A4:E4',function($cell){
	    			$cell->setFontWeight('bold');
	    				$cell->setFontSize(11);
	    				$cell->setAlignment('right');
	    				 $cell->setValignment('middle');
	    		});
	    		$sheet->appendRow(array('Academic Year :'.$request_input[2]))->mergeCells('A5:E5',function($cell){
	    			$cell->setFontWeight('bold');
	    			$cell->setFontSize(18);
	    			$cell->setAlignment('left');
	    			$cell->setValignment('middle');
	    		});
	    		
	 			for($i = 0; $i < count($arr_sc); $i++) {

					if($arr_sc[$i]['location'] == "Rural") {
						$rural_level[] = $arr_sc[$i]['school_level'];
					}

					if($arr_sc[$i]['location'] == "Urban") {
						$urban_level[] = $arr_sc[$i]['school_level'];
					}

				}

			
				if(isset($rural_level)) {
					$rural_levels = array_values(array_unique($rural_level));
				}
				
				if(isset($urban_level)) {
					$urban_levels = array_values(array_unique($urban_level));
				}

			$count=$sheet->getHighestRow()+1;
				$sheet->appendRow(array('Location : Rural'))->mergeCells('A'.$count.':E'.$count,function($cell){
				$cell->setFontWeight('bold');
	    		$cell->setFontSize(18);
	    		$cell->setAlignment('left');
	    		$cell->setValignment('middle');
			});

		//	<!-- Stat Rural -->
		
	
	
		if(isset($rural_level))
		 {
			for($k = 0; $k < count($rural_levels); $k++) 
			{ 
		
			$count=$sheet->getHighestRow()+1;
				$sheet->appendRow(array('School Level :'.$rural_levels[$k]))->mergeCells('A'.$count.':E'.$count,function($cell){
				$cell->setFontWeight('bold');
	    		$cell->setFontSize(18);
	    		$cell->setAlignment('left');
	    		$cell->setValignment('middle');
			});

		$sheet->appendRow(array('School No','School Name','Number Of Oversized Classes','Total Number Of Classes or Sections','Percentage of Oversized Classes'));

		for($c = 0; $c < count($arr_sc); $c++) {
				for ($p=0; $p < count($arr_se) ; $p++) {
					if($arr_sc[$c]['location'] == "Rural" && $arr_se[$p]['location'] == "Rural" && $arr_sc[$c]['school_level'] == $rural_levels[$k]) {
						if($arr_sc[$c]['school_id'] == $arr_se[$p]['school_id']) {
						$count=$sheet->getHighestRow()+1;
						$sheet->cell('A'.$count,function($cell) use($arr_sc,$c){
		    				$cell->setValue($arr_sc[$c]['school_no']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
				    	$sheet->cell('B'.$count,function($cell) use($arr_sc,$c){
		    				$cell->setValue($arr_sc[$c]['school_name']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
				    	$sheet->cell('C'.$count,function($cell) use($arr_sc,$c){
		    				$cell->setValue($arr_sc[$c]['oversize_class']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
						$sheet->cell('D'.$count,function($cell) use($arr_se,$p){

		    				$cell->setValue($arr_se[$p]['total_class']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
						$sheet->cell('E'.$count,function($cell) use($arr_sc,$c,$arr_se,$p){
							if($arr_sc[$c]['oversize_class'] && $arr_se[$p]['total_class']) {
								$rural_ratio=round($arr_sc[$c]['oversize_class']/$arr_se[$p]['total_class'] * 100, 2) . "%";
							}
							else
							{
								$rural_ratio='-';
							}
		    				$cell->setValue($rural_ratio);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});		
				
				
						
		}}} } 

	
		
			
		}
	}//end if rural_level

	// Start Urban
	$count=$sheet->getHighestRow()+1;
	$sheet->appendRow(array('Location : Urban'))->mergeCells('A'.$count.':E'.$count,function($cell){
		$cell->setFontWeight('bold');
		$cell->setFontSize(18);
		$cell->setAlignment('left');
		$cell->setValignment('middle');
	});
		
	if(isset($urban_level))
	{
		for($l = 0; $l < count($urban_levels); $l++)
		{ 
			$count=$sheet->getHighestRow()+1;
				$sheet->appendRow(array('School Level :'.$urban_levels[$l]))->mergeCells('A'.$count.':E'.$count,function($cell){
				$cell->setFontWeight('bold');
	    		$cell->setFontSize(18);
	    		$cell->setAlignment('left');
	    		$cell->setValignment('middle');
			});


		$sheet->appendRow(array('School No','School Name','Number Of Oversized Classes','Total Number Of Classes or Sections','Percentage of Oversized Classes'));

		for($c = 0; $c < count($arr_sc); $c++) {
				for ($p=0; $p < count($arr_se) ; $p++) {
					if($arr_sc[$c]['location'] == "Urban" && $arr_se[$p]['location'] == "Urban" && $arr_sc[$c]['school_level'] == $urban_levels[$l]) {
						if($arr_sc[$c]['school_id'] == $arr_se[$p]['school_id']) {
						$count=$sheet->getHighestRow()+1;
						$sheet->cell('A'.$count,function($cell) use($arr_sc,$c){
		    				$cell->setValue($arr_sc[$c]['school_no']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
				    	$sheet->cell('B'.$count,function($cell) use($arr_sc,$c){
		    				$cell->setValue($arr_sc[$c]['school_name']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
				    	$sheet->cell('C'.$count,function($cell) use($arr_sc,$c){
		    				$cell->setValue($arr_sc[$c]['oversize_class']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
						$sheet->cell('D'.$count,function($cell) use($arr_se,$p){

		    				$cell->setValue($arr_se[$p]['total_class']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
						$sheet->cell('E'.$count,function($cell) use($arr_sc,$c,$arr_se,$p){
							if($arr_sc[$c]['oversize_class'] && $arr_se[$p]['total_class']) {
								$urban_ratio=round($arr_sc[$c]['oversize_class']/$arr_se[$p]['total_class'] * 100, 2) . "%";
							}
							else
							{
								$urban_ratio='-';
							}
							
		    				$cell->setValue($urban_ratio);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});		
				
				
						
		}}} }  

		}
	}
			$sheet->setBorder('A1'.':E'.$sheet->getHighestRow(), 'thin');

	    	});

			 })->download('xlsx');
			
			$err = "There is no data.";
			throw new Exception($err);


		/*} catch (Exception $e) {
			
			$record = "There is no data.";
			return view('percentage_class_classroom_library.percentage_of_oversized_class', compact('record','region'));
			 
		}*/

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
