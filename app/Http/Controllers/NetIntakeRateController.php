<?php

namespace App\Http\Controllers;

use Input;
use Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Exception;
use Illuminate\Support\Facades\DB;

class NetIntakeRateController extends Controller
{
	public function create()
	{
		return view('gross.net_intake_rate');
	}

	public function search()
	{

		try
		{
			$state=Request::input('state_id');
			$town=Request::input('township_id');
			$year=Request::input('academic_year');

			if(Request::input('township_id')) {

				$q = "SELECT state_division, township_name";
			
			} else {
			
				$q = "SELECT state_division";
			
			}

			$q .= " FROM v_state_township WHERE state_id = ".Request::input('state_id')." AND (township_id = '".Request::input('township_id')."' OR '' = '".Request::input('township_id')."') GROUP BY state_id";

			$region = DB::select(DB::raw($q));

			
			$total_intake_one=DB::select(DB::raw("SELECT SUM(detail.boy_5years+detail.girl_5years) AS total_grade_one,v_school.sort_code,v_school.school_level FROM `student_enrollment_detail` AS detail INNER JOIN student_enrollment AS enrollment ON enrollment.id=detail.student_enrollment_id INNER JOIN v_school ON v_school.school_id=enrollment.school_id AND v_school.school_year=enrollment.school_year  WHERE detail.grade='01' AND (enrollment.school_year ='".$year."') AND (v_school.state_divsion_id ='".$state."') AND  (v_school.township_id ='".$town."' OR ''='".$town."') GROUP BY v_school.school_level  order by v_school.sort_code ASC"));
				
			$total_populations_5=DB::select(DB::raw("SELECT SUM(age5boy+age5girl) AS total_pop FROM population WHERE (townshipid ='".$town."' OR ''='".$town."') AND (academic_year='".$year."')"));
			
			if(count($total_intake_one) && count($total_populations_5)) {
				
				return view('gross.net_intake_rate',compact('region','total_intake_one','total_populations_5'));
				
			} else {
				
				$error = "There is no data in this State or Townshiip.";
				return view('gross.net_intake_rate', compact('error'));
			
			}

			$err = "There is no data.";
			throw new Exception($err);

		} catch (Exception $e) {

			$error = "There is no data.";
			return view('gross.net_intake_rate', compact('error'));

		}	
		
	}

	public function export()
	{

		try
		{
			$state=Request::input('state_id');
			$town=Request::input('township_id');
			$year=Request::input('academic_year');

			if(Request::input('township_id')) {

				$q = "SELECT state_division, township_name";
			
			} else {
			
				$q = "SELECT state_division";
			
			}

			$q .= " FROM v_state_township WHERE state_id = ".Request::input('state_id')." AND (township_id = '".Request::input('township_id')."' OR '' = '".Request::input('township_id')."') GROUP BY state_id";

			$region = DB::select(DB::raw($q));

			
			$total_intake_one=DB::select(DB::raw("SELECT SUM(detail.boy_5years+detail.girl_5years) AS total_grade_one,v_school.sort_code,v_school.school_level FROM `student_enrollment_detail` AS detail INNER JOIN student_enrollment AS enrollment ON enrollment.id=detail.student_enrollment_id INNER JOIN v_school ON v_school.school_id=enrollment.school_id AND v_school.school_year=enrollment.school_year  WHERE detail.grade='01' AND (enrollment.school_year ='".$year."') AND (v_school.state_divsion_id ='".$state."') AND  (v_school.township_id ='".$town."' OR ''='".$town."') GROUP BY v_school.school_level  order by v_school.sort_code ASC"));
				
			$total_populations_5=DB::select(DB::raw("SELECT SUM(age5boy+age5girl) AS total_pop FROM population WHERE (townshipid ='".$town."' OR ''='".$town."') AND (academic_year='".$year."' OR ''='".$year."')"));
			
			foreach ($total_intake_one as $intake_one) {
				$one[]=get_object_vars($intake_one);
			}
			foreach ($total_populations_5 as $pop_5) {
				$pop[]=get_object_vars($pop_5);
			}
			
			
			$state_name=DB::select(DB::raw("SELECT state_division FROM state_division WHERE id=".Input::get('state_id')));

			if(Input::get('township_id')){
				$township_name=DB::select(DB::raw("SELECT township_name FROM township WHERE id=".Input::get('township_id')));	
			}
			$request_input=array($state_name[0]->state_division,isset($township_name[0]->township_name)? $township_name[0]->township_name:'ALL',Input::get('academic_year'));

			Excel::create('Net Intake Rate(NIR)', function($excel) use($one,$pop,$request_input){

	    	$excel->sheet('Net Intake Rate(NIR)', function($sheet) use($one,$pop,$request_input){

	    		//$sheet->fromArray($post[0]);
	    		$sheet->prependRow(array('Township Education Management Information System'))->mergeCells('A1:B1',function($cells){
	    				$cells->setFontWeight('bold');
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('center');
	    				 $cells->setValignment('middle');
	    			});
	    		$sheet->appendRow(array('Net Intake Rate (NIR)'))->mergeCells('A2:B2',function($cells){
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
	    		
	    		
				$sheet->appendRow(array('School Levels','Ratio'));

				for($i=0;$i<count($one);$i++)	{
					
						
					$count=$sheet->getHighestRow()+1;
					$sheet->cell('A'.$count,function($cell) use($one,$i){
				    	$cell->setValue($one[$i]['school_level']);
					   	$cell->setFontSize(12);
					   	$cell->setAlignment('left');
					   	$cell->setValignment('middle');
					   });
					if($one[$i]['total_grade_one']!=0 && $one[$i]['total_grade_one']!='' && $pop[0]['total_pop']!=0)
					{
						$pop_ratio= ($one[$i]['total_grade_one']/$pop[0]['total_pop'])*100;
					}
					else if($one[$i]['total_grade_one']==0 && $one[$i]['total_grade_one']=='' && $pop[0]['total_pop']==0)
					{
						$pop_ratio= "There is no records for grade one records and population aged 5!";
					}
					else if($one[$i]['total_grade_one']!=0 && $one[$i]['total_grade_one']!='')
					{
						$pop_ratio= "There is no records for stuent total grade one record in this school level";
					}
					else
					{
						$pop_ratio= "There is no records for population at aged 5.";
					}
					$sheet->cell('B'.$count,function($cell) use($pop_ratio){
					$cell->setValue(round($pop_ratio,2));
					$cell->setFontSize(12);
				   	$cell->setAlignment('left');
				  	$cell->setValignment('middle');
				    });
				}	
		
									
			$sheet->setBorder('A1'.':B'.$sheet->getHighestRow(), 'thin');

	    	});

			 })->download('xlsx');
						
			$err = "There is no data.";
			throw new Exception($err);

		} catch (Exception $e) {

			$error = "There is no data.";
			return view('gross.net_intake_rate', compact('error'));

		}
	}

}
 