<?php
namespace App\Http\Controllers;

use Request;
use Session;
use Input;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SanitationStudentRatioController extends Controller

{
	public function create()
	{
		return view('students.sanitation');
	}

	public function search()
	{
		
		$state_id = Input::get('state_id');
		$township_id = Input::get('township_id');
		$academic_year = Input::get('academic_year');
			
		if($township_id) {

			$q = "SELECT *";
		
		} else {
		
			$q = "SELECT state_id,state_division";
		
		}

		$q .= " FROM v_state_township WHERE state_id = ".$state_id." AND (township_id = '".$township_id."' OR '' = '".$township_id."') GROUP BY state_id";

		$region = DB::select(DB::raw($q));

		try{

			$dtSchool=DB::select(DB::raw("SELECT  infra.latrine_totalboy,infra.latrine_totalgirl,infra.latrine_totalboth,infra.latrine_repair_boy,infra.latrine_repair_girl,infra.latrine_repair_both,infra.enough_whole_year,infra.enough_other_use,infra.main_water_safety AS safe_to_drink,infra.main_water_source AS quality,SUM(std_in.total_boy+std_in.total_girl) AS total_students,v_school.location,v_school.school_level,v_school.school_no,v_school.school_name,v_school.school_id FROM school_infrastructure AS infra INNER JOIN student_intake AS std_in ON std_in.school_id=infra.school_id AND infra.school_year=std_in.school_year INNER JOIN v_school ON v_school.school_id=infra.school_id AND v_school.school_year=infra.school_year WHERE v_school.state_divsion_id = '".$state_id."' AND (v_school.township_id ='".$township_id."' OR ''='".$township_id."') AND infra.school_year='".$academic_year."' GROUP BY v_school.school_id"));
			if(count($dtSchool))
			{
			return view('students.sanitation',compact('region','dtSchool','tStudents','tLatrine'));
			}
			else
			{
				$record="There is no record in this region or township.";
				return view('students.sanitation',compact('record'));
			}

			
		}
		catch(Exception $ex){
			$record="Please check for searching again.";
			return view('students.sanitation',compact('record'));
		}
		
		
	}

	public function export()
	{
		$state_id = Input::get('state_id');
		$township_id = Input::get('township_id');
		$academic_year = Input::get('academic_year');
			
		if($township_id) {

			$q = "SELECT *";
		
		} else {
		
			$q = "SELECT state_id,state_division";
		
		}

		$q .= " FROM v_state_township WHERE state_id = ".$state_id." AND (township_id = '".$township_id."' OR '' = '".$township_id."') GROUP BY state_id";

		$region = DB::select(DB::raw($q));

		try{

			$dtSchool=DB::select(DB::raw("SELECT  infra.latrine_totalboy,infra.latrine_totalgirl,infra.latrine_totalboth,infra.latrine_repair_boy,infra.latrine_repair_girl,infra.latrine_repair_both,infra.enough_whole_year,infra.enough_other_use,infra.main_water_safety AS safe_to_drink,infra.main_water_source AS quality,SUM(std_in.total_boy+std_in.total_girl) AS total_students,v_school.location,v_school.school_level,v_school.school_no,v_school.school_name,v_school.school_id FROM school_infrastructure AS infra INNER JOIN student_intake AS std_in ON std_in.school_id=infra.school_id AND infra.school_year=std_in.school_year INNER JOIN v_school ON v_school.school_id=infra.school_id AND v_school.school_year=infra.school_year WHERE v_school.state_divsion_id = '".$state_id."' AND (v_school.township_id ='".$township_id."' OR ''='".$township_id."') AND infra.school_year='".$academic_year."' GROUP BY v_school.school_id"));

				
			
			
			
			if(count($dtSchool)>0){
				foreach ($dtSchool as $tSchool) {
				$tSchools[]=get_object_vars($tSchool);
			}

			
			$state_name=DB::select(DB::raw("SELECT state_division FROM state_division WHERE id=".Input::get('state_id')));

			if(Input::get('township_id')){
				$township_name=DB::select(DB::raw("SELECT township_name FROM township WHERE id=".Input::get('township_id')));	
			}
			$request_input=array($state_name[0]->state_division,isset($township_name[0]->township_name)? $township_name[0]->township_name:'ALL',Input::get('academic_year'));

			Excel::create('Student Sanitation', function($excel) use($tSchools,$request_input){

	    	$excel->sheet('Student Sanitation', function($sheet) use($tSchools,$request_input){


	    			    		//$sheet->fromArray($post[0]);
	    		$sheet->prependRow(array('Township Education Management Information System'))->mergeCells('A1:K1',function($cells){
	    				$cells->setFontWeight('bold');
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('center');
	    				 $cells->setValignment('middle');
	    			});
	    		$sheet->appendRow(array('Student Sanitation'))->mergeCells('A2:K2',function($cells){
	    				$cells->setFontWeight('bold');
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('center');
	    				 $cells->setValignment('middle');
	    			});
	    		$sheet->appendRow(array('Division : '.$request_input[0]))->mergeCells('A3:K3',function($cells){
	    			$cells->setFontWeight('bold');
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('left');
	    				 $cells->setValignment('middle');
	    		});
	    		$sheet->appendRow(array('Township : '.$request_input[1]))->mergeCells('A4:K4',function($cell){
	    			$cell->setFontWeight('bold');
	    				$cell->setFontSize(11);
	    				$cell->setAlignment('right');
	    				 $cell->setValignment('middle');
	    		});
	    		$sheet->appendRow(array('Academic Year :'.$request_input[2]))->mergeCells('A5:K5',function($cell){
	    			$cell->setFontWeight('bold');
	    			$cell->setFontSize(18);
	    			$cell->setAlignment('left');
	    			$cell->setValignment('middle');
	    		});
	    		
	    		
			if (isset($tSchools) && count($tSchools)>0) {
			for($i = 0; $i < count($tSchools); $i++) {

			if($tSchools[$i]['location'] == "Rural") {
				$rural_level[] = $tSchools[$i]['school_level'];
			}

			if($tSchools[$i]['location'] == "Urban") {
				$urban_level[] = $tSchools[$i]['school_level'];
			}

		}

		$rural_levels = array_values(array_unique($rural_level));
		$urban_levels = array_values(array_unique($urban_level));

///	Stat Rural
		$count=$sheet->getHighestRow()+1;
		$sheet->mergeCells('A'.$count.':E'.$count,function($cell){
			$cell->setValue('aaa');
			$cell->setFontSize(12);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});	
		/*$sheet->mergeCells('F'.$count.':H'.$count,function($cell){
			$cell->setValue('Sanitation');
			$cell->setFontSize(12);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});
		$sheet->mergeCells('I'.$count.':K'.$count,function($cell){
			$cell->setValue('Water');
			$cell->setFontSize(12);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});	*/	
		$count=$sheet->getHighestRow()+1;
		$sheet->appendRow(array('Location : Rural'))->mergeCells('A'.$count.':K'.$count,function($cell){
			$cell->setFontWeight('bold');
			$cell->setFontSize(18);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});
				
	
	for($k = 0; $k < count($rural_levels); $k++) { 
		$count=$sheet->getHighestRow()+1;
				$sheet->appendRow(array('School Level :'.$rural_levels[$k]))->mergeCells('A'.$count.':K'.$count,function($cell){
				$cell->setFontWeight('bold');
	    		$cell->setFontSize(18);
	    		$cell->setAlignment('left');
	    		$cell->setValignment('middle');
			});
			///to find merge cells	
				$count=$sheet->getHighestRow()+1;
		$sheet->mergeCells('A'.$count.':E'.$count,function($cell){
			$cell->setValue('');
			$cell->setFontSize(12);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});	
		$sheet->mergeCells('F'.$count.':H'.$count,function($cell){
			$cell->setValue('Sanitation');
			$cell->setFontSize(12);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});
		$sheet->mergeCells('I'.$count.':K'.$count,function($cell){
			$cell->setValue('Water');
			$cell->setFontSize(12);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});	
				
			$sheet->appendRow(array('School No','School Name','Total Latrines','Total Good Latrines','Total Students','Ratio Total Latrine','Ratio Total Good Latrine','Rank','Availability','Quality','Sate To Drink'));
		for($row=0;$row<count($tSchools);$row++){
		 if($tSchools[$row]['location'] == "Rural" && $tSchools[$row]['school_level'] == $rural_levels[$k]) { 
				//if ($row<count($school_stds) && $row<count($school_latrine)) {
					$total_latrine=$tSchools[$row]['latrine_totalboy']+$tSchools[$row]['latrine_totalgirl']+$tSchools[$row]['latrine_totalboth'];

				$total_good_latrine=$total_latrine-$tSchools[$row]['latrine_repair_boy']+$tSchools[$row]['latrine_repair_girl']+$tSchools[$row]['latrine_repair_both'];

				$count=$sheet->getHighestRow()+1;
					$sheet->cell('A'.$count,function($cell) use($tSchools,$row){
	    				$cell->setValue($tSchools[$row]['school_no']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
					$sheet->cell('B'.$count,function($cell) use($tSchools,$row){
	    				$cell->setValue($tSchools[$row]['school_name']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});	
			    	$sheet->cell('C'.$count,function($cell) use($total_latrine){
	    				$cell->setValue($total_latrine);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('D'.$count,function($cell) use($total_good_latrine){
	    				$cell->setValue($total_good_latrine);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('E'.$count,function($cell) use($tSchools,$row){
	    				$cell->setValue($tSchools[$row]['total_students']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('F'.$count,function($cell) use($total_latrine,$tSchools,$row){
	    				$cell->setValue(($total_latrine!=0 )? round($tSchools[$row]['total_students'] / $total_latrine,2) :'0');
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('G'.$count,function($cell) use($total_good_latrine,$tSchools,$row){
	    				$cell->setValue(($total_good_latrine)? round($tSchools[$row]['total_students'] / $total_good_latrine,2) : '0');
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});

			    	$sheet->cell('H'.$count,function($cell) use($tSchools,$row,$total_latrine,$total_good_latrine){
			    		$LatrineRatio=($total_latrine!=0 )? round($tSchools[$row]['total_students'] / $total_latrine,2) :'0';
						$GLatrineRatio=($total_good_latrine)? round($tSchools[$row]['total_students'] / $total_good_latrine,2) : '0';
					
					 if ($LatrineRatio <= 50 && $GLatrineRatio <= 50)
					 {
					 	$rank= "A";
					 }                        
                     else if ($LatrineRatio <= 50 || $GLatrineRatio <= 50)
                     {
                     	$rank="B";
                     }	
                     else
                     {
                     	$rank="C";
                     }
	    				$cell->setValue($rank);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('I'.$count,function($cell) use($tSchools,$row){
			    		if ($tSchools[$row]['enough_whole_year'] + $tSchools[$row]['enough_other_use'] ==2) 
						{
							$Availability= "A";
						}
						elseif ($tSchools[$row]['enough_whole_year']+$tSchools[$row]['enough_other_use']==1) 
						{
							$Availability= "B";
						}
						else
						{
							$Availability= "C";
						}			    		
	    				$cell->setValue($Availability);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('J'.$count,function($cell) use($tSchools,$row){
			    	if ($tSchools[$row]['quality']=="Tube Well" || $tSchools[$row]['quality']=="Piped") {
						$quality= "A";
					}
					elseif ($tSchools[$row]['quality']=="Well" || $tSchools[$row]['quality']=="Hand Pump") {
						$quality= "B";
					}
					elseif ($tSchools[$row]['quality']=="Rain") {
						$quality= "C";
					}
					elseif ($tSchools[$row]['quality']=="Pond" || $tSchools[$row]['quality']=="River") {
						$quality= "D";
					}
					elseif ($tSchools[$row]['quality']=="Bottled/ Tank water") {
						$quality= "E";
					}
					elseif ($tSchools[$row]['quality']=="No") {
						$quality= "F";
					}
	    				$cell->setValue(isset($quality)? $quality:'-');
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('K'.$count,function($cell) use($tSchools,$row){
			    		if ($tSchools[$row]['safe_to_drink']=='1') 
						{
							$safe_to_drink= "Yes";
						}
						else
						{
							$safe_to_drink= "No";
						}
	    				$cell->setValue($safe_to_drink);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});

				//}
			}	
		}
	}
/// Stat Urban 
	$count=$sheet->getHighestRow()+1;
		$sheet->appendRow(array('Location : Urban'))->mergeCells('A'.$count.':K'.$count,function($cell){
			$cell->setFontWeight('bold');
			$cell->setFontSize(18);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});	
	
	for($l = 0; $l < count($urban_levels); $l++) { 
		$count=$sheet->getHighestRow()+1;
				$sheet->appendRow(array('School Level :'.$urban_levels[$l]))->mergeCells('A'.$count.':K'.$count,function($cell){
				$cell->setFontWeight('bold');
	    		$cell->setFontSize(18);
	    		$cell->setAlignment('left');
	    		$cell->setValignment('middle');
			});
				$count=$sheet->getHighestRow()+1;
		$sheet->mergeCells('A'.$count.':E'.$count,function($cell){
			$cell->setValue('');
			$cell->setFontSize(12);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});	
		$sheet->mergeCells('F'.$count.':H'.$count,function($cell){
			$cell->setValue('Sanitation');
			$cell->setFontSize(12);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});
		$sheet->mergeCells('I'.$count.':K'.$count,function($cell){
			$cell->setValue('Water');
			$cell->setFontSize(12);
			$cell->setAlignment('left');
			$cell->setValignment('middle');
		});	
			$sheet->appendRow(array('School No','School Name','Total Latrines','Total Good Latrines','Total Students','Ratio Total Latrine','Ratio Total Good Latrine','Rank','Availability','Quality','Sate To Drink'));
		for($r=0;$r<count($tSchools);$r++){
		 if($tSchools[$r]['location'] == "Urban" && $tSchools[$r]['school_level'] == $urban_levels[$l]) { 
				//if ($r<count($school_stds) && $r<count($school_latrine)) {
					$total_latrine=$tSchools[$r]['latrine_totalboy']+$tSchools[$r]['latrine_totalgirl']+$tSchools[$r]['latrine_totalboth'];

				$total_good_latrine=$total_latrine-$tSchools[$r]['latrine_repair_boy']+$tSchools[$r]['latrine_repair_girl']+$tSchools[$r]['latrine_repair_both'];

				$count=$sheet->getHighestRow()+1;
					$sheet->cell('A'.$count,function($cell) use($tSchools,$r){
	    				$cell->setValue($tSchools[$r]['school_no']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
					$sheet->cell('B'.$count,function($cell) use($tSchools,$r){
	    				$cell->setValue($tSchools[$r]['school_name']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});	
			    	$sheet->cell('C'.$count,function($cell) use($total_latrine){
	    				$cell->setValue($total_latrine);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('D'.$count,function($cell) use($total_good_latrine){
	    				$cell->setValue($total_good_latrine);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('E'.$count,function($cell) use($tSchools,$r){
	    				$cell->setValue($tSchools[$r]['total_students']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('F'.$count,function($cell) use($total_latrine,$tSchools,$r){
	    				$cell->setValue(($total_latrine!=0 )? round($tSchools[$r]['total_students'] / $total_latrine,2) :'0');
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('G'.$count,function($cell) use($total_good_latrine,$tSchools,$r){
	    				$cell->setValue(($total_good_latrine)? round($tSchools[$r]['total_students'] / $total_good_latrine,2) : '0');
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('H'.$count,function($cell)use($tSchools,$r,$total_latrine,$total_good_latrine){
			    		$LatrineRatio=($total_latrine!=0 )? round($tSchools[$r]['total_students'] / $total_latrine,2) :'0';
						$GLatrineRatio=($total_good_latrine)? round($tSchools[$r]['total_students'] / $total_good_latrine,2) : '0';
					
					 if ($LatrineRatio <= 50 && $GLatrineRatio <= 50)
					 {
					 	$rank= "A";
					 }                        
                     else if ($LatrineRatio <= 50 || $GLatrineRatio <= 50)
                     {
                     	$rank="B";
                     }	
                     else
                     {
                     	$rank="C";
                     }
	    				$cell->setValue($rank);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('I'.$count,function($cell) use($tSchools,$r){
			    		if ($tSchools[$r]['enough_whole_year'] + $tSchools[$r]['enough_other_use'] ==2) 
						{
							$Availability= "A";
						}
						elseif ($tSchools[$r]['enough_whole_year']+$tSchools[$r]['enough_other_use']==1) 
						{
							$Availability= "B";
						}
						else
						{
							$Availability= "C";
						}			    		
	    				$cell->setValue($Availability);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('J'.$count,function($cell) use($tSchools,$r){
	    				if ($tSchools[$r]['quality']=="Tube Well" || $tSchools[$r]['quality']=="Piped") {
						$Availability= "A";
					}
					elseif ($tSchools[$r]['quality']=="Well" || $tSchools[$r]['quality']=="Hand Pump") {
						$Availability= "B";
					}
					elseif ($tSchools[$r]['quality']=="Rain") {
						$Availability= "C";
					}
					elseif ($tSchools[$r]['quality']=="Pond" || $tSchools[$r]['quality']=="River") {
						$Availability= "D";
					}
					elseif ($tSchools[$r]['quality']=="Bottled/ Tank water") {
						$Availability= "E";
					}
					elseif ($tSchools[$r]['quality']=="No") {
						$Availability= "F";
					}
	    				$cell->setValue(isset($Availability)? $Availability:'-');
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('K'.$count,function($cell) use($tSchools,$r){
			    		if ($tSchools[$r]['safe_to_drink']=='1') 
						{
							$safe_to_drink= "Yes";
						}
						else
						{
							$safe_to_drink= "No";
						}
	    				$cell->setValue($safe_to_drink);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});

				//}
			}	
		}
	}
}
	
	$sheet->setBorder('A1'.':K'.$sheet->getHighestRow(), 'thin');



	    	});

			 })->download('xlsx');
			}
			else
			{
				$record="There is no record in this region or township.";
				return view('students.sanitation',compact('record'));
			}
			
		}
		catch(Exception $ex){
			$record="Please check for searching again.";
			return view('students.sanitation',compact('region','record'));
		}
	}
		
}
