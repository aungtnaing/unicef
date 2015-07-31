@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">

        <li>

        	<a href="javascript:void(0);">Pupil Teacher Ratio Report</a>

        </li>

    </ul>

</div>



<div class="box inner-content">

	<div class="row" style='margin:15px auto;'>
		<form action="{{ URL::route('TeacherRatioExport') }}" method="post" class="form-horizontal">
			@include('students.search_form')&nbsp;
			<input type="submit" id="btnSearch" value="Search" name="btn_search" class="btn btn-success" onclick = "this.form.action='{{ URL::route('TeacherRatioSearch') }}'" />
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
			<th colspan='2' ><center>Pupil Teacher Ratio Report</center></th>
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
		<tr style="background:#FCF8E3;">
			<th>School Level:&nbsp;<?php echo $rural_levels[$row]; ?></th>
		</tr>
		<tr>
			<td>
			<table class="table table-bordered">
		<tr>
			<th>School No.</th>
			<th>School Name</th>
			<th>Head-master</th>
			<th>Primary Students</th>
			<th>Primary Teachers</th>
			<th>Primary Ratio</th>
			<th>Middle Students</th>
			<th>Middle Teachers</th>
			<th>Middle Ratio</th>
			<th>High Students</th>
			<th>High Teacher</th>
			<th>High Ratio</th>
		</tr>
		
		
	@for($i=0;$i<count($dtSchool);$i++)
	<?php if($dtSchool[$i]->school_level == $rural_levels[$row] && $dtSchool[$i]->location=="Rural") { $j=$i;$total5="";$total9="";$total11="";$pri_ratio="";$mid_ratio="";$high_ratio="";

		/////for primary
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

		///for middle
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

					/////for high
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

	?>
		<tr>
			<td>
				{{ $dtSchool[$i]->school_no}}
			</td>
			<td>
				{{ $dtSchool[$i]->school_name}}
			</td>
			<td>
				{{ $dtSchool[$j]->head_no }}
			</td>	
			<td>
				<?php 
					
					echo $total5=$g1+$g2+$g3+$g4+$g5;
				?>
				
			</td>
			<td>
				<?php echo $dtSchool[$j]->primary_no; ?>
			</td>
			<td> 
				<?php
					
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
							echo round(($total5/$pri_teacher),2);
						}
						
					}
				?>
			</td>
			<td>
				<?php 
					
					
					echo $total9=$g6+$g7+$g8+$g9;
				?>
				
			</td>
			<td>
				<?php echo $dtSchool[$j]->jat_no; ?>
			</td>
			<td> 
				<?php
					
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
							echo round(($total9/$mid_teacher),2);
						}
						else
						{
							if($dtSchool[$j]->head_no!=0)
							{
								echo round(($total9/$dtSchool[$j]->head_no),2);
							}
						}
					}
				?>
			</td>
			<td>
				<?php 
					
									
					echo $total11=$g10+$g11;
				?>
				
			</td>
			<td>
				<?php echo $dtSchool[$j]->sat_no; ?>
			</td>
			<td> 
				<?php
					
					if ($total11!=0)
					{
						
						if ($dtSchool[$j]->sat_no!=0) 
						{
							echo round(($total11/$dtSchool[$j]->sat_no),2);
						}
						else
						{
							if ($dtSchool[$j]->head_no!=0) {
								echo round(($total11/$dtSchool[$j]->head_no),2);
							}
						}
					}
					
				?>	
			</td>
		</tr>
		<?php } ?>
	@endfor
	
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
		@if(isset($urban_levels))
		
		<?php for($row=0;$row<count($urban_levels);$row++){ ?>
		<tr style="background:#FCF8E3;">
			<th>School Level:&nbsp;<?php echo $urban_levels[$row]; ?></th>
		</tr>
		
		<tr>
			<td>
			<table class="table table-bordered">
		<tr>
			<th>School No.</th>
			<th>School Name</th>
			<th>Head-master</th>
			<th>Primary Students</th>
			<th>Primary Teachers</th>
			<th>Primary Ratio</th>
			<th>Middle Students</th>
			<th>Middle Teachers</th>
			<th>Middle Ratio</th>
			<th>High Students</th>
			<th>High Teacher</th>
			<th>High Ratio</th>
		</tr>
		
		
	@for($i=0;$i<count($dtSchool);$i++)
	<?php if($dtSchool[$i]->school_level == $urban_levels[$row] && $dtSchool[$i]->location=="Urban") { $j=$i;$total5="";$total9="";$total11="";$pri_ratio="";$mid_ratio="";$high_ratio="";


			//for primary level
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

					//for middle level

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

					////for high level
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
	?>
		<tr>
			
			<td>
				{{ $dtSchool[$i]->school_no}}
			</td>
			<td>
				{{ $dtSchool[$i]->school_name}}
			</td>
			<td>
				{{ $dtSchool[$j]->head_no }}
			</td>
			<td>
				<?php 
					
					echo $total5;
				?>
				
			</td>
			<td>
			<?php echo $dtSchool[$j]->primary_no; ?>
			</td>
			<td> 
				<?php
					
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
							echo round(($total5/$pri_teacher),2);
						}
					}
				?>
			</td>
			<td>
				<?php 
					
					
					echo $total9;
				?>
				
			</td>
			<td>
			<?php echo ($dtSchool[$j]->jat_no)? $dtSchool[$j]->jat_no:'-'; ?>
			</td>
			<td> 
				<?php
					
					if ($total9!=0)
					 {
					 	$mid_teacher=$dtSchool[$j]->jat_no;
						if ($total11==0)
						{
							$mid_teacher=$mid_teacher+$dtSchool[$j]->sat_no;
						}
						if($mid_teacher!=0)
						{
							echo round(($total9/$mid_teacher),2);
						}
						else
						{
							if($dtSchool[$j]->head_no!=0)
							{
								echo round(($total9/$dtSchool[$j]->head_no),2);
							}
							
						}
					}
				?>
			</td>
			<td>
				<?php 
					
									
					echo $total11;
				?>
				
			</td>
			<td>
			<?php echo ($dtSchool[$j]->sat_no)? $dtSchool[$j]->sat_no:'-'; ?>
			</td>
			<td>
				<?php

					if ($total11!=0)
					{
						$high_teacher= $dtSchool[$j]->sat_no;
						if ($dtSchool[$j]->sat_no!=0) 
						{
							echo round(($total11/$dtSchool[$j]->sat_no),2);
							
						}
						else
						{
							if($dtSchool[$j]->head_no!=0)
							{
								echo round(($total11/$dtSchool[$j]->head_no),2);
							}
							
						}
					}
					
				?>
				
			</td>
		</tr>
		<?php } ?>
	@endfor
	
	</table>
		</td>
		</tr>
		<?php } ?>
		@endif
	</table>
		<?php 

		
	}
	
		if(isset($error)) { echo "<p style='color:#ff0000;font-size:14px;'><b>". $error ."</b></p>"; }

	?>
	
</div>

<script src="assets/js/backend_script.js"></script>
@stop