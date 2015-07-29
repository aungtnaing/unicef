<?php namespace App\Http\Controllers;

use Maatwebsite\Excel\Facades\Excel;
use Input;
use Session;
use Redirect;
use Exception;
use Illuminate\Support\Facades\DB;


class TeacherRatioByTownshipController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}

	public function create()
	{
		return view('teacher_report.teacher_ratio_township');
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

			$dtSchool=DB::select("SELECT SUM(student_intake.total_boy)+SUM(student_intake.total_girl) AS total_students,student_intake.grade,v_school.school_no,v_school.school_name,v_school.location,v_school.school_level,teacher_count.primary_no,teacher_count.jat_no,teacher_count.sat_no,teacher_count.head_no,teacher_count.office_staff_no FROM v_school LEFT JOIN student_intake ON v_school.school_id=student_intake.school_id and v_school.school_year=student_intake.school_year LEFT JOIN teacher_count ON v_school.school_id=teacher_count.school_id AND v_school.school_year=teacher_count.school_year WHERE (v_school.state_divsion_id = '".$state_id."' OR ''='".$state_id."') AND (v_school.township_id ='".$township_id."' OR ''='".$township_id."') AND (student_intake.school_year='".$academic_year."' OR ''='".$academic_year."') GROUP BY v_school.school_no,student_intake.grade ");

			if(count($dtSchool)) {
				
				return view('teacher_report.teacher_ratio_township',compact('region','dtSchool'));
				
			} else {
				
				$error = "There is no data in this State or Townshiip.";
				return view('teacher_report.teacher_ratio_township', compact('error'));			
			}

			$err = "There is no data.";
			throw new Exception($err);
			
		} catch (Exception $e) {

			$error = "There is no data.";
			return view('teacher_report.teacher_ratio_township', compact('error'));

		}		
	}
	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	

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

		$dtSchool=DB::select("SELECT SUM(student_intake.total_boy)+SUM(student_intake.total_girl) AS total_students,student_intake.grade,v_school.school_no,v_school.school_name,v_school.location,v_school.school_level,teacher_count.primary_no,teacher_count.jat_no,teacher_count.sat_no,teacher_count.head_no,teacher_count.office_staff_no FROM v_school LEFT JOIN student_intake ON v_school.school_id=student_intake.school_id and v_school.school_year=student_intake.school_year LEFT JOIN teacher_count ON v_school.school_id=teacher_count.school_id AND v_school.school_year=teacher_count.school_year WHERE (v_school.state_divsion_id = '".$state_id."' OR ''='".$state_id."') AND (v_school.township_id ='".$township_id."' OR ''='".$township_id."') AND (student_intake.school_year='".$academic_year."' OR ''='".$academic_year."') GROUP BY v_school.school_no,student_intake.grade ");

			for($i = 0; $i < count($dtSchool); $i++) {

			if($dtSchool[$i]->location == "Rural") {
				$rural_level[] = $dtSchool[$i]->school_level;
			}

			if($dtSchool[$i]->location == "Urban") {
				$urban_level[] = $dtSchool[$i]->school_level;
			}

		}
		$rural_levels = array_values(array_unique($rural_level));
		$urban_levels = array_values(array_unique($urban_level));
		for($row=0;$row<count($rural_levels);$row++){
			///rural
			$pri_count=0;$mid_count=0;$high_count=0;$pri_count25=0;$mid_count25=0;$high_count25=0;$pri_count30=0;$mid_count30=0;$high_count30=0;$pri_count35=0;$mid_count35=0;$high_count35=0; $pri_count40=0;$mid_count40=0;$high_count40=0;$pri_count45=0;$mid_count45=0;$high_count45=0;$pri_count50=0;$mid_count50=0;$high_count50=0;$pri_count60=0;$mid_count60=0;$high_count60=0;
			///urban

			for($a=0;$a<count($dtSchool);$a++)
			{
				if($dtSchool[$a]->school_level == $rural_levels[$row] && $dtSchool[$a]->location=="Rural") 
				{
					 $j=$a;$total5="";$total9="";$total11="";$pri_ratio="";$mid_ratio="";$high_ratio="";

						$school_location=$dtSchool[$a]->location;
						$school_level=$dtSchool[$a]->school_level;

						$g1="";$g2="";$g3="";$g4="";$g5="";
							if($dtSchool[$a]->grade=='01') {
								$g1=$dtSchool[$a]->total_students;
								if ($a!=count($dtSchool)-1  && $dtSchool[$a+1]->school_no==$dtSchool[$a]->school_no) {
									$a+=1;
								}
							}
					if($dtSchool[$a]->grade=='02') {
						$g2=$dtSchool[$a]->total_students;
						if ($a!=count($dtSchool)-1  && $dtSchool[$a+1]->school_no==$dtSchool[$a]->school_no) {
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

				if ($dtSchool[$j]->primary_no!=0 && $dtSchool[$j]->primary_no!='' && $total5!=0) 
				{
					$pri_ratio=$total5/$dtSchool[$j]->primary_no+$dtSchool[$j]->head_no;
					$pri_ratio;
				}
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
				if ($dtSchool[$j]->jat_no!=0 && $dtSchool[$j]->jat_no!='' && $total9!=0) 
				{
					$mid_ratio=$total9/$dtSchool[$j]->jat_no+$dtSchool[$j]->sat_no;
					$pri_mid=$pri_ratio+$mid_ratio;
				}

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
					if ($dtSchool[$j]->sat_no!=0 && $dtSchool[$j]->sat_no!='' && $total11!=0) 
					{
						$high_ratio=$total11/$dtSchool[$j]->sat_no+$dtSchool[$j]->sat_no;
						$pri_mid_high=$pri_ratio+$mid_ratio+$high_ratio;
					}

					if($pri_ratio==0)
					{
						$pri_count=$pri_count+1;
					}
					if ($mid_ratio==0)
					{
						$mid_count=$mid_count+1;
					}
					if ($high_ratio==0)
					{
						$high_count=$high_count+1;
					}
					///25
					if($pri_ratio>0 && $pri_ratio<25)
					{
						$pri_count25=$pri_count25+1;
					}
					if ($mid_ratio>0 && $mid_ratio<25)
					{
						$mid_count25=$mid_count25+1;
					}
					if ($high_ratio>0 && $high_ratio<25)
					{
						$high_count25=$high_count25+1;
					}
					////30
					if($pri_ratio>25 && $pri_ratio<30)
					{
						$pri_count30=$pri_count30+1;
					}
					if ($mid_ratio>25 && $mid_ratio<30)
					{
						$mid_count30=$mid_count30+1;
					}
					if ($high_ratio>25 && $high_ratio<30)
					{
						$high_count30=$high_count30+1;
					}
					////35
					if($pri_ratio>30 && $pri_ratio<35)
					{
						$pri_count35=$pri_count35+1;
					}
					if ($mid_ratio>30 && $mid_ratio<35)
					{
						$mid_count35=$mid_count35+1;
					}
					if ($high_ratio>30 && $high_ratio<35)
					{
						$high_count35=$high_count35+1;
					}
					///40
					if($pri_ratio>35 && $pri_ratio<40)
					{
						$pri_count40=$pri_count40+1;
					}
					if ($mid_ratio>35 && $mid_ratio<40)
					{
						$mid_count40=$mid_count40+1;
					}
					if ($high_ratio>35 && $high_ratio<40)
					{
						$high_count40=$high_count40+1;
					}
					///45
					if($pri_ratio>40 && $pri_ratio<45)
					{
						$pri_count45=$pri_count45+1;
					}
					if ($mid_ratio>40 && $mid_ratio<45)
					{
						$mid_count45=$mid_count45+1;
					}
					if ($high_ratio>40 && $high_ratio<45)
					{
						$high_count45=$high_count45+1;
					}
					///50
					if($pri_ratio>45 && $pri_ratio<50)
					{
						$pri_count50=$pri_count50+1;
					}
					if ($mid_ratio>45 && $mid_ratio<50)
					{
						$mid_count50=$mid_count50+1;
					}
					if ($high_ratio>45 && $high_ratio<50)
					{
						$high_count50=$high_count50+1;
					}
					////>50
					if($pri_ratio>50)
					{
						$pri_count60=$pri_count60+1;
					}
					if ($mid_ratio>50)
					{
						$mid_count60=$mid_count60+1;
					}
					if ($high_ratio>50)
					{
						$high_count60=$high_count60+1;
					}	
				}			
			}
			$arr_rural[]=array(
					'location' => 'Rural',
					'school_level' => $rural_levels[$row],
					'ratio0' => 'Ratio 0',
					'pri_count' => $pri_count,
					'mid_count' => $mid_count,
					'high_count' => $high_count,
					'ratio25' => 'Ratio Between 0 and 25',
					'pri_count25' => $pri_count25,
					'mid_count25' => $mid_count25,
					'high_count25' => $high_count25,
					'ratio30' => 'Ratio Between 25 and 30',
					'pri_count30' => $pri_count30,
					'mid_count30' => $mid_count30,
					'high_count30' => $high_count30,
					'ratio35' => 'Ratio Between 30 and 35',
					'pri_count35' => $pri_count35,
					'mid_count35' => $mid_count35,
					'high_count35' => $high_count35,
					'ratio40' => 'Ratio Between 35 and 40',
					'pri_count40' => $pri_count40,
					'mid_count40' => $mid_count40,
					'high_count40' => $high_count40,
					'ratio45' => 'Ratio Between 40 and 45',
					'pri_count45' => $pri_count45,
					'mid_count45' => $mid_count45,
					'high_count45' => $high_count45,
					'ratio50' => 'Ratio Between 45 and 50',
					'pri_count50'  => $pri_count50,
					'mid_count50' => $mid_count50,
					'high_count50' => $high_count50,
					'ratio60' => 'Ratio > 50',
					'pri_count60' => $pri_count60,
					'mid_count60' => $mid_count60,
					'high_count60' => $high_count60	
					
				);
		}///end rural loop

		///start urban loop
		for($u=0;$u<count($urban_levels);$u++){
			///rural
			$pri_count=0;$mid_count=0;$high_count=0;$pri_count25=0;$mid_count25=0;$high_count25=0;$pri_count30=0;$mid_count30=0;$high_count30=0;$pri_count35=0;$mid_count35=0;$high_count35=0; $pri_count40=0;$mid_count40=0;$high_count40=0;$pri_count45=0;$mid_count45=0;$high_count45=0;$pri_count50=0;$mid_count50=0;$high_count50=0;$pri_count60=0;$mid_count60=0;$high_count60=0;


			for($su=0;$su<count($dtSchool);$su++)
			{
				if($dtSchool[$su]->school_level == $urban_levels[$u] && $dtSchool[$su]->location=="Urban") 
				{
					 $j=$su;$total5="";$total9="";$total11="";$pri_ratio="";$mid_ratio="";$high_ratio="";

						$school_location=$dtSchool[$su]->location;
						$school_level=$dtSchool[$su]->school_level;

						$g1="";$g2="";$g3="";$g4="";$g5="";
							if($dtSchool[$su]->grade=='01') {
								$g1=$dtSchool[$su]->total_students;
								if ($su!=count($dtSchool)-1  && $dtSchool[$su+1]->school_no==$dtSchool[$su]->school_no) {
									$su+=1;
								}
							}
					if($dtSchool[$su]->grade=='02') {
						$g2=$dtSchool[$su]->total_students;
						if ($su!=count($dtSchool)-1  && $dtSchool[$su+1]->school_no==$dtSchool[$su]->school_no) {
							$su+=1;
						}
					}
					if($dtSchool[$su]->grade=='03') {
						$g3=$dtSchool[$su]->total_students;
						if ($su!=count($dtSchool)-1 && $dtSchool[$su+1]->school_no==$dtSchool[$su]->school_no) {
							$su+=1;
						}
					}
					if($dtSchool[$su]->grade=='04') {
						$g4=$dtSchool[$su]->total_students;
						if ($su!=count($dtSchool)-1 && $dtSchool[$su+1]->school_no==$dtSchool[$su]->school_no) {
							$su+=1;
						}
					}
					if ($dtSchool[$su]->grade=='05') {
						$g5=$dtSchool[$su]->total_students;
						if ($su!=count($dtSchool)-1 && $dtSchool[$su+1]->school_no==$dtSchool[$su]->school_no) {
							$su+=1;
						}
					}
					$total5=$g1+$g2+$g3+$g4+$g5;

				if ($dtSchool[$j]->primary_no!=0 && $dtSchool[$j]->primary_no!='' && $total5!=0) 
				{
					$pri_ratio=$total5/$dtSchool[$j]->primary_no+$dtSchool[$j]->head_no;
					$pri_ratio;
				}
				$g6="";$g7="";$g8="";$g9="";
					if($dtSchool[$su]->grade=='06') {
						$g6=$dtSchool[$su]->total_students;
						if ($su!=count($dtSchool)-1 && $dtSchool[$su+1]->school_no==$dtSchool[$su]->school_no) {
							$su+=1;
						}
					}
					if($dtSchool[$su]->grade=='07') {
						$g7=$dtSchool[$su]->total_students;
						if ($su!=count($dtSchool)-1 && $dtSchool[$su+1]->school_no==$dtSchool[$su]->school_no) {
							$su+=1;
						}
					}
					if($dtSchool[$su]->grade=='08') {
						$g8=$dtSchool[$su]->total_students;
						if ($su!=count($dtSchool)-1 && $dtSchool[$su+1]->school_no==$dtSchool[$su]->school_no) {
							$su+=1;
						}
					}
					if($dtSchool[$su]->grade=='09') {
						$g9=$dtSchool[$su]->total_students;
						if ($su!=count($dtSchool)-1 && $dtSchool[$su+1]->school_no==$dtSchool[$su]->school_no) {
							$su+=1;
						}
					}
					
				 $total9=$g6+$g7+$g8+$g9;
				if ($dtSchool[$j]->jat_no!=0 && $dtSchool[$j]->jat_no!='' && $total9!=0) 
				{
					$mid_ratio=$total9/$dtSchool[$j]->jat_no+$dtSchool[$j]->sat_no;
					$pri_mid=$pri_ratio+$mid_ratio;
				}

				$g10="";$g11="";
					if($dtSchool[$su]->grade=='10') {
						$g10=$dtSchool[$su]->total_students;
						if ($su!=count($dtSchool)-1 && $dtSchool[$su+1]->school_no==$dtSchool[$su]->school_no) {
							$su+=1;
						}
					}
					if($dtSchool[$su]->grade=='11') {
						$g11=$dtSchool[$su]->total_students;
						if ($su!=count($dtSchool)-1 && $dtSchool[$su+1]->school_no==$dtSchool[$su]->school_no) {
							$su+=1;
						}
					}
									
					$total11=$g10+$g11;
					if ($dtSchool[$j]->sat_no!=0 && $dtSchool[$j]->sat_no!='' && $total11!=0) 
					{
						$high_ratio=$total11/$dtSchool[$j]->sat_no+$dtSchool[$j]->sat_no;
						$pri_mid_high=$pri_ratio+$mid_ratio+$high_ratio;
					}

					if($pri_ratio==0)
					{
						$pri_count=$pri_count+1;
					}
					if ($mid_ratio==0)
					{
						$mid_count=$mid_count+1;
					}
					if ($high_ratio==0)
					{
						$high_count=$high_count+1;
					}
					///25
					if($pri_ratio>0 && $pri_ratio<25)
					{
						$pri_count25=$pri_count25+1;
					}
					if ($mid_ratio>0 && $mid_ratio<25)
					{
						$mid_count25=$mid_count25+1;
					}
					if ($high_ratio>0 && $high_ratio<25)
					{
						$high_count25=$high_count25+1;
					}
					////30
					if($pri_ratio>25 && $pri_ratio<30)
					{
						$pri_count30=$pri_count30+1;
					}
					if ($mid_ratio>25 && $mid_ratio<30)
					{
						$mid_count30=$mid_count30+1;
					}
					if ($high_ratio>25 && $high_ratio<30)
					{
						$high_count30=$high_count30+1;
					}
					////35
					if($pri_ratio>30 && $pri_ratio<35)
					{
						$pri_count35=$pri_count35+1;
					}
					if ($mid_ratio>30 && $mid_ratio<35)
					{
						$mid_count35=$mid_count35+1;
					}
					if ($high_ratio>30 && $high_ratio<35)
					{
						$high_count35=$high_count35+1;
					}
					///40
					if($pri_ratio>35 && $pri_ratio<40)
					{
						$pri_count40=$pri_count40+1;
					}
					if ($mid_ratio>35 && $mid_ratio<40)
					{
						$mid_count40=$mid_count40+1;
					}
					if ($high_ratio>35 && $high_ratio<40)
					{
						$high_count40=$high_count40+1;
					}
					///45
					if($pri_ratio>40 && $pri_ratio<45)
					{
						$pri_count45=$pri_count45+1;
					}
					if ($mid_ratio>40 && $mid_ratio<45)
					{
						$mid_count45=$mid_count45+1;
					}
					if ($high_ratio>40 && $high_ratio<45)
					{
						$high_count45=$high_count45+1;
					}
					///50
					if($pri_ratio>45 && $pri_ratio<50)
					{
						$pri_count50=$pri_count50+1;
					}
					if ($mid_ratio>45 && $mid_ratio<50)
					{
						$mid_count50=$mid_count50+1;
					}
					if ($high_ratio>45 && $high_ratio<50)
					{
						$high_count50=$high_count50+1;
					}
					////>50
					if($pri_ratio>50)
					{
						$pri_count60=$pri_count60+1;
					}
					if ($mid_ratio>50)
					{
						$mid_count60=$mid_count60+1;
					}
					if ($high_ratio>50)
					{
						$high_count60=$high_count60+1;
					}	
				}			
			}
			$arr_urban[]=array(
					'location' => 'Urban',
					'school_level' => $urban_levels[$u],
					'ratio0' => 'Ratio 0',
					'pri_count' => $pri_count,
					'mid_count' => $mid_count,
					'high_count' => $high_count,
					'ratio25' => 'Ratio Between 0 and 25',
					'pri_count25' => $pri_count25,
					'mid_count25' => $mid_count25,
					'high_count25' => $high_count25,
					'ratio30' => 'Ratio Between 25 and 30',
					'pri_count30' => $pri_count30,
					'mid_count30' => $mid_count30,
					'high_count30' => $high_count30,
					'ratio35' => 'Ratio Between 30 and 35',
					'pri_count35' => $pri_count35,
					'mid_count35' => $mid_count35,
					'high_count35' => $high_count35,
					'ratio40' => 'Ratio Between 35 and 40',
					'pri_count40' => $pri_count40,
					'mid_count40' => $mid_count40,
					'high_count40' => $high_count40,
					'ratio45' => 'Ratio Between 40 and 45',
					'pri_count45' => $pri_count45,
					'mid_count45' => $mid_count45,
					'high_count45' => $high_count45,
					'ratio50' => 'Ratio Between 45 and 50',
					'pri_count50'  => $pri_count50,
					'mid_count50' => $mid_count50,
					'high_count50' => $high_count50,
					'ratio60' => 'Ratio > 50',
					'pri_count60' => $pri_count60,
					'mid_count60' => $mid_count60,
					'high_count60' => $high_count60	
					
				);
		}	/// end urban loop	
			$state_name=DB::select(DB::raw("SELECT state_division FROM state_division WHERE id=".Input::get('state_id')));

			if($township_id){
				$township_name=DB::select(DB::raw("SELECT township_name FROM township WHERE id=".Input::get('township_id')));
			}

			$request_input=array($state_name[0]->state_division,isset($township_name[0]->township_name)? $township_name[0]->township_name:'ALL',Input::get('academic_year'));	

			//print_r($arr_rural);
			Excel::create('Pupil Teacher Ratio', function($excel) use($rural_levels,$urban_levels,$arr_urban,$arr_rural,$request_input) {

			$excel->sheet('PupilTeacherTownshipRatio', function($sheet) use($rural_levels,$urban_levels,$arr_rural,$arr_urban,$request_input){

	        $sheet->prependRow(array('Township Education Management Information System'))->mergeCells('A1:D1',function($cells){
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('center');
	    				$cells->setValignment('middle');
	    			});
	    		$sheet->appendRow(array('Pupil Teacher Ratio By Township Report'))->mergeCells('A2:D2',function($cells){
	    				
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('center');
	    				 $cells->setValignment('middle');
	    			});
	    		$sheet->appendRow(array('Division : '.$request_input[0]))->mergeCells('A3:D3',function($cells){
	    			
	    				$cells->setFontSize(18);
	    				$cells->setAlignment('left');
	    				 $cells->setValignment('middle');
	    		});
	    		$sheet->appendRow(array('Township : '.$request_input[1]))->mergeCells('A4:D4',function($cell){
	    			
	    				$cell->setFontSize(11);
	    				$cell->setAlignment('right');
	    				$cell->setValignment('middle');
	    		});
	    		$sheet->appendRow(array('Academic Year :'.$request_input[2]))->mergeCells('A5:D5',function($cell){
	    			
	    			$cell->setFontSize(18);
	    			$cell->setAlignment('left');
	    			$cell->setValignment('middle');
	    		});

	    		

	///////////////// Start Rural
				$count=$sheet->getHighestRow()+1;
					$sheet->appendRow(array('Location : Rural'))->mergeCells('A'.$count.':D'.$count,function($cell){
					$cell->setFontWeight('bold');
		    		$cell->setFontSize(18);
		    		$cell->setAlignment('left');
		    		$cell->setValignment('middle');
				});
				for($row=0;$row<count($rural_levels);$row++)
				{ 
			
				$count=$sheet->getHighestRow()+1;
					$sheet->appendRow(array('School Level :'.$rural_levels[$row]))->mergeCells('A'.$count.':D'.$count,function($cell){
					$cell->setFontWeight('bold');
		    		$cell->setFontSize(18);
		    		$cell->setAlignment('left');
		    		$cell->setValignment('middle');
				});

				$sheet->appendRow(array('Ratio','Primary Ratio','Middle Ratio','High Ratio'));

				for($i=0;$i<count($arr_rural);$i++)
				{	
				if($arr_rural[$i]['school_level'] == $rural_levels[$row] && $arr_rural[$i]['location']=="Rural")
				{
					///ratio 0
					$count=$sheet->getHighestRow()+1;
					$sheet->cell('A'.$count,function($cell) use($arr_rural,$i){
	    				$cell->setValue('Ratio 0');
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('B'.$count,function($cell) use($arr_rural,$i){
	    				$cell->setValue($arr_rural[$i]['pri_count']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('C'.$count,function($cell) use($arr_rural,$i){
			    		
		   				$cell->setValue($arr_rural[$i]['mid_count']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
					$sheet->cell('D'.$count,function($cell) use($arr_rural,$i){
					
			    		$cell->setValue($arr_rural[$i]['high_count']);
					    $cell->setFontSize(12);
					    $cell->setAlignment('left');
					    $cell->setValignment('middle');
					});
					
					////ratio 25
					$count=$sheet->getHighestRow()+1;
					$sheet->cell('A'.$count,function($cell) use($arr_rural,$i){
	    				$cell->setValue($arr_rural[$i]['ratio25']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('B'.$count,function($cell) use($arr_rural,$i){
	    				$cell->setValue($arr_rural[$i]['pri_count25']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('C'.$count,function($cell) use($arr_rural,$i){
			    		
		   				$cell->setValue($arr_rural[$i]['mid_count25']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
					$sheet->cell('D'.$count,function($cell) use($arr_rural,$i){
					
			    		$cell->setValue($arr_rural[$i]['high_count25']);
					    $cell->setFontSize(12);
					    $cell->setAlignment('left');
					    $cell->setValignment('middle');
					});

					///ratio 30
					$count=$sheet->getHighestRow()+1;
					$sheet->cell('A'.$count,function($cell) use($arr_rural,$i){
	    				$cell->setValue($arr_rural[$i]['ratio30']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('B'.$count,function($cell) use($arr_rural,$i){
	    				$cell->setValue($arr_rural[$i]['pri_count30']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('C'.$count,function($cell) use($arr_rural,$i){
			    		
		   				$cell->setValue($arr_rural[$i]['mid_count30']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
					$sheet->cell('D'.$count,function($cell) use($arr_rural,$i){
					
			    		$cell->setValue($arr_rural[$i]['high_count30']);
					    $cell->setFontSize(12);
					    $cell->setAlignment('left');
					    $cell->setValignment('middle');
					});
					
					////ratio 35
					$count=$sheet->getHighestRow()+1;
					$sheet->cell('A'.$count,function($cell) use($arr_rural,$i){
	    				$cell->setValue($arr_rural[$i]['ratio35']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('B'.$count,function($cell) use($arr_rural,$i){
	    				$cell->setValue($arr_rural[$i]['pri_count35']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('C'.$count,function($cell) use($arr_rural,$i){
			    		
		   				$cell->setValue($arr_rural[$i]['mid_count35']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
					$sheet->cell('D'.$count,function($cell) use($arr_rural,$i){
					
			    		$cell->setValue($arr_rural[$i]['high_count35']);
					    $cell->setFontSize(12);
					    $cell->setAlignment('left');
					    $cell->setValignment('middle');
					});

					///ratio 40
					$count=$sheet->getHighestRow()+1;
					$sheet->cell('A'.$count,function($cell) use($arr_rural,$i){
	    				$cell->setValue($arr_rural[$i]['ratio40']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('B'.$count,function($cell) use($arr_rural,$i){
	    				$cell->setValue($arr_rural[$i]['pri_count40']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('C'.$count,function($cell) use($arr_rural,$i){
			    		
		   				$cell->setValue($arr_rural[$i]['mid_count40']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
					$sheet->cell('D'.$count,function($cell) use($arr_rural,$i){
					
			    		$cell->setValue($arr_rural[$i]['high_count40']);
					    $cell->setFontSize(12);
					    $cell->setAlignment('left');
					    $cell->setValignment('middle');
					});
					
					////ratio 45
					$count=$sheet->getHighestRow()+1;
					$sheet->cell('A'.$count,function($cell) use($arr_rural,$i){
	    				$cell->setValue($arr_rural[$i]['ratio45']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('B'.$count,function($cell) use($arr_rural,$i){
	    				$cell->setValue($arr_rural[$i]['pri_count45']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('C'.$count,function($cell) use($arr_rural,$i){
			    		
		   				$cell->setValue($arr_rural[$i]['mid_count45']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
					$sheet->cell('D'.$count,function($cell) use($arr_rural,$i){
					
			    		$cell->setValue($arr_rural[$i]['high_count45']);
					    $cell->setFontSize(12);
					    $cell->setAlignment('left');
					    $cell->setValignment('middle');
					});

					///ratio 50
					$count=$sheet->getHighestRow()+1;
					$sheet->cell('A'.$count,function($cell) use($arr_rural,$i){
	    				$cell->setValue($arr_rural[$i]['ratio50']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('B'.$count,function($cell) use($arr_rural,$i){
	    				$cell->setValue($arr_rural[$i]['pri_count50']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('C'.$count,function($cell) use($arr_rural,$i){
			    		
		   				$cell->setValue($arr_rural[$i]['mid_count50']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
					$sheet->cell('D'.$count,function($cell) use($arr_rural,$i){
					
			    		$cell->setValue($arr_rural[$i]['high_count50']);
					    $cell->setFontSize(12);
					    $cell->setAlignment('left');
					    $cell->setValignment('middle');
					});
					
					////ratio 60
					$count=$sheet->getHighestRow()+1;
					$sheet->cell('A'.$count,function($cell) use($arr_rural,$i){
	    				$cell->setValue($arr_rural[$i]['ratio60']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('B'.$count,function($cell) use($arr_rural,$i){
	    				$cell->setValue($arr_rural[$i]['pri_count60']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('C'.$count,function($cell) use($arr_rural,$i){
			    		
		   				$cell->setValue($arr_rural[$i]['mid_count60']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
					$sheet->cell('D'.$count,function($cell) use($arr_rural,$i){
					
			    		$cell->setValue($arr_rural[$i]['high_count60']);
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
					$sheet->appendRow(array('Location : Urban'))->mergeCells('A'.$count.':D'.$count,function($cell){
					$cell->setFontWeight('bold');
		    		$cell->setFontSize(18);
		    		$cell->setAlignment('left');
		    		$cell->setValignment('middle');
				});
				for($ur=0;$ur<count($urban_levels);$ur++)
				{ 
			
				$count=$sheet->getHighestRow()+1;
					$sheet->appendRow(array('School Level :'.$urban_levels[$ur]))->mergeCells('A'.$count.':D'.$count,function($cell){
					$cell->setFontWeight('bold');
		    		$cell->setFontSize(18);
		    		$cell->setAlignment('left');
		    		$cell->setValignment('middle');
				});

				$sheet->appendRow(array('Ratio','Primary Ratio','Middle Ratio','High Ratio'));

				for($au=0;$au<count($arr_urban);$au++)
				{	
				if($arr_urban[$au]['school_level'] == $urban_levels[$ur] && $arr_urban[$au]['location']=="Urban")
				{
					///ratio 0
					$count=$sheet->getHighestRow()+1;
					$sheet->cell('A'.$count,function($cell) use($arr_urban,$au){
	    				$cell->setValue('Ratio 0');
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('B'.$count,function($cell) use($arr_urban,$au){
	    				$cell->setValue($arr_urban[$au]['pri_count']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('C'.$count,function($cell) use($arr_urban,$au){
			    		
		   				$cell->setValue($arr_urban[$au]['mid_count']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
					$sheet->cell('D'.$count,function($cell) use($arr_urban,$au){
					
			    		$cell->setValue($arr_urban[$au]['high_count']);
					    $cell->setFontSize(12);
					    $cell->setAlignment('left');
					    $cell->setValignment('middle');
					});
					
					////ratio 25
					$count=$sheet->getHighestRow()+1;
					$sheet->cell('A'.$count,function($cell) use($arr_urban,$au){
	    				$cell->setValue($arr_urban[$au]['ratio25']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('B'.$count,function($cell) use($arr_urban,$au){
	    				$cell->setValue($arr_urban[$au]['pri_count25']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('C'.$count,function($cell) use($arr_urban,$au){
			    		
		   				$cell->setValue($arr_urban[$au]['mid_count25']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
					$sheet->cell('D'.$count,function($cell) use($arr_urban,$au){
					
			    		$cell->setValue($arr_urban[$au]['high_count25']);
					    $cell->setFontSize(12);
					    $cell->setAlignment('left');
					    $cell->setValignment('middle');
					});

					///ratio 30
					$count=$sheet->getHighestRow()+1;
					$sheet->cell('A'.$count,function($cell) use($arr_urban,$au){
	    				$cell->setValue($arr_urban[$au]['ratio30']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('B'.$count,function($cell) use($arr_urban,$au){
	    				$cell->setValue($arr_urban[$au]['pri_count30']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('C'.$count,function($cell) use($arr_urban,$au){
			    		
		   				$cell->setValue($arr_urban[$au]['mid_count30']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
					$sheet->cell('D'.$count,function($cell) use($arr_urban,$au){
					
			    		$cell->setValue($arr_urban[$au]['high_count30']);
					    $cell->setFontSize(12);
					    $cell->setAlignment('left');
					    $cell->setValignment('middle');
					});
					
					////ratio 35
					$count=$sheet->getHighestRow()+1;
					$sheet->cell('A'.$count,function($cell) use($arr_urban,$au){
	    				$cell->setValue($arr_urban[$au]['ratio35']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('B'.$count,function($cell) use($arr_urban,$au){
	    				$cell->setValue($arr_urban[$au]['pri_count35']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('C'.$count,function($cell) use($arr_urban,$au){
			    		
		   				$cell->setValue($arr_urban[$au]['mid_count35']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
					$sheet->cell('D'.$count,function($cell) use($arr_urban,$au){
					
			    		$cell->setValue($arr_urban[$au]['high_count35']);
					    $cell->setFontSize(12);
					    $cell->setAlignment('left');
					    $cell->setValignment('middle');
					});

					///ratio 40
					$count=$sheet->getHighestRow()+1;
					$sheet->cell('A'.$count,function($cell) use($arr_urban,$au){
	    				$cell->setValue($arr_urban[$au]['ratio40']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('B'.$count,function($cell) use($arr_urban,$au){
	    				$cell->setValue($arr_urban[$au]['pri_count40']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('C'.$count,function($cell) use($arr_urban,$au){
			    		
		   				$cell->setValue($arr_urban[$au]['mid_count40']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
					$sheet->cell('D'.$count,function($cell) use($arr_urban,$au){
					
			    		$cell->setValue($arr_urban[$au]['high_count40']);
					    $cell->setFontSize(12);
					    $cell->setAlignment('left');
					    $cell->setValignment('middle');
					});
					
					////ratio 45
					$count=$sheet->getHighestRow()+1;
					$sheet->cell('A'.$count,function($cell) use($arr_urban,$au){
	    				$cell->setValue($arr_urban[$au]['ratio45']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('B'.$count,function($cell) use($arr_urban,$au){
	    				$cell->setValue($arr_urban[$au]['pri_count45']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('C'.$count,function($cell) use($arr_urban,$au){
			    		
		   				$cell->setValue($arr_urban[$au]['mid_count45']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
					$sheet->cell('D'.$count,function($cell) use($arr_urban,$au){
					
			    		$cell->setValue($arr_urban[$au]['high_count45']);
					    $cell->setFontSize(12);
					    $cell->setAlignment('left');
					    $cell->setValignment('middle');
					});

					///ratio 50
					$count=$sheet->getHighestRow()+1;
					$sheet->cell('A'.$count,function($cell) use($arr_urban,$au){
	    				$cell->setValue($arr_urban[$au]['ratio50']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('B'.$count,function($cell) use($arr_urban,$au){
	    				$cell->setValue($arr_urban[$au]['pri_count50']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('C'.$count,function($cell) use($arr_urban,$au){
			    		
		   				$cell->setValue($arr_urban[$au]['mid_count50']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
					$sheet->cell('D'.$count,function($cell) use($arr_urban,$au){
					
			    		$cell->setValue($arr_urban[$au]['high_count50']);
					    $cell->setFontSize(12);
					    $cell->setAlignment('left');
					    $cell->setValignment('middle');
					});
					
					////ratio 60
					$count=$sheet->getHighestRow()+1;
					$sheet->cell('A'.$count,function($cell) use($arr_urban,$au){
	    				$cell->setValue($arr_urban[$au]['ratio60']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('B'.$count,function($cell) use($arr_urban,$au){
	    				$cell->setValue($arr_urban[$au]['pri_count60']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
			    	$sheet->cell('C'.$count,function($cell) use($arr_urban,$au){
			    		
		   				$cell->setValue($arr_urban[$au]['mid_count60']);
			    		$cell->setFontSize(12);
			    		$cell->setAlignment('left');
			    		$cell->setValignment('middle');
			    	});
					$sheet->cell('D'.$count,function($cell) use($arr_urban,$au){
					
			    		$cell->setValue($arr_urban[$au]['high_count60']);
					    $cell->setFontSize(12);
					    $cell->setAlignment('left');
					    $cell->setValignment('middle');
					});

					}
				}
			}
			
	////////////// End Urban
				$sheet->setBorder('A1'.':D'.$sheet->getHighestRow(), 'thin');		
	    	});

			})->download('xlsx');
			$err = "There is no data.";
			throw new Exception($err);
			
		} catch (Exception $e) {

			$error = "There is no data.";
			return view('teacher_report.teacher_ratio_township', compact('error'));

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
