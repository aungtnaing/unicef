@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">

        <li>

        	<a href="javascript:void(0);">Students Enrollment</a>

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
		try
		{
			if(isset($region)) { ?>

	<table class="table table-bordered">
		<tr>
			<th colspan="2" ><center>Township Education Management System</center></th>
		</tr>
		<tr>
			<th colspan='2' ><center>Students Enrollment Report</center></th>
		</tr>
	@foreach($region as $r)
		<tr>
			<th>Division:&nbsp;{{ $r->state_division }}</th>
			<th align='right'>Academic Year:&nbsp;<?php echo (Session::get('academic_year'))? Session::get('academic_year'):Input::get('academic_year'); ?></th>
		</tr>
		<tr>
			<th colspan='2'>Township:&nbsp;{{ $r->township_name }}</th>
		</tr>
	@endforeach
	
	</table>
	<?php } 
	if(isset($dtSchool)){
		/*for($i = 0; $i < count($dtSchool); $i++) {

			if($dtSchool[$i]->location == "Rural") {
				$rural[] = $dtSchool[$i]->location;
			}

			if($dtSchool[$i]->location == "Urban") {
				$urban[] = $dtSchool[$i]->location;
			}

		}
		$rurals = array_values(array_unique($rural));
		$urbans = array_values(array_unique($urban));*/

	?>
	
	<table class="table table-bordered">
		<tr>
			<th><center>Location : Rural</center></th>
		</tr>
	</table>	
		
	<table class="table table-bordered">
		<tr>
			<th>School Levels</th>
			<th>Total Students</th>
			<th>Total Teachers</th>
			<th>Ratio</th>
		</tr>
		
		
	@for($i=0;$i<count($dtSchool);$i++)
	<?php if($dtSchool[$i]->location=="Rural") { 

		$total_teachers=$dtSchool[$i]->total_pri+$dtSchool[$i]->total_jat+$dtSchool[$i]->total_sat+$dtSchool[$i]->total_head;
		?>
		<tr>
			<td>
				{{ $dtSchool[$i]->school_level}}
			</td>
			<td>
				{{ $dtSchool[$i]->total_students}}
			</td>
			<td>
				{{ $total_teachers }}
			</td>	
			
			<td> 
				<?php
					if ($total_teachers!=0 && $total_teachers!='' && $dtSchool[$i]->total_students!=0) 
					{
						$ratio=$dtSchool[$i]->total_students/$total_teachers;
						echo $ratio;
					}

				?>
			</td>
			
		</tr>
		<?php } ?>
	@endfor
	
	</table>
	
<!-- Start Urban -->
	
	<table class="table table-bordered">
		<tr>
			<th><center>Location:&nbsp;Urban</center></th>
		</tr>
		</table>
	<table class="table table-bordered">
		<tr>
			<th>School Levels</th>
			<th>Total Students</th>
			<th>Total Teachers</th>
			<th>Ratio</th>
		</tr>
		
		
	@for($j=0;$j<count($dtSchool);$j++)
	<?php if($dtSchool[$j]->location=="Urban") { 

		$total_teachers=$dtSchool[$j]->total_pri+$dtSchool[$j]->total_jat+$dtSchool[$j]->total_sat+$dtSchool[$j]->total_head;
		?>
		<tr>
			<td>
				{{ $dtSchool[$j]->school_level}}
			</td>
			<td>
				{{ $dtSchool[$j]->total_students}}
			</td>
			<td>
				{{ $total_teachers }}
			</td>	
			
			<td> 
				<?php
					if ($total_teachers!=0 && $total_teachers!='' && $dtSchool[$j]->total_students!=0) 
					{
						$ratio=$dtSchool[$j]->total_students/$total_teachers;
						echo $ratio;
					}
					e

				?>
			</td>
			
		</tr>
		<?php } ?>
	@endfor
	
	</table>
		
		<?php }}
		catch(Exception $ex)
		{
			echo "<br /><table><tr><td style='color:red;font-size:20px;font-weight:bold;'>Please Check Searching!</td></tr></table>";
		}

	?>
	
</div>

<script src="assets/js/backend_script.js"></script>
@stop