<?php
namespace App\Http\Controllers;

use Input;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PercentGirlLevelController extends Controller
{
	public function create()
	{

		$state = DB::select(DB::raw("SELECT * FROM state_division ORDER BY id DESC"));
	
		$academic = DB::select(DB::raw("SELECT * FROM academicyear"));

		// //$view->with(compact('state', 'academic'));
		return view('gross.percent_girls_levels',compact('state','academic'));
	}

	public function search()
	{
		$school_level=Input::get('school_level');
		$state = DB::select(DB::raw("SELECT * FROM state_division ORDER BY id DESC"));
	
		$academic = DB::select(DB::raw("SELECT * FROM academicyear"));

		if(Input::get('township_id')) {

			$q = "SELECT state_division, township_name";
		
		} else {
		
			$q = "SELECT state_division";
		
		}

		$q .= " FROM v_state_township WHERE state_id = ".Input::get('state_id')." AND (township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') GROUP BY state_id";

		$region = DB::select(DB::raw($q));

		try
		{
			$dtSchool = DB::select(DB::raw("SELECT school_id,location,school_level,school_no,school_name FROM v_school WHERE  (state_divsion_id = '".Input::get('state_id')."' OR ''='".Input::get('state_id')."') AND (township_id ='".Input::get('township_id')."' OR ''='".Input::get('township_id')."') AND (school_year='".Input::get('academic_year')."' OR ''='".Input::get('academic_year')."')  ORDER BY sort_code,school_id ASC"));

		foreach ($dtSchool as $class) {
			
			$school_id[] = $class->school_id;

		}
		$schools_id = "'".implode("','", $school_id)."'";
		if(Input::get('school_level')=="Primary"){
			$tStudents=DB::select(DB::raw("SELECT sum(total_boy) AS total_boy,sum(total_girl) AS total_girl FROM `student_intake` WHERE school_id IN ({$schools_id}) AND (school_year='".Input::get('academic_year')."' OR ''='".Input::get('academic_year')."') and (grade='01' OR grade='02' OR grade='03' OR grade='04' OR grade='05')  GROUP BY school_id"));
		}			
		elseif (Input::get('school_level')=="Middle") {
			$tStudents=DB::select(DB::raw("SELECT sum(total_boy) AS total_boy,sum(total_girl) AS total_girl FROM `student_intake` WHERE school_id IN ({$schools_id}) AND (school_year='".Input::get('academic_year')."' OR ''='".Input::get('academic_year')."') and (grade='06' OR grade='07' OR grade='08' OR grade='09') GROUP BY school_id"));
		}
		elseif (Input::get('school_level')=="High") {
		 	$tStudents=DB::select(DB::raw("SELECT sum(total_boy) AS total_boy,sum(total_girl) AS total_girl FROM `student_intake` WHERE school_id IN ({$schools_id}) AND (school_year='".Input::get('academic_year')."' OR ''='".Input::get('academic_year')."') and (grade='10' OR grade='11') GROUP BY school_id"));
		 }
		 else {
			$tStudents=DB::select(DB::raw("SELECT sum(total_boy) AS total_boy,sum(total_girl) AS total_girl FROM `student_intake` WHERE school_id IN ({$schools_id}) AND (school_year='".Input::get('academic_year')."' OR ''='".Input::get('academic_year')."') GROUP BY school_id"));
		}
		return view('gross.percent_girls_levels',compact('region','dtSchool','tStudents','school_level','state','academic'));
		}
		catch(Exception $ex)
		{
			$record="<h4>There is no Data Record. Please Check in Searching.</h4>";
			return view('gross.percent_girls_levels',compact('region','record','school_level','state','academic'));
		}
		
		
	}

	public function show()
	{
		$school_level=Input::get('school_level');
		$state = DB::select(DB::raw("SELECT * FROM state_division ORDER BY id DESC"));
	
		$academic = DB::select(DB::raw("SELECT * FROM academicyear"));

		if(Input::get('township_id')) {

			$q = "SELECT state_division, township_name";
		
		} else {
		
			$q = "SELECT state_division";
		
		}

		$q .= " FROM v_state_township WHERE state_id = ".Input::get('state_id')." AND (township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') GROUP BY state_id";

		$region = DB::select(DB::raw($q));

		try
		{
			$dtSchool = DB::select(DB::raw("SELECT school_id,location,school_level,school_no,school_name FROM v_school WHERE  (state_divsion_id = '".Input::get('state_id')."' OR ''='".Input::get('state_id')."') AND (township_id ='".Input::get('township_id')."' OR ''='".Input::get('township_id')."') AND (school_year='".Input::get('academic_year')."' OR ''='".Input::get('academic_year')."')  ORDER BY sort_code,school_id ASC"));

		foreach ($dtSchool as $class) {
			
			$school_id[] = $class->school_id;

		}
		$schools_id = "'".implode("','", $school_id)."'";
		if(Input::get('school_level')=="Primary"){
			$tStudents=DB::select(DB::raw("SELECT sum(total_boy) AS total_boy,sum(total_girl) AS total_girl FROM `student_intake` WHERE school_id IN ({$schools_id}) AND (school_year='".Input::get('academic_year')."' OR ''='".Input::get('academic_year')."') and (grade='01' OR grade='02' OR grade='03' OR grade='04' OR grade='05')  GROUP BY school_id"));
		}			
		elseif (Input::get('school_level')=="Middle") {
			$tStudents=DB::select(DB::raw("SELECT sum(total_boy) AS total_boy,sum(total_girl) AS total_girl FROM `student_intake` WHERE school_id IN ({$schools_id}) AND (school_year='".Input::get('academic_year')."' OR ''='".Input::get('academic_year')."') and (grade='06' OR grade='07' OR grade='08' OR grade='09') GROUP BY school_id"));
		}
		elseif (Input::get('school_level')=="High") {
		 	$tStudents=DB::select(DB::raw("SELECT sum(total_boy) AS total_boy,sum(total_girl) AS total_girl FROM `student_intake` WHERE school_id IN ({$schools_id}) AND (school_year='".Input::get('academic_year')."' OR ''='".Input::get('academic_year')."') and (grade='10' OR grade='11') GROUP BY school_id"));
		 }
		 else {
			$tStudents=DB::select(DB::raw("SELECT sum(total_boy) AS total_boy,sum(total_girl) AS total_girl FROM `student_intake` WHERE school_id IN ({$schools_id}) AND (school_year='".Input::get('academic_year')."' OR ''='".Input::get('academic_year')."') GROUP BY school_id"));
		}
		foreach ($dtSchool as $School) {
			$Schools[]=get_object_vars($School);
		}

		foreach ($tStudents as $Students) {
			$detail[]=get_object_vars($Students);
		}

		$state_naem=DB::select(DB::raw("SELECT state_division FROM state_division WHERE id=".Input::get('state_id')));

			if(Input::get('township_id'))
			{
				$township_name=DB::select(DB::raw("SELECT township_name FROM township WHERE id=".Input::get('township_id')));	
			}	

			$request_input=array($state_naem[0]->state_division,isset($township_name[0]->township_name)? $township_name[0]->township_name:'ALL',Input::get('academic_year'));

			Excel::create('PercentageGirl', function($excel) use($Schools,$detail,$request_input){

	    	$excel->sheet('PercentageGirl', function($sheet) use($Schools,$detail,$request_input){

    		//$sheet->fromArray($post[0]);
	    		$sheet->prependRow(array('Township Education Management Information System'))->mergeCells('A1:C1',function($cells){
	    				$cells->setFontWeight('bold');
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('center');
	    				 $cells->setValignment('middle');
	    			});
	    		$sheet->appendRow(array('Percentage of Girls In '.Input::get('school_level').' Level Report'))->mergeCells('A2:C2',function($cells){
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
	    		
	 			for($i = 0; $i < count($Schools); $i++) {

					if($Schools[$i]['location'] == "Rural") {
						$rural_level[] = $Schools[$i]['school_level'];
					}

					if($Schools[$i]['location'] == "Urban") {
						$urban_level[] = $Schools[$i]['school_level'];
					}

				}

				$rural_levels = array_values(array_unique($rural_level));
				$urban_levels = array_values(array_unique($urban_level));

			$count=$sheet->getHighestRow()+1;
				$sheet->appendRow(array('Location : Rural'))->mergeCells('A'.$count.':C'.$count,function($cell){
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
				$sheet->appendRow(array('School Level :'.$rural_levels[$k]))->mergeCells('A'.$count.':C'.$count,function($cell){
				$cell->setFontWeight('bold');
	    		$cell->setFontSize(18);
	    		$cell->setAlignment('left');
	    		$cell->setValignment('middle');
			});

		$sheet->appendRow(array('School No','School Name','Percentage of Girls'));

	
		for($c = 0; $c < count($detail); $c++)
		{
				if($Schools[$c]['location'] == "Rural" && $Schools[$c]['school_level'] == $rural_levels[$k]) 
				{

						$count=$sheet->getHighestRow()+1;
						$sheet->cell('A'.$count,function($cell) use($Schools,$c){
		    				$cell->setValue($Schools[$c]['school_no']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
				    	$sheet->cell('B'.$count,function($cell) use($Schools,$c){
		    				$cell->setValue($Schools[$c]['school_name']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
				    	$sheet->cell('C'.$count,function($cell) use($detail,$c){
				    		$total=$detail[$c]['total_boy']+$detail[$c]['total_girl'];
							$total_girl=$detail[$c]['total_girl'];
							if($total_girl!=0)
							{
								$percent=($total_girl/$total) * 100;
								$percentages[]= $percent." %";
							}
							else
							{
								$percentages[]= "0%";
							}
		    				$cell->setValue($percentages[0]);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
					
				}
		} 
			
		}
	}//end if rural_level

	// Start Urban
	$count=$sheet->getHighestRow()+1;
	$sheet->appendRow(array('Location : Urban'))->mergeCells('A'.$count.':C'.$count,function($cell){
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
				$sheet->appendRow(array('School Level :'.$urban_levels[$l]))->mergeCells('A'.$count.':C'.$count,function($cell){
				$cell->setFontWeight('bold');
	    		$cell->setFontSize(18);
	    		$cell->setAlignment('left');
	    		$cell->setValignment('middle');
			});

		$sheet->appendRow(array('School No','School Name','Percentage'));

		for($c = 0; $c < count($detail); $c++) 
		{
				if($Schools[$c]['location'] == "Urban" && $Schools[$c]['school_level'] == $urban_levels[$l]) 
				{
						$count=$sheet->getHighestRow()+1;
						$sheet->cell('A'.$count,function($cell) use($Schools,$c){
		    				$cell->setValue($Schools[$c]['school_no']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
				    	$sheet->cell('B'.$count,function($cell) use($Schools,$c){
		    				$cell->setValue($Schools[$c]['school_name']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
				    	$sheet->cell('C'.$count,function($cell) use($detail,$c){
				    		$total=$detail[$c]['total_boy']+$detail[$c]['total_girl'];
							$total_girl=$detail[$c]['total_girl'];
							if($total_girl!=0)
							{
								$percent=($total_girl/$total) * 100;
								$percentages[]= $percent." %";
							}
							else
							{
								$percentages[]= "0%";
							}
		    				$cell->setValue($percentages[0]);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
				
					}
				
			} 

		}
	}
			$sheet->setBorder('A1'.':C'.$sheet->getHighestRow(), 'thin');

	    	});

			 })->download('xlsx');

	  }
	  catch(Exception $ex)
		{
			$record="<h4>There is no Data Record. Please Check in Searching.</h4>";
			return view('gross.percent_girls_levels',compact('region','record','school_level','state','academic'));
		}
	}
}
 