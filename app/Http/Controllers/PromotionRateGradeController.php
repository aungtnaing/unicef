<?php
namespace App\Http\Controllers;

use Input;
use Session;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Exception;

class PromotionRateGradeController extends Controller
{
	public function create()
	{
		return view('flow.promotion_rate_grade');
	}

	public function search()
	{
		
		try {

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
		
			$new_total=DB::select(DB::raw("SELECT SUM(new_boy)+SUM(new_girl) AS total_students,student_intake.grade FROM `student_intake` INNER JOIN v_school ON v_school.school_id=student_intake.school_id AND v_school.school_year = student_intake.school_year WHERE v_school.state_divsion_id ='".$state_id."'AND (v_school.township_id ='".$township_id."' OR ''='".$township_id."') AND student_intake.school_year='".$academic_year."' AND student_intake.grade<>'01' GROUP BY student_intake.grade ORDER BY student_intake.grade ASC"));

			$pre_total=DB::select(DB::raw("SELECT SUM(total_boy)+SUM(total_girl) AS total_students,student_intake.grade FROM `student_intake` INNER JOIN v_school ON v_school.school_id=student_intake.school_id AND v_school.school_year = student_intake.school_year WHERE v_school.state_divsion_id ='".$state_id."' AND  (v_school.township_id ='".$township_id."' OR ''='".$township_id."') AND student_intake.school_year='".$pre_year."' AND student_intake.grade<>'11' GROUP BY student_intake.grade ORDER BY student_intake.grade ASC"));


			if(count($new_total) && count($pre_total)) {
				
				return view('flow.promotion_rate_grade',compact('region','new_total','pre_total'));	
				
			} else {
				
				$error = "There is no data in this State or Townshiip.";
				return view('flow.promotion_rate_grade', compact('error'));
			
			}

			$err = "There is no data.";
			throw new Exception($err);

		} catch (Exception $e) {

			$error = "There is no data.";
			return view('flow.promotion_rate_grade', compact('error'));

		}
			
	}

	public function show()
	{
		
		$state_id = Input::get('state_id');
		$township_id = Input::get('township_id');
		$academic_year = Input::get('academic_year');
		$pre_year=Input::get('previous_year');	
		
		if(Input::get('township_id')) {

			$q = "SELECT state_division, township_name";
		
		} else {
		
			$q = "SELECT state_division";
		
		}

		$q .= " FROM v_state_township WHERE state_id = ".Input::get('state_id')." AND (township_id = '".Input::get('township_id')."' OR '' = '".Input::get('township_id')."') GROUP BY state_id";

		$region = DB::select(DB::raw($q));
		try{
			$new_total=DB::select(DB::raw("SELECT SUM(new_boy)+SUM(new_girl) AS total_students,student_intake.grade FROM `student_intake` INNER JOIN v_school ON v_school.school_id=student_intake.school_id AND v_school.school_year = student_intake.school_year WHERE v_school.state_divsion_id ='".$state_id."'AND (v_school.township_id ='".$township_id."' OR ''='".$township_id."') AND student_intake.school_year='".$academic_year."' AND student_intake.grade <>'01' GROUP BY student_intake.grade"));
			
			$pre_total=DB::select(DB::raw("SELECT SUM(total_boy)+SUM(total_girl) AS total_students,student_intake.grade FROM `student_intake` INNER JOIN v_school ON v_school.school_id=student_intake.school_id AND v_school.school_year = student_intake.school_year WHERE v_school.state_divsion_id ='".$state_id."' AND  (v_school.township_id ='".$township_id."' OR ''='".$township_id."') AND student_intake.school_year='".$pre_year."' AND student_intake.grade<>'11' GROUP BY student_intake.grade"));
		 	
			
			
			foreach ($new_total as $new) {
				$arr_new[]=get_object_vars($new);
			}

			foreach ($pre_total as $pre) {
				$arr_pre[]=get_object_vars($pre);
			}
			
			$state_name=DB::select(DB::raw("SELECT state_division FROM state_division WHERE id=".$state_id));

			if(isset($township_id)){
				$township_name=DB::select(DB::raw("SELECT township_name FROM township WHERE id=".$township_id));	
			}
			$request_input=array($state_name[0]->state_division,isset($township_name[0]->township_name)? $township_name[0]->township_name:'ALL',$academic_year);

			Excel::create('GradeOneToTenPro', function($excel) use($arr_new,$arr_pre,$request_input){

	    	$excel->sheet('GradeOneToTenPro', function($sheet) use($arr_new,$arr_pre,$request_input){

	    		//$sheet->fromArray($post[0]);
	    		$sheet->prependRow(array('Township Education Management Information System'))->mergeCells('A1:D1',function($cells){
	    				$cells->setFontWeight('bold');
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('center');
	    				 $cells->setValignment('middle');
	    			});
	    		$sheet->appendRow(array('Promotion Rate (Grade One to Ten'))->mergeCells('A2:D2',function($cells){
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
	    		
	    		
				$sheet->appendRow(array('Grade','Newly promoted students','Number of students from the same cohort','Promotion Rate'));

				for($i = 0; $i < count($arr_new); $i++)
				{
					$count=$sheet->getHighestRow()+1;
					$sheet->cell('A'.$count,function($cell) use($arr_new,$i){
		    			$cell->setValue($arr_new[$i]['grade']);
				    	$cell->setFontSize(12);
				    	$cell->setAlignment('left');
				    	$cell->setValignment('middle');
				    });
				    $sheet->cell('B'.$count,function($cell) use($arr_new,$i){
		    			$cell->setValue($arr_new[$i]['total_students']);
				    	$cell->setFontSize(12);
				    	$cell->setAlignment('left');
				    	$cell->setValignment('middle');
				    });
				    $sheet->cell('C'.$count,function($cell) use($arr_pre,$i){
		    			$cell->setValue($arr_pre[$i]['total_students']);
				    	$cell->setFontSize(12);
				    	$cell->setAlignment('left');
				    	$cell->setValignment('middle');
				    });
				    $sheet->cell('D'.$count,function($cell) use($arr_new,$arr_pre,$i){
		    			$cell->setValue(round(($arr_new[$i]['total_students']/$arr_pre[$i]['total_students'])*100, 2));
				    	$cell->setFontSize(12);
				    	$cell->setAlignment('left');
				    	$cell->setValignment('middle');
				    });
				}
			
			$sheet->setBorder('A1'.':D'.$sheet->getHighestRow(), 'thin');

	    	});

			 })->download('xlsx');
			$err = "There is no data.";
			throw new Exception($err);

		} catch (Exception $e) {

			$error = "There is no data.";
			return view('flow.promotion_rate_grade', compact('error'));

		}
	}
}
 