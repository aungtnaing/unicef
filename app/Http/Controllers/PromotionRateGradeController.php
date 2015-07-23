<?php
namespace App\Http\Controllers;

use Input;
use Session;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PromotionRateGradeController extends Controller
{
	public function create()
	{
		return view('flow.promotion_rate_grade');
	}

	public function search()
	{
		
		$state_id = Input::get('state_id');
		$township_id = Input::get('township_id');
		$academic_year = Input::get('academic_year');
		$pre_year= Input::get('previous_year');	
		
		if(isset($township_id)) {

			$q = "SELECT *";
		
		} else {
		
			$q = "SELECT state_id,state_division";
		
		}

		$q .= " FROM v_state_township WHERE state_id = ".$state_id." AND (township_id = '".$township_id."' OR '' = '".$township_id."') GROUP BY state_id";
		$region = DB::select(DB::raw($q));
		try{
			$new_total=DB::select(DB::raw("SELECT SUM(new_boy)+SUM(new_girl) AS total_students,student_intake.grade FROM `student_intake` INNER JOIN v_school ON v_school.school_id=student_intake.school_id AND v_school.school_year = student_intake.school_year WHERE v_school.state_divsion_id ='".$state_id."'AND (v_school.township_id ='".$township_id."' OR ''='".$township_id."') AND student_intake.school_year='".$academic_year."' AND student_intake.grade!='01' GROUP BY student_intake.grade"));

			$pre_total=DB::select(DB::raw("SELECT SUM(total_boy)+SUM(total_girl) AS total_students,student_intake.grade FROM `student_intake` INNER JOIN v_school ON v_school.school_id=student_intake.school_id AND v_school.school_year = student_intake.school_year WHERE v_school.state_divsion_id ='".$state_id."' AND  (v_school.township_id ='".$township_id."' OR ''='".$township_id."') AND student_intake.school_year='".$pre_year."' AND student_intake.grade!='11' GROUP BY student_intake.grade"));

			return view('flow.promotion_rate_grade',compact('region','new_total','pre_total'));		
		}
		catch(Exception $ex)
		{
			$record="<h4>There is no Data Records.Please Check in Searching.</h4>";
			return view('flow.promotion_rate_grade',compact('region','record'));
		}
			
	}

	public function show()
	{
		
		$state_id = Input::get('state_id');
		$township_id = Input::get('township_id');
		$academic_year = Input::get('academic_year');
		$pre_year=Session::get('previous_year');	
		
		if(Input::get('township_id')) {

			$q = "SELECT state_division, township_name";
		
		} else {
		
			$q = "SELECT state_division";
		
		}

		$q .= " FROM v_state_township WHERE state_id = ".Input::get('state_id')." AND (township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') GROUP BY state_id";

		$region = DB::select(DB::raw($q));
		try{
			$new_total=DB::select(DB::raw("SELECT SUM(new_boy)+SUM(new_girl) AS total_students,student_intake.grade,v_school.location FROM `student_intake` INNER JOIN v_school ON v_school.school_id=student_intake.school_id WHERE (v_school.state_divsion_id ='".$state_id."' OR ''='".$state_id."') AND (v_school.township_id ='".$township_id."' OR ''='".$township_id."') AND (student_intake.school_year='".$academic_year."' OR ''='".$academic_year."') AND student_intake.grade!='01' GROUP BY student_intake.grade,v_school.location"));

			$pre_total=DB::select(DB::raw("SELECT SUM(new_boy)+SUM(new_girl) AS total_students,student_intake.grade,v_school.location FROM `student_intake` INNER JOIN v_school ON v_school.school_id=student_intake.school_id WHERE (v_school.state_divsion_id ='".$state_id."' OR ''='".$state_id."') AND  (v_school.township_id ='".$township_id."' OR ''='".$township_id."') AND (student_intake.school_year='".$pre_year."' OR ''='".$pre_year."') AND student_intake.grade!='11' GROUP BY student_intake.grade,v_school.location"));		
		 
			for($i = 0; $i < count($new_total); $i++) {

				if($new_total[$i]->location == "Rural" && $pre_total[$i]->location=="Rural") {
					$grade_rural[]=$new_total[$i]->grade;
					$percent_rural[]=($new_total[$i]->total_students/$pre_total[$i]->total_students)*100;
					
				}

				if($new_total[$i]->location == "Urban" && $pre_total[$i]->location=="Urban") {
					$grade_urban[]=$new_total[$i]->grade;
					$percent_urban[]=($new_total[$i]->total_students/$pre_total[$i]->total_students)*100;
				}
			}
			if(count($new_total)>0 && count($pre_total)>0){
			
			
			$state_name=DB::select(DB::raw("SELECT state_division FROM state_division WHERE id=".$state_id));

			if(isset($township_id)){
				$township_name=DB::select(DB::raw("SELECT township_name FROM township WHERE id=".$township_id));	
			}
			$request_input=array($state_name[0]->state_division,isset($township_name[0]->township_name)? $township_name[0]->township_name:'ALL',$academic_year);

			Excel::create('GradeOneToTenPro', function($excel) use($grade_rural,$percent_rural,$grade_urban,$percent_urban,$request_input){

	    	$excel->sheet('GradeOneToTenPro', function($sheet) use($grade_rural,$percent_rural,$grade_urban,$percent_urban,$request_input){

	    		//$sheet->fromArray($post[0]);
	    		$sheet->prependRow(array('Township Education Management Information System'))->mergeCells('A1:B1',function($cells){
	    				$cells->setFontWeight('bold');
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('center');
	    				 $cells->setValignment('middle');
	    			});
	    		$sheet->appendRow(array('Promotion Rate (Grade One to Ten'))->mergeCells('A2:B2',function($cells){
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
	    		
	    		$count=$sheet->getHighestRow()+1;
				$sheet->appendRow(array('Location : Rural'))->mergeCells('A'.$count.':B'.$count,function($cell){
					$cell->setFontWeight('bold');
		    		$cell->setFontSize(18);
		    		$cell->setAlignment('left');
		    		$cell->setValignment('middle');
				});
				$sheet->appendRow(array('Grade','Promotion Rate for Grade 2 to Grade 10'));

				for($k = 0; $k < count($grade_rural); $k++)	{
					$count=$sheet->getHighestRow()+1;
					$sheet->cell('A'.$count,function($cell) use($grade_rural,$k){
		    			$cell->setValue($grade_rural[$k]);
				    	$cell->setFontSize(12);
				    	$cell->setAlignment('left');
				    	$cell->setValignment('middle');
				    });
				    $sheet->cell('B'.$count,function($cell) use($percent_rural,$k){
		    			$cell->setValue($percent_rural[$k]);
				    	$cell->setFontSize(12);
				    	$cell->setAlignment('left');
				    	$cell->setValignment('middle');
				    });
				}	
		
				$count=$sheet->getHighestRow()+1;
				$sheet->appendRow(array('Location : Urban'))->mergeCells('A'.$count.':B'.$count,function($cell){
					$cell->setFontWeight('bold');
		    		$cell->setFontSize(18);
		    		$cell->setAlignment('left');
		    		$cell->setValignment('middle');
				});
				$sheet->appendRow(array('Grade','Promotion Rate for Grade 2 to Grade 10'));

				for($k = 0; $k < count($grade_urban); $k++)	{
					$count=$sheet->getHighestRow()+1;
					$sheet->cell('A'.$count,function($cell) use($grade_urban,$k){
		    			$cell->setValue($grade_urban[$k]);
				    	$cell->setFontSize(12);
				    	$cell->setAlignment('left');
				    	$cell->setValignment('middle');
				    });
				    $sheet->cell('B'.$count,function($cell) use($percent_urban,$k){
		    			$cell->setValue($percent_urban[$k]);
				    	$cell->setFontSize(12);
				    	$cell->setAlignment('left');
				    	$cell->setValignment('middle');
				    });
				}
			$sheet->setBorder('A1'.':B'.$sheet->getHighestRow(), 'thin');

	    	});

			 })->download('xlsx');
			}
		}
		catch(Exception $ex)
		{
			$record="<h4>There is no Data Records.Please Check in Searching.</h4>";
			return view('flow.promotion_rate_grade',compact('region','record'));
		}
	}
}
 