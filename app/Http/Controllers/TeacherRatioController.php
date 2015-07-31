<?php namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Input;
use Redirect;
use Exception;
use Illuminate\Support\Facades\DB;

class TeacherRatioController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	/**d
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		return view('teacher_report.teacher_ratio');
	}

	public function Search()
	{
		try {

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

			$dtSchool=DB::select("SELECT SUM(student_intake.total_boy)+SUM(student_intake.total_girl) AS total_students,student_intake.grade,v_school.school_no,v_school.school_name,v_school.location,v_school.school_level,teacher_count.primary_no,teacher_count.jat_no,teacher_count.sat_no,teacher_count.head_no,teacher_count.office_staff_no FROM v_school LEFT JOIN student_intake ON v_school.school_id=student_intake.school_id and v_school.school_year=student_intake.school_year LEFT JOIN teacher_count ON v_school.school_id=teacher_count.school_id AND v_school.school_year=teacher_count.school_year WHERE v_school.state_divsion_id = '".$state_id."' AND (v_school.township_id ='".$township_id."' OR ''='".$township_id."') AND student_intake.school_year='".$academic_year."' GROUP BY v_school.school_no,student_intake.grade ");
			//print_r($dtSchool);


			if(count($dtSchool)) {
				
				return view('teacher_report.teacher_ratio',compact('region','dtSchool'));
				
			} else {
				
				$error = "There is no data in this State or Townshiip.";
				return view('teacher_report.teacher_ratio', compact('error'));
			
			}
			
			$err = "There is no data.";
			throw new Exception($err);
			
		} catch (Exception $e) {

			$error = $e->getMessage();
			return view('students.type_report_detail', compact('error'));

		}	
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

		$dtSchool=DB::select("SELECT SUM(student_intake.total_boy)+SUM(student_intake.total_girl) AS total_students,student_intake.grade,v_school.school_no,v_school.school_name,v_school.location,v_school.school_level,teacher_count.primary_no,teacher_count.jat_no,teacher_count.sat_no,teacher_count.head_no,teacher_count.office_staff_no FROM v_school LEFT JOIN student_intake ON v_school.school_id=student_intake.school_id and v_school.school_year=student_intake.school_year LEFT JOIN teacher_count ON v_school.school_id=teacher_count.school_id AND v_school.school_year=teacher_count.school_year WHERE v_school.state_divsion_id = '".$state_id."' AND (v_school.township_id ='".$township_id."' OR ''='".$township_id."') AND student_intake.school_year='".$academic_year."' GROUP BY v_school.school_no,student_intake.grade ");
		
			for($a=0;$a<count($dtSchool);$a++)
			{
				$j=$a;$total5="";$total9="";$total11="";$pri_no="";$primary_ratio="";$middle_ratio="";$high_ratios="";
				$school_no=$dtSchool[$a]->school_no;
				$school_name=$dtSchool[$a]->school_name;
				$school_location=$dtSchool[$a]->location;
				$school_level=$dtSchool[$a]->school_level;

				$head_master=$dtSchool[$j]->head_no;
					////total primary students
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

						/////total middle students
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

						/// total high students
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


						///primary ratio
							if($total5!=0)
						{
							$pri_teacher=$dtSchool[$j]->primary_no;
							
							if ($total9==0) {
								$pri_teacher=$pri_teacher+$dtSchool[$j]->jat_no;
							}
							if ($total11==0) {
								$pri_teacher=$pri_teacher+$dtSchool[$j]->sat_no+$dtSchool[$j]->head_no;
							}
							if($pri_teacher!=0)
							{
								$primary_ratio= round(($total5/$pri_teacher),2);
							}
							
						}

						$pri_no=$dtSchool[$j]->primary_no;

						/*if($dtSchool[$j]->primary_no!=0)
						{
							if ($dtSchool[$j]->primary_no!=0 && $dtSchool[$j]->primary_no!='' && $total5!=0)
							{
								$pri_ratio=$total5/$dtSchool[$j]->primary_no;
								$primary_ratio= round($pri_ratio,2);
							}
						}
						else
						{
							if ($total5!=0 && $dtSchool[$j]->head_no!=0)
							{
								$pri_ratio=$total5/$dtSchool[$j]->head_no;
								$primary_ratio= round($pri_ratio,2);
							}
						}*/

						/*if ($dtSchool[$j]->primary_no!=0 && $dtSchool[$j]->primary_no!='' && $total5!=0)
						{
							$pri_ratio=$total5/$dtSchool[$j]->primary_no+$dtSchool[$j]->head_no;
							$primary_ratio= round($pri_ratio,2);//primary ratio
						}*/

						/// end primary ratio



						//middle students
						if ($total9!=0)
						{
							$mid_teacher=$dtSchool[$j]->jat_no;
							if ($total11==0)
							{
								$mid_teacher=$mid_teacher+$dtSchool[$j]->sat_no;
							}
							if($mid_teacher!=0)
							{
								//$mid_teacher=$mid_teacher+$dtSchool[$j]->head_no;
								$middle_ratio= round(($total9/$mid_teacher),2);
							}
							else
							{
								if($dtSchool[$j]->head_no!=0)
								{
									$middle_ratio=round(($total9/$dtSchool[$j]->head_no),2);
								}
								
							}
						}


						$mid_no=$dtSchool[$j]->jat_no;
						/*if($dtSchool[$j]->jat_no!=0)
						{
							if ($dtSchool[$j]->jat_no!=0 && $dtSchool[$j]->jat_no!='' && $total9!=0) 
							{
								$mid_ratio=$total9/$dtSchool[$j]->jat_no;
								$middle_ratio= round($mid_ratio,2);
							}
						}
						else
						{
							if ($total9!=0 && $dtSchool[$j]->head_no!=0)
							{
								$mid_ratio=$total9/$dtSchool[$j]->head_no;
								$middle_ratio= round($mid_ratio,2);
							}
						}*/
						/*if ($dtSchool[$j]->jat_no!=0 && $dtSchool[$j]->jat_no!='' && $total9!=0)
						{
							$mid_ratio=$total9/$dtSchool[$j]->jat_no+$dtSchool[$j]->sat_no;
							$middle_ratio= round($pri_ratio+$mid_ratio,2);
						}*/
						///////end middle ratio
						//high ratio
						if ($total11!=0)
						{
							
							if ($dtSchool[$j]->sat_no!=0) 
							{
								$high_ratios= round(($total11/$dtSchool[$j]->sat_no),2);
							}
							else
							{
								if ($dtSchool[$j]->head_no!=0) {
									$high_ratios=round(($total11/$dtSchool[$j]->head_no),2);
								}
							}
						}
						$high_no=$dtSchool[$j]->sat_no;
						/*if($dtSchool[$j]->sat_no!=0)
						{
							if ($dtSchool[$j]->sat_no!=0 && $dtSchool[$j]->sat_no!='' && $total11!=0) 
							{
								$high_ratio=$total11/$dtSchool[$j]->sat_no;
								$high_ratios= round($high_ratio,2);
							}
						}
						else
						{
							if ($total11!=0 && $dtSchool[$j]->head_no!=0)
							{
								$high_ratio=$total11/$dtSchool[$j]->head_no;
								$high_ratios= round($high_ratio,2);
							}
						}
*/
						/*if ($dtSchool[$j]->sat_no!=0 && $dtSchool[$j]->sat_no!='' && $total11!=0)
						{
							$high_ratio=$total11/$dtSchool[$j]->sat_no+$dtSchool[$j]->sat_no;
							$high_ratios= round($primary_ratio+$middle_ratio+$high_ratio,2);
						}*/

						$Arr_school[]=array(
								'school_no'=>$school_no,
								'school_name'=>$school_name,
								'school_level'=>$school_level,
								'location'=>$school_location,
								'head_no' => $head_master,
								'total5' => $total5,
								'pat_no' => $pri_no,
								'pat_ratio' => $primary_ratio,
								'total9' => $total9,
								'jat_nos' => $mid_no,
								'jat_ratio' => $middle_ratio,
								'total11' =>$total11,
								'sat_nos' => $high_no,
								'sat_ratio' => $high_ratios
							);	
							
			}
			
			$state_name=DB::select(DB::raw("SELECT state_division FROM state_division WHERE id=".Input::get('state_id')));

			if($township_id){
				$township_name=DB::select(DB::raw("SELECT township_name FROM township WHERE id=".Input::get('township_id')));
			}

			$request_input=array($state_name[0]->state_division,isset($township_name[0]->township_name)? $township_name[0]->township_name:'ALL',Input::get('academic_year'));	

			Excel::create('Pupil Teacher Ratio', function($excel) use($Arr_school,$request_input) {

	    	$excel->sheet('PupilTeacherRatio', function($sheet) use($Arr_school,$request_input){

	        $sheet->prependRow(array('Township Education Management Information System'))->mergeCells('A1:L1',function($cells){
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('center');
	    				$cells->setValignment('middle');
	    			});
	    		$sheet->appendRow(array('Pupil Teacher Ratio Report'))->mergeCells('A2:L2',function($cells){
	    				
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('center');
	    				 $cells->setValignment('middle');
	    			});
	    		$sheet->appendRow(array('Division : '.$request_input[0]))->mergeCells('A3:L3',function($cells){
	    			
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('left');
	    				 $cells->setValignment('middle');
	    		});
	    		$sheet->appendRow(array('Township : '.$request_input[1]))->mergeCells('A4:L4',function($cell){
	    			
	    				$cell->setFontSize(11);
	    				$cell->setAlignment('right');
	    				$cell->setValignment('middle');
	    		});
	    		$sheet->appendRow(array('Academic Year :'.$request_input[2]))->mergeCells('A5:L5',function($cell){
	    			
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
					$sheet->appendRow(array('Location : Rural'))->mergeCells('A'.$count.':L'.$count,function($cell){
					$cell->setFontWeight('bold');
		    		$cell->setFontSize(18);
		    		$cell->setAlignment('left');
		    		$cell->setValignment('middle');
				});
				for($row=0;$row<count($rural_levels);$row++)
				{ 
			
				$count=$sheet->getHighestRow()+1;
					$sheet->appendRow(array('School Level :'.$rural_levels[$row]))->mergeCells('A'.$count.':L'.$count,function($cell){
					$cell->setFontWeight('bold');
		    		$cell->setFontSize(18);
		    		$cell->setAlignment('left');
		    		$cell->setValignment('middle');
				});

				$sheet->appendRow(array('School No','School Name','Head Master','Primary Students','Primary Teachers','Primary Teacher Student Ratio','Middle Students','Middle Teacher','Middle Student Teacher Ratio','High Students','High Teacher','High Student Teacher Ratio'));

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
			    		
		   				$cell->setValue($Arr_school[$i]['head_no']);
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
					
			    		$cell->setValue($Arr_school[$i]['pat_no']);
						$cell->setFontSize(12);
						$cell->setAlignment('left');
						$cell->setValignment('middle');
					});
					$sheet->cell('F'.$count,function($cell) use($Arr_school,$i){
					
			    		$cell->setValue($Arr_school[$i]['pat_ratio']);
						$cell->setFontSize(12);
						$cell->setAlignment('left');
						$cell->setValignment('middle');
					});
			   		$sheet->cell('G'.$count,function($cell) use($Arr_school,$i){

	    				$cell->setValue($Arr_school[$i]['total9']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('H'.$count,function($cell) use($Arr_school,$i){
					
			    		$cell->setValue($Arr_school[$i]['jat_nos']);
						$cell->setFontSize(12);
						$cell->setAlignment('left');
						$cell->setValignment('middle');
					});
					$sheet->cell('I'.$count,function($cell) use($Arr_school,$i){
					
			    		$cell->setValue($Arr_school[$i]['jat_ratio']);
						$cell->setFontSize(12);
						$cell->setAlignment('left');
						$cell->setValignment('middle');
					});	
			    	$sheet->cell('J'.$count,function($cell) use($Arr_school,$i){
			
	    				$cell->setValue($Arr_school[$i]['total11']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('K'.$count,function($cell) use($Arr_school,$i){
					
			    		$cell->setValue($Arr_school[$i]['sat_nos']);
						$cell->setFontSize(12);
						$cell->setAlignment('left');
						$cell->setValignment('middle');
					});
					$sheet->cell('L'.$count,function($cell) use($Arr_school,$i){
					
			    		$cell->setValue($Arr_school[$i]['sat_ratio']);
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

					$sheet->appendRow(array('School No','School Name','Head Master','Primary Students','Primary Teachers','Primary Teacher Student Ratio','Middle Students','Middle Teacher','Middle Student Teacher Ratio','High Students','High Teacher','High Student Teacher Ratio'));
				for($u=0;$u<count($Arr_school);$u++)
				{	
				if($Arr_school[$u]['school_level'] == $urban_levels[$row] && $Arr_school[$u]['location']=="Urban")
				{
					$count=$sheet->getHighestRow()+1;
					$sheet->cell('A'.$count,function($cell) use($Arr_school,$u){
	    				$cell->setValue($Arr_school[$u]['school_no']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('B'.$count,function($cell) use($Arr_school,$u){
	    				$cell->setValue($Arr_school[$u]['school_name']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('C'.$count,function($cell) use($Arr_school,$u){
			    		
		   				$cell->setValue($Arr_school[$u]['head_no']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
					$sheet->cell('D'.$count,function($cell) use($Arr_school,$u){
					
			    		$cell->setValue($Arr_school[$u]['total5']);
					    $cell->setFontSize(12);
					    $cell->setAlignment('left');
					    $cell->setValignment('middle');
					});
					
					$sheet->cell('E'.$count,function($cell) use($Arr_school,$u){
					
			    		$cell->setValue($Arr_school[$u]['pat_no']);
						$cell->setFontSize(12);
						$cell->setAlignment('left');
						$cell->setValignment('middle');
					});
					$sheet->cell('F'.$count,function($cell) use($Arr_school,$u){
					
			    		$cell->setValue($Arr_school[$u]['pat_ratio']);
						$cell->setFontSize(12);
						$cell->setAlignment('left');
						$cell->setValignment('middle');
					});
			   		$sheet->cell('G'.$count,function($cell) use($Arr_school,$u){

	    				$cell->setValue($Arr_school[$u]['total9']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('H'.$count,function($cell) use($Arr_school,$u){
					
			    		$cell->setValue($Arr_school[$u]['jat_nos']);
						$cell->setFontSize(12);
						$cell->setAlignment('left');
						$cell->setValignment('middle');
					});
					$sheet->cell('I'.$count,function($cell) use($Arr_school,$u){
					
			    		$cell->setValue($Arr_school[$u]['jat_ratio']);
						$cell->setFontSize(12);
						$cell->setAlignment('left');
						$cell->setValignment('middle');
					});	
			    	$sheet->cell('J'.$count,function($cell) use($Arr_school,$u){
			
	    				$cell->setValue($Arr_school[$u]['total11']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('K'.$count,function($cell) use($Arr_school,$u){
					
			    		$cell->setValue($Arr_school[$u]['sat_nos']);
						$cell->setFontSize(12);
						$cell->setAlignment('left');
						$cell->setValignment('middle');
					});
					$sheet->cell('L'.$count,function($cell) use($Arr_school,$u){
					
			    		$cell->setValue($Arr_school[$u]['sat_ratio']);
						$cell->setFontSize(12);
						$cell->setAlignment('left');
						$cell->setValignment('middle');
					});
				}
 			}

			
				
				}
				$sheet->setBorder('A1'.':L'.$sheet->getHighestRow(), 'thin');
	////////////// End Urban		
	    	});

			})->download('xlsx');


			$err = "There is no data.";
			throw new Exception($err);
			
		} catch (Exception $e) {

			$error = "There is no data.";
			return view('teacher_report.teacher_ratio', compact('error'));

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
