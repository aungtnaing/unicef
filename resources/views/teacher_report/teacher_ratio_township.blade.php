@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">

        <li>

        	<a href="javascript:void(0);">Student Teacher Ratio By Township Report </a>

        </li>

    </ul>

</div>



<div class="box inner-content">

	<div class="row" style='margin:15px auto;'>
		<form action="{{ URL::route('TeacherRatioByTownshipExport') }}" method="post" class="form-horizontal">
			@include('students.search_form')&nbsp;
			<input type="submit" id="btnSearch" value="Search" name="btn_search" class="btn btn-success" onclick = "this.form.action='{{ URL::route('TeacherRatioByTownshipSearch') }}'" />
			<input type="submit" class="btn btn-close btn-round" id="btnExport" value="Export" />
		</form>	
	</div>
	<?php
			if(isset($region)) { ?>

	<table class="table table-bordered">
		<tr>
			<th colspan="2" ><center>Township Education Management System</center></th>
		</tr>
		<tr>
			<th colspan='2' ><center>Students Teacher Ratio With Levels Report</center></th>
		</tr>
	@foreach($region as $r)
		<tr>
			<th>Division:&nbsp;{{ $r->state_division }}</th>
			<th align='right'>Academic Year:&nbsp;<?php echo Input::get('academic_year'); ?></th>
		</tr>
		<tr>
			<th colspan='2'>Township:&nbsp;{{ $r->township_name }}</th>
		</tr>
	@endforeach
	
	</table>
	<?php } 
	if(isset($dtSchool)){
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

	?>
	
	<table class="table table-bordered">
		<tr>
			<th><center>Location : Rural</center></th>
		</tr>
		
		<?php for($row=0;$row<count($rural_levels);$row++){ ?>
		<table class="table table-bordered">
		<tr style="background:#FCF8E3;">
			<th>School Level:&nbsp;<?php echo $rural_levels[$row]; ?></th>
		</tr>
		</table>
			<table class="table table-bordered">
		<tr>
			<th>Ratio</th>
			<th>Primary Ratio</th>
			<th>Middle Ratio</th>
			<th>High Ratio</th>
		</tr>
		
	<?php $pri_count=0;$mid_count=0;$high_count=0;$pri_count25=0;$mid_count25=0;$high_count25=0;$pri_count30=0;$mid_count30=0;$high_count30=0;$pri_count35=0;$mid_count35=0;$high_count35=0; $pri_count40=0;$mid_count40=0;$high_count40=0;$pri_count45=0;$mid_count45=0;$high_count45=0;$pri_count50=0;$mid_count50=0;$high_count50=0;$pri_count60=0;$mid_count60=0;$high_count60=0;?>	
	@for($i=0;$i<count($dtSchool);$i++)
	<?php if($dtSchool[$i]->school_level == $rural_levels[$row] && $dtSchool[$i]->location=="Rural") 
		{

			 $j=$i;$total5="";$total9="";$total11="";$pri_ratio="";$mid_ratio="";$high_ratio="";

			 $g1="";$g2="";$g3="";$g4="";$g5="";
					if($dtSchool[$i]->grade=='01') {
						$g1=$dtSchool[$i]->total_students;
						if ($i!=count($dtSchool)-1  && $dtSchool[$i+1]->school_no==$dtSchool[$i]->school_no) {
							$i+=1;
						}
					}
					if($dtSchool[$i]->grade=='02') {
						$g2=$dtSchool[$i]->total_students;
						if ($i!=count($dtSchool)-1 && $dtSchool[$i+1]->school_no==$dtSchool[$i]->school_no) {
							$i+=1;
						}
					}
					if($dtSchool[$i]->grade=='03') {
						$g3=$dtSchool[$i]->total_students;
						if ($i!=count($dtSchool)-1 && $dtSchool[$i+1]->school_no==$dtSchool[$i]->school_no) {
							$i+=1;
						}
					}
					if($dtSchool[$i]->grade=='04') {
						$g4=$dtSchool[$i]->total_students;
						if ($i!=count($dtSchool)-1 && $dtSchool[$i+1]->school_no==$dtSchool[$i]->school_no) {
							$i+=1;
						}
					}
					if ($dtSchool[$i]->grade=='05') {
						$g5=$dtSchool[$i]->total_students;
						if ($i!=count($dtSchool)-1 && $dtSchool[$i+1]->school_no==$dtSchool[$i]->school_no) {
							$i+=1;
						}
					}
					$total5=$g1+$g2+$g3+$g4+$g5;

				if ($dtSchool[$j]->primary_no!=0 && $dtSchool[$j]->primary_no!='' && $total5!=0) 
				{
					$pri_ratio=$total5/$dtSchool[$j]->primary_no+$dtSchool[$j]->head_no;
					$pri_ratio;
				}
				$g6="";$g7="";$g8="";$g9="";
					if($dtSchool[$i]->grade=='06') {
						$g6=$dtSchool[$i]->total_students;
						if ($i!=count($dtSchool)-1 && $dtSchool[$i+1]->school_no==$dtSchool[$i]->school_no) {
							$i+=1;
						}
					}
					if($dtSchool[$i]->grade=='07') {
						$g7=$dtSchool[$i]->total_students;
						if ($i!=count($dtSchool)-1 && $dtSchool[$i+1]->school_no==$dtSchool[$i]->school_no) {
							$i+=1;
						}
					}
					if($dtSchool[$i]->grade=='08') {
						$g8=$dtSchool[$i]->total_students;
						if ($i!=count($dtSchool)-1 && $dtSchool[$i+1]->school_no==$dtSchool[$i]->school_no) {
							$i+=1;
						}
					}
					if($dtSchool[$i]->grade=='09') {
						$g9=$dtSchool[$i]->total_students;
						if ($i!=count($dtSchool)-1 && $dtSchool[$i+1]->school_no==$dtSchool[$i]->school_no) {
							$i+=1;
						}
					}
					
				 $total9=$g6+$g7+$g8+$g9;
				if ($dtSchool[$j]->jat_no!=0 && $dtSchool[$j]->jat_no!='' && $total9!=0) 
				{
					$mid_ratio=$total9/$dtSchool[$j]->jat_no+$dtSchool[$j]->sat_no;
					$pri_mid=$pri_ratio+$mid_ratio;
				}

				$g10="";$g11="";
					if($dtSchool[$i]->grade=='10') {
						$g10=$dtSchool[$i]->total_students;
						if ($i!=count($dtSchool)-1 && $dtSchool[$i+1]->school_no==$dtSchool[$i]->school_no) {
							$i+=1;
						}
					}
					if($dtSchool[$i]->grade=='11') {
						$g11=$dtSchool[$i]->total_students;
						if ($i!=count($dtSchool)-1 && $dtSchool[$i+1]->school_no==$dtSchool[$i]->school_no) {
							$i+=1;
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
	 } ?>
	@endfor
		<tr>
			<td>
				Ratio 0
			</td>
			<td>
				{{$pri_count}}
			</td>
			<td>
				{{ $mid_count }}
			</td>
			<td>
				{{ $high_count }}
			</td>
		</tr>
		<tr>
			<td>
				Ratio Between 0 AND 25
			</td>
			<td>
				{{ $pri_count25}} 
			</td>
			<td>
				{{ $mid_count25 }}
			</td>
			<td>
				{{ $high_count25 }}
			</td>
			
		</tr>
		<tr>
			<td>
				Ratio Between 25 AND 30
			</td>
			<td>
				{{ $pri_count30 }}

			</td>
			<td>
				{{ $mid_count30}}
			</td>
			<td>
				{{ $high_count30 }}
			</td>
			
		</tr>
		<tr>
			<td>
				Ratio Between 30 AND 35
			</td>
			<td>
				{{ $pri_count35}}
			</td>
			<td>
				{{ $mid_count35}}
			</td>
			<td>
				{{ $high_count35}}
			</td>
			
		</tr>
		<tr>
			<td>
				Ratio Between 35 AND 40
			</td>
			<td>
				{{ $pri_count40 }}
			</td>
			<td>
				{{ $mid_count40 }}
			</td>
			<td>
				{{ $high_count40 }}
			</td>
		</tr>
		<tr>
			<td>
				Ratio Between 40 AND 45
			</td>
			<td>
				{{ $pri_count45 }}
			</td>
			<td>
				{{ $mid_count45}}
			</td>
			<td>
				{{$high_count45}}
			</td>
		</tr>
		<tr>
			<td>
				Ratio Between 45 AND 50
			</td>
			<td>
				{{ $pri_count50 }}
			</td>
			<td>
				{{ $mid_count50 }}
			</td>
			<td>
				{{ $high_count50 }}
			</td>			
		</tr>
		<tr>
			<td>
				Ratio > 50
			</td>
			<td>
				{{ $pri_count60 }}
			</td>
			<td>
				{{ $mid_count60 }}
			</td>
			<td>
				{{ $high_count60 }}
			</td>			
		</tr>
		
	
	
	</table>
	</td>
		</tr>
		
	<?php }  ?>	
	</table>

<!-- Start Urban -->
	
	<table class="table table-bordered">
		<tr>
			<th><center>Location:&nbsp;Urban</center></th>
		</tr>
	</table>
	
		@if(isset($urban_levels))
		
		<?php for($row=0;$row<count($urban_levels);$row++){ ?>
		<table class="table table-bordered">
		<tr style="background:#FCF8E3;">
			<th>School Level:&nbsp;<?php echo $urban_levels[$row]; ?></th>
		</tr>
	</table>
	<table class="table table-bordered">
		<tr>
			<th>Ratio</th>
			<th>Primary Ratio</th>
			<th>Middle Ratio</th>
			<th>High Ratio</th>
		</tr>
		
	<?php $pri_count=0;$mid_count=0;$high_count=0;$pri_count25=0;$mid_count25=0;$high_count25=0;$pri_count30=0;$mid_count30=0;$high_count30=0;$pri_count35=0;$mid_count35=0;$high_count35=0; $pri_count40=0;$mid_count40=0;$high_count40=0;$pri_count45=0;$mid_count45=0;$high_count45=0;$pri_count50=0;$mid_count50=0;$high_count50=0;$pri_count60=0;$mid_count60=0;$high_count60=0;?>		
	@for($i=0;$i<count($dtSchool);$i++)
	<?php if($dtSchool[$i]->school_level == $urban_levels[$row] && $dtSchool[$i]->location=="Urban")
	 { 

	$j=$i;$total5="";$total9="";$total11="";$pri_ratio="";$mid_ratio="";$high_ratio="";

			 $g1="";$g2="";$g3="";$g4="";$g5="";
					if($dtSchool[$i]->grade=='01') {
						$g1=$dtSchool[$i]->total_students;
						if ($i!=count($dtSchool)-1 && $dtSchool[$i+1]->school_no==$dtSchool[$i]->school_no) {
							$i+=1;
						}
					}
					if($dtSchool[$i]->grade=='02') {
						$g2=$dtSchool[$i]->total_students;
						if ($i!=count($dtSchool)-1 && $dtSchool[$i+1]->school_no==$dtSchool[$i]->school_no) {
							$i+=1;
						}
					}
					if($dtSchool[$i]->grade=='03') {
						$g3=$dtSchool[$i]->total_students;
						if ($i!=count($dtSchool)-1 && $dtSchool[$i+1]->school_no==$dtSchool[$i]->school_no) {
							$i+=1;
						}
					}
					if($dtSchool[$i]->grade=='04') {
						$g4=$dtSchool[$i]->total_students;
						if ($i!=count($dtSchool)-1 && $dtSchool[$i+1]->school_no==$dtSchool[$i]->school_no) {
							$i+=1;
						}
					}
					if ($dtSchool[$i]->grade=='05') {
						$g5=$dtSchool[$i]->total_students;
						if ($i!=count($dtSchool)-1 && $dtSchool[$i+1]->school_no==$dtSchool[$i]->school_no) {
							$i+=1;
						}
					}
					$total5=$g1+$g2+$g3+$g4+$g5;

				if ($dtSchool[$j]->primary_no!=0 && $dtSchool[$j]->primary_no!='' && $total5!=0) 
				{
					$pri_ratio=$total5/$dtSchool[$j]->primary_no+$dtSchool[$j]->head_no;
					$pri_ratio;
				}
				$g6="";$g7="";$g8="";$g9="";
					if($dtSchool[$i]->grade=='06') {
						$g6=$dtSchool[$i]->total_students;
						if ($i!=count($dtSchool)-1 && $dtSchool[$i+1]->school_no==$dtSchool[$i]->school_no) {
							$i+=1;
						}
					}
					if($dtSchool[$i]->grade=='07') {
						$g7=$dtSchool[$i]->total_students;
						if ($i!=count($dtSchool)-1 && $dtSchool[$i+1]->school_no==$dtSchool[$i]->school_no) {
							$i+=1;
						}
					}
					if($dtSchool[$i]->grade=='08') {
						$g8=$dtSchool[$i]->total_students;
						if ($i!=count($dtSchool)-1 && $dtSchool[$i+1]->school_no==$dtSchool[$i]->school_no) {
							$i+=1;
						}
					}
					if($dtSchool[$i]->grade=='09') {
						$g9=$dtSchool[$i]->total_students;
						if ($i!=count($dtSchool)-1 && $dtSchool[$i+1]->school_no==$dtSchool[$i]->school_no) {
							$i+=1;
						}
					}
					
				 $total9=$g6+$g7+$g8+$g9;
				if ($dtSchool[$j]->jat_no!=0 && $dtSchool[$j]->jat_no!='' && $total9!=0) 
				{
					$mid_ratio=$total9/$dtSchool[$j]->jat_no+$dtSchool[$j]->sat_no;
					$pri_mid=$pri_ratio+$mid_ratio;
				}

				$g10="";$g11="";
					if($dtSchool[$i]->grade=='10') {
						$g10=$dtSchool[$i]->total_students;
						if ($i!=count($dtSchool)-1 && $dtSchool[$i+1]->school_no==$dtSchool[$i]->school_no) {
							$i+=1;
						}
					}
					if($dtSchool[$i]->grade=='11') {
						$g11=$dtSchool[$i]->total_students;
						if ($i!=count($dtSchool)-1 && $dtSchool[$i+1]->school_no==$dtSchool[$i]->school_no) {
							$i+=1;
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
	 } ?>
	@endfor
		<tr>
			<td>
				Ratio 0
			</td>
			<td>
				{{$pri_count}}
			</td>
			<td>
				{{ $mid_count }}
			</td>
			<td>
				{{ $high_count }}
			</td>
		</tr>
		<tr>
			<td>
				Ratio Between 0 AND 25
			</td>
			<td>
				{{ $pri_count25}} 
			</td>
			<td>
				{{ $mid_count25 }}
			</td>
			<td>
				{{ $high_count25 }}
			</td>
			
		</tr>
		<tr>
			<td>
				Ratio Between 25 AND 30
			</td>
			<td>
				{{ $pri_count30 }}

			</td>
			<td>
				{{ $mid_count30}}
			</td>
			<td>
				{{ $high_count30 }}
			</td>
			
		</tr>
		<tr>
			<td>
				Ratio Between 30 AND 35
			</td>
			<td>
				{{ $pri_count35}}
			</td>
			<td>
				{{ $mid_count35}}
			</td>
			<td>
				{{ $high_count35}}
			</td>
			
		</tr>
		<tr>
			<td>
				Ratio Between 35 AND 40
			</td>
			<td>
				{{ $pri_count40 }}
			</td>
			<td>
				{{ $mid_count40 }}
			</td>
			<td>
				{{ $high_count40 }}
			</td>
		</tr>
		<tr>
			<td>
				Ratio Between 40 AND 45
			</td>
			<td>
				{{ $pri_count45 }}
			</td>
			<td>
				{{ $mid_count45}}
			</td>
			<td>
				{{$high_count45}}
			</td>
		</tr>
		<tr>
			<td>
				Ratio Between 45 AND 50
			</td>
			<td>
				{{ $pri_count50 }}
			</td>
			<td>
				{{ $mid_count50 }}
			</td>
			<td>
				{{ $high_count50 }}
			</td>			
		</tr>
		<tr>
			<td>
				Ratio > 50
			</td>
			<td>
				{{ $pri_count60 }}
			</td>
			<td>
				{{ $mid_count60 }}
			</td>
			<td>
				{{ $high_count60 }}
			</td>			
		</tr>
		
		
	</table>
		
		<?php } ?>
		@endif
			<?php }

			if(isset($error)) { echo "<p style='color:#ff0000;font-size:14px;'><b>". $error ."</b></p>"; }

	?>
	
</div>

<script src="assets/js/backend_script.js"></script>
@stop