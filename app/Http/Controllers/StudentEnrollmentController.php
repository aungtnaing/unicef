<?php
namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Input;
use Session;
use Redirect;
use Exception;
use Illuminate\Support\Facades\DB;

class StudentEnrollmentController extends Controller
{
	public function create()
	{
		
		return view('students.enrollment');
		
	}

	public function search()
	{
		try
		{
		
		$state_id = Input::get('state_id');
		$township_id = Input::get('township_id');
		$academic_year = Input::get('academic_year');
			
		if(isset($township_id)) {

			$q = "SELECT *";
		
		} else {
		
			$q = "SELECT state_id,state_division";
		
		}

		$q .= " FROM v_state_township WHERE state_id = ".$state_id." AND (township_id = '".$township_id."' OR '' = '".$township_id."') GROUP BY state_id";

		$region = DB::select(DB::raw($q));

		$dtSchool=DB::select("SELECT SUM(student_intake.total_boy)+SUM(student_intake.total_girl) AS total_students,student_intake.grade,v_school.school_no,v_school.school_name,v_school.location,v_school.school_level FROM v_school LEFT JOIN student_intake ON v_school.school_id=student_intake.school_id and v_school.school_year=student_intake.school_year WHERE (v_school.state_divsion_id = '".$state_id."' OR ''='".$state_id."') AND (v_school.township_id ='".$township_id."' OR ''='".$township_id."') AND (student_intake.school_year='".$academic_year."' OR ''='".$academic_year."') GROUP BY v_school.school_no,student_intake.grade ");

		
			if(count($dtSchool)) {
				
				return view('students.enrollment',compact('region','dtSchool'));
				
			} else {
				
				$error = "There is no data in this State or Townshiip.";
				return view('students.enrollment', compact('error'));
			
			}

			$err = "There is no data.";
			throw new Exception($err);
			
		} catch (Exception $e) {

			$error = "There is no data.";
			return view('students.enrollment', compact('error'));

		}
	}

