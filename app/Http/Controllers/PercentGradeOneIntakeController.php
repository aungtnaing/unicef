<?php
namespace App\Http\Controllers;

use Input;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PercentGradeOneIntakeController extends Controller
{
	public function create()
	{
		return view('gross.gradeonepercent');
	}

	public function search()
	{

		$state=Input::get('state_id');
		$town=Input::get('township_id');
		$year=Input::get('academic_year');

		if(Input::get('township_id')) {

			$q = "SELECT state_division, township_name";
		
		} else {
		
			$q = "SELECT state_division";
		
		}

		$q .= " FROM v_state_township WHERE state_id = ".Input::get('state_id')." AND (township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') GROUP BY state_id";

		$region = DB::select(DB::raw($q));
		try {
			$tStudents=DB::select(DB::raw("SELECT intake.total_boy,intake.total_girl,intake.ppeg1_boy,intake.ppeg1_girl,intake.school_id,v_school.school_no,v_school.school_name,v_school.location,v_school.school_level FROM student_intake AS intake INNER JOIN v_school ON v_school.school_id=intake.school_id WHERE (v_school.state_divsion_id = '".$state."' OR ''='".$state."') AND (v_school.township_id ='".$town."' OR ''='".$town."') AND (intake.school_year='".$year."' OR ''='".$year."') AND intake.grade='01' GROUP BY intake.school_id ORDER BY v_school.sort_code ASC"));

			return view('gross.gradeonepercent',compact('region','tStudents'));
		} catch (Exception $e) {
			$record="<h4>Please check for searching!</h4>";
			return view('gross.gradeonepercent',compact('region','record'));
		}
		
	}

	public function show()
	{
		if(Input::get('township_id')) {

			$q = "SELECT state_division, township_name";
		
		} else {
		
			$q = "SELECT state_division";
		
		}

		$q .= " FROM v_state_township WHERE state_id = ".Input::get('state_id')." AND (township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') GROUP BY state_id";

		$region = DB::select(DB::raw($q));
		
		$tStudents=DB::select(DB::raw("SELECT intake.total_boy,intake.total_girl,intake.ppeg1_boy,intake.ppeg1_girl,intake.school_id,v_school.school_no,v_school.school_name,v_school.location,v_school.school_level FROM student_intake AS intake INNER JOIN v_school ON v_school.school_id=intake.school_id WHERE (v_school.state_divsion_id = '".Input::get('state_id')."' OR ''='".Input::get('state_id')."') AND (v_school.township_id ='".Input::get('township_id')."' OR ''='".Input::get('township_id')."') AND (intake.school_year='".Input::get('academic_year')."' OR ''='".Input::get('academic_year')."') AND intake.grade='01' GROUP BY intake.school_id ORDER BY v_school.sort_code ASC "));

		foreach ($tStudents as $students) 
		{
			$detail[]=get_object_vars($students);
		}
		$state_naem=DB::select(DB::raw("SELECT state_division FROM state_division WHERE id=".Input::get('state_id')));

			if(Input::get('township_id'))
			{
				$township_name=DB::select(DB::raw("SELECT township_name FROM township WHERE id=".Input::get('township_id')));	
			}	

			$request_input=array($state_naem[0]->state_division,isset($township_name[0]->township_name)? $township_name[0]->township_name:'ALL',Input::get('academic_year'));

			Excel::create('PercentageGradeOne', function($excel) use($detail,$request_input){

	    	$excel->sheet('PercentageGradeOne', function($sheet) use($detail,$request_input){

    		//$sheet->fromArray($post[0]);
	    		$sheet->prependRow(array('Township Education Management Information System'))->mergeCells('A1:C1',function($cells){
	    				$cells->setFontWeight('bold');
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('center');
	    				 $cells->setValignment('middle');
	    			});
	    		$sheet->appendRow(array('Percentage of Grade One Intake with Preprimary/Preschool(ECCE) Experiences Report'))->mergeCells('A2:C2',function($cells){
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
	    		
	 			for($i = 0; $i < count($detail); $i++) {

					if($detail[$i]['location'] == "Rural") {
						$rural_level[] = $detail[$i]['school_level'];
					}

					if($detail[$i]['location'] == "Urban") {
						$urban_level[] = $detail[$i]['school_level'];
					}

				}

			
				if(isset($rural_level)) {
					$rural_levels = array_values(array_unique($rural_level));
				}
				
				if(isset($urban_level)) {
					$urban_levels = array_values(array_unique($urban_level));
				}

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

		$sheet->appendRow(array('School No','School Name','Percentage'));

	
		for($c = 0; $c < count($detail); $c++)
		{
				if($detail[$c]['location'] == "Rural" && $detail[$c]['school_level'] == $rural_levels[$k]) 
				{

						$count=$sheet->getHighestRow()+1;
						$sheet->cell('A'.$count,function($cell) use($detail,$c){
		    				$cell->setValue($detail[$c]['school_no']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
				    	$sheet->cell('B'.$count,function($cell) use($detail,$c){
		    				$cell->setValue($detail[$c]['school_name']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
				    	$sheet->cell('C'.$count,function($cell) use($detail,$c){
				    		$total=$detail[$c]['total_boy']+$detail[$c]['total_girl'];
							$total_ppeg=$detail[$c]['ppeg1_boy']+$detail[$c]['ppeg1_girl'];
							if($total_ppeg!=0)
							{
								$percent=($total_ppeg/$total) * 100;
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
			if($detail[$c]['location'] == "Urban" && $detail[$c]['school_level'] == $urban_levels[$l]) 
				{
						$count=$sheet->getHighestRow()+1;
						$sheet->cell('A'.$count,function($cell) use($detail,$c){
		    				$cell->setValue($detail[$c]['school_no']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
				    	$sheet->cell('B'.$count,function($cell) use($detail,$c){
		    				$cell->setValue($detail[$c]['school_name']);
				    		$cell->setFontSize(12);
				    		$cell->setAlignment('left');
				    		$cell->setValignment('middle');
				    	});
				    	$sheet->cell('C'.$count,function($cell) use($detail,$c){
				    		$total=$detail[$c]['total_boy']+$detail[$c]['total_girl'];
							$total_ppeg=$detail[$c]['ppeg1_boy']+$detail[$c]['ppeg1_girl'];
							if($total_ppeg!=0)
							{
								$percent=($total_ppeg/$total) * 100;
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
}
 