	public function export()
	{
		try
		{
			$state_id = Input::get('state_id');
		$township_id = Input::get('township_id');
		$academic_year = Input::get('academic_year');
			
		if(isset($township_id)) {

			$q = "SELECT *";
		
		} else {
		
			$q = "SELECT state_id,state_division";
		
		}

		$q .= " FROM v_state_township WHERE state_id = ".$state_id." AND (township_id = '".$township_id."' OR '' = '".$township_id."') GROUP BY state_id";

		$region = DB::select(DB::raw($q));

		$dtSchool=DB::select("SELECT SUM(student_intake.total_boy)+SUM(student_intake.total_girl) AS total_students,student_intake.grade,v_school.school_no,v_school.school_name,v_school.location,v_school.school_level FROM v_school LEFT JOIN student_intake ON v_school.school_id=student_intake.school_id and v_school.school_year=student_intake.school_year WHERE (v_school.state_divsion_id = '".$state_id."' OR ''='".$state_id."') AND (v_school.township_id ='".$township_id."' OR ''='".$township_id."') AND (student_intake.school_year='".$academic_year."' OR ''='".$academic_year."') GROUP BY v_school.school_no,student_intake.grade");

		for($a=0;$a<count($dtSchool);$a++)
		{
			$g1=0;$tg5=0;$tg9=0;$tg11=0;
			$school_no=$dtSchool[$a]->school_no;
			$school_name=$dtSchool[$a]->school_name;
			$school_location=$dtSchool[$a]->location;
			$school_level=$dtSchool[$a]->school_level;

			if($dtSchool[$a]->grade=='01')
			{
				$g1=$dtSchool[$a]->total_students;
			}
			$g1="";$g2="";$g3="";$g4="";$g5="";
					if($dtSchool[$a]->grade=='01') {
						$g1=$dtSchool[$a]->total_students;
						if ($a!=count($dtSchool)-1 && $dtSchool[$a+1]->school_no==$dtSchool[$a]->school_no) {
							$a+=1;
						}
					}
					if($dtSchool[$a]->grade=='02') {
						$g2=$dtSchool[$a]->total_students;
						if ($a!=count($dtSchool)-1 && $dtSchool[$a+1]->school_no==$dtSchool[$a]->school_no) {
							$a+=1;
						}
					}
					if($dtSchool[$a]->grade=='03') {
						$g3=$dtSchool[$a]->total_students;
						if ($a!=count($dtSchool)-1 && $dtSchool[$a+1]->school_no==$dtSchool[$a]->school_no) {
							$a+=1;
						}
					}
					if($dtSchool[$a]->grade=='04') {
						$g4=$dtSchool[$a]->total_students;
						if ($a!=count($dtSchool)-1 && $dtSchool[$a+1]->school_no==$dtSchool[$a]->school_no) {
							$a+=1;
						}
					}
					if ($dtSchool[$a]->grade=='05') {
						$g5=$dtSchool[$a]->total_students;
						if ($a!=count($dtSchool)-1 && $dtSchool[$a+1]->school_no==$dtSchool[$a]->school_no) {
							$a+=1;

						}

					}
					
					$total5=$g1+$g2+$g3+$g4+$g5;
					$g6="";$g7="";$g8="";$g9="";
					if($dtSchool[$a]->grade=='06') {
						$g6=$dtSchool[$a]->total_students;
						if ($a!=count($dtSchool)-1 && $dtSchool[$a+1]->school_no==$dtSchool[$a]->school_no) {
							$a+=1;
						}
					}
					if($dtSchool[$a]->grade=='07') {
						$g7=$dtSchool[$a]->total_students;
						if ($a!=count($dtSchool)-1 && $dtSchool[$a+1]->school_no==$dtSchool[$a]->school_no) {
							$a+=1;
						}
					}
					if($dtSchool[$a]->grade=='08') {
						$g8=$dtSchool[$a]->total_students;
						if ($a!=count($dtSchool)-1 && $dtSchool[$a+1]->school_no==$dtSchool[$a]->school_no) {
							$a+=1;
						}
					}
					if($dtSchool[$a]->grade=='09') {
						$g9=$dtSchool[$a]->total_students;
						if ($a!=count($dtSchool)-1 && $dtSchool[$a+1]->school_no==$dtSchool[$a]->school_no) {
							$a+=1;
						}
					}
					
					$total9=$g6+$g7+$g8+$g9;

					$g10="";$g11="";
					if($dtSchool[$a]->grade=='10') {
						$g10=$dtSchool[$a]->total_students;
						if ($a!=count($dtSchool)-1 && $dtSchool[$a+1]->school_no==$dtSchool[$a]->school_no) {
							$a+=1;
						}
					}
					if($dtSchool[$a]->grade=='11') {
						$g11=$dtSchool[$a]->total_students;
						if ($a!=count($dtSchool)-1 && $dtSchool[$a+1]->school_no==$dtSchool[$a]->school_no) {
							$a+=1;
						}
					}
									
					$total11=$g10+$g11;

					$Arr_school[]=array(
							'school_no'=>$school_no,
							'school_name'=>$school_name,
							'school_level'=>$school_level,
							'location'=>$school_location,
							'g1'=>$g1,
							'total5' => $total5,
							'total9' => $total9,
							'total11' =>$total11
						);	
						// $school_no,$school_name,$school_level,$school_location,$g1,$total5,$total9,$total9);
		}
		//print_r($Arr_school);
		
		$state_name=DB::select(DB::raw("SELECT state_division FROM state_division WHERE id=".Input::get('state_id')));

		if($township_id){
			$township_name=DB::select(DB::raw("SELECT township_name FROM township WHERE id=".Input::get('township_id')));
		}

		$request_input=array($state_name[0]->state_division,isset($township_name[0]->township_name)? $township_name[0]->township_name:'ALL',Input::get('academic_year'));		

		Excel::create('Student Enrollment', function($excel) use($Arr_school,$request_input) {

    	$excel->sheet('StudentEnrollment', function($sheet) use($Arr_school,$request_input){

        $sheet->prependRow(array('Township Education Management Information System'))->mergeCells('A1:E1',function($cells){
    				$cells->setFontSize(18);
    				$cells->setAlignment('center');
    				$cells->setValignment('middle');
    			});
    		$sheet->appendRow(array('Students Enrollment Report'))->mergeCells('A2:E2',function($cells){
    				
    				$cells->setFontSize(18);
    				$cells->setAlignment('center');
    				 $cells->setValignment('middle');
    			});
    		$sheet->appendRow(array('Division : '.$request_input[0]))->mergeCells('A3:E3',function($cells){
    			
    				$cells->setFontSize(18);
    				$cells->setAlignment('left');
    				 $cells->setValignment('middle');
    		});
    		$sheet->appendRow(array('Township : '.$request_input[1]))->mergeCells('A4:E4',function($cell){
    			
    				$cell->setFontSize(11);
    				$cell->setAlignment('right');
    				$cell->setValignment('middle');
    		});
    		$sheet->appendRow(array('Academic Year :'.$request_input[2]))->mergeCells('A5:E5',function($cell){
    			
    			$cell->setFontSize(18);
    			$cell->setAlignment('left');
    			$cell->setValignment('middle');
    		});

    		for($i = 0; $i < count($Arr_school); $i++) {

			if($Arr_school[$i]['location'] == "Rural") {
				$rural_level[] = $Arr_school[$i]['school_level'];
			}

			if($Arr_school[$i]['location'] == "Urban") {
				$urban_level[] = $Arr_school[$i]['school_level'];
			}

			}
			$rural_levels = array_values(array_unique($rural_level));
			$urban_levels = array_values(array_unique($urban_level));

///////////////// Start Rural
			$count=$sheet->getHighestRow()+1;
				$sheet->appendRow(array('Location : Rural'))->mergeCells('A'.$count.':E'.$count,function($cell){
				$cell->setFontWeight('bold');
	    		$cell->setFontSize(18);
	    		$cell->setAlignment('left');
	    		$cell->setValignment('middle');
			});
			for($row=0;$row<count($rural_levels);$row++)
			{ 
		
			$count=$sheet->getHighestRow()+1;
				$sheet->appendRow(array('School Level :'.$rural_levels[$row]))->mergeCells('A'.$count.':E'.$count,function($cell){
				$cell->setFontWeight('bold');
	    		$cell->setFontSize(18);
	    		$cell->setAlignment('left');
	    		$cell->setValignment('middle');
			});

			$sheet->appendRow(array('School No','School Name','G1 Students','Primary Students','Middle Students','High Students'));

		
			for($i=0;$i<count($Arr_school);$i++)
			{
				if($Arr_school[$i]['school_level'] == $rural_levels[$row] && $Arr_school[$i]['location']=="Rural")
				{
					$count=$sheet->getHighestRow()+1;
					$sheet->cell('A'.$count,function($cell) use($Arr_school,$i){
	    				$cell->setValue($Arr_school[$i]['school_no']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('B'.$count,function($cell) use($Arr_school,$i){
	    				$cell->setValue($Arr_school[$i]['school_name']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('C'.$count,function($cell) use($Arr_school,$i){
			    		
		   				$cell->setValue($Arr_school[$i]['g1']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
					$sheet->cell('D'.$count,function($cell) use($Arr_school,$i){
					
			    				$cell->setValue($Arr_school[$i]['total5']);
					    		$cell->setFontSize(12);
					    		$cell->setAlignment('left');
					    		$cell->setValignment('middle');
					    	});

					   		$sheet->cell('E'.$count,function($cell) use($Arr_school,$i){
							
			    				$cell->setValue($Arr_school[$i]['total9']);
					    		$cell->setFontSize(12);
					    		$cell->setAlignment('left');
					    		$cell->setValignment('middle');
					    	});	
					    	$sheet->cell('F'.$count,function($cell) use($Arr_school,$i){
					
			    				$cell->setValue($Arr_school[$i]['total11']);
					    		$cell->setFontSize(12);
					    		$cell->setAlignment('left');
					    		$cell->setValignment('middle');
					    	});
					}
			} 
		}		

//////////////// End Rural

/////////////// Start Urban

			$count=$sheet->getHighestRow()+1;
				$sheet->appendRow(array('Location : Urban'))->mergeCells('A'.$count.':F'.$count,function($cell){
				$cell->setFontWeight('bold');
	    		$cell->setFontSize(18);
	    		$cell->setAlignment('left');
	    		$cell->setValignment('middle');
			});
			for($row=0;$row<count($urban_levels);$row++)
			{ 
		
			$count=$sheet->getHighestRow()+1;
				$sheet->appendRow(array('School Level :'.$urban_levels[$row]))->mergeCells('A'.$count.':F'.$count,function($cell){
				$cell->setFontWeight('bold');
	    		$cell->setFontSize(18);
	    		$cell->setAlignment('left');
	    		$cell->setValignment('middle');
			});

			$sheet->appendRow(array('School No','School Name','G1 Students','Primary Students','Middle Students','High Students'));

			for($i=0;$i<count($Arr_school);$i++)
			{
				if($Arr_school[$i]['school_level'] == $urban_levels[$row] && $Arr_school[$i]['location']=="Urban")
				{
					$count=$sheet->getHighestRow()+1;
					$sheet->cell('A'.$count,function($cell) use($Arr_school,$i){
	    				$cell->setValue($Arr_school[$i]['school_no']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('B'.$count,function($cell) use($Arr_school,$i){
	    				$cell->setValue($Arr_school[$i]['school_name']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('C'.$count,function($cell) use($Arr_school,$i){
			    		
		   				$cell->setValue($Arr_school[$i]['g1']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
					$sheet->cell('D'.$count,function($cell) use($Arr_school,$i){
					
			    				$cell->setValue($Arr_school[$i]['total5']);
					    		$cell->setFontSize(12);
					    		$cell->setAlignment('left');
					    		$cell->setValignment('middle');
					    	});

					   		$sheet->cell('E'.$count,function($cell) use($Arr_school,$i){
							
			    				$cell->setValue($Arr_school[$i]['total9']);
					    		$cell->setFontSize(12);
					    		$cell->setAlignment('left');
					    		$cell->setValignment('middle');
					    	});	
					    	$sheet->cell('F'.$count,function($cell) use($Arr_school,$i){
					
			    				$cell->setValue($Arr_school[$i]['total11']);
					    		$cell->setFontSize(12);
					    		$cell->setAlignment('left');
					    		$cell->setValignment('middle');
					    	});
					}
			} 
		}
		$sheet->setBorder('A1'.':F'.$sheet->getHighestRow(), 'thin');
////////////// End Urban		
    	});

		})->download('xlsx');
			
			$err = "There is no data.";
			throw new Exception($err);
			
		} catch (Exception $e) {

			$error = "There is no data.";
			return view('students.enrollment', compact('error'));

		}
		
	}
}
 