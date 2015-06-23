@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">

        <li>

        	<a href="javascript:void(0);">Students Attendance < 75%</a>

        </li>

        <div class="box-icon" style='margin-top:-4px;'>
			<a href="#" class="btn btn-setting btn-round"><i class="icon-print"></i></a>
			<a href="#" class="btn btn-minimize btn-round"><i class="icon-print"></i></a>
			<a href="#" class="btn btn-close btn-round"><i class=" icon-download-alt"></i></a>
		</div>

    </ul>

</div>



<div class="box inner-content">

	<div class="row" style='margin:15px auto;'>
		<form action="" method="post" style="display:inline;" class="form-horizontal">
			@include('students.search_form')&nbsp;
			<input type="submit" id="btnSearch" value="Search" name="btn_search" class="btn btn-success" onclick = "this.form.action='{{ URL::route('StdAttendanceList') }}'" />
			<!--  <input type="submit" class="btn btn-close btn-round" id="btnExport" value="Export Excel" />  -->
		</form>
	</div><br/>


<?php try{ //if(Input::get('btn_search')) { ?>

	<table class="table table-bordered">
		<tr>
			<th colspan="2" ><center>Township Education Management System</center></th>
		</tr>
		<tr>
			<th colspan='2' ><center>Students Attendance <75% Report</center></th>
		</tr>

	@foreach($region as $r)
		<tr>
			<th>Division:&nbsp;{{ $r->state_division }}</th>
			<th align='right'>Academic Year:&nbsp;<?php echo (Session::get('academic_year'))? Session::get('academic_year'):Input::get('academic_year'); ?></th>
		</tr>
		<tr>
			<th colspan='2'>Township:&nbsp;<?php if(isset($r->township_name)) { ?> {{ $r->township_name }} <?php } ?></th>
		</tr>
	@endforeach
	
	</table>
		
	<?php 
		if (count($attendance)>0) {
			for($i = 0; $i < count($attendance); $i++) {

			if($attendance[$i]->location == "Rural") {
				$rural_level[] = $attendance[$i]->school_level;
			}

			if($attendance[$i]->location == "Urban") {
				$urban_level[] = $attendance[$i]->school_level;
			}

		}

		$rural_levels = array_values(array_unique($rural_level));
		$urban_levels = array_values(array_unique($urban_level));

	?>

<!-- Stat Rural -->
	<table class="table table-bordered">
		<tr style="background:#DFF0D8;">
			<th><center>Location: Rural</center></th>
		</tr>
	</table>	
	
	<?php for($k = 0; $k < count($rural_levels); $k++) { ?>	
	
	<table class="table table-bordered">	
		<tr style="background:#FCF8E3;">
			<th>School Level:&nbsp;<?php echo $rural_levels[$k]; ?></th>
		</tr>
	</table>

	<table class="table table-bordered">
		<tr>
			<th>School No.</th>
			<th>School Name</th>
			<th>Boys</th>
			<th>Girls</th>
		</tr>

		@foreach($attendance as $att)
		<?php if($att->location == "Rural" && $att->school_level == $rural_levels[$k]) { ?>
			<tr>
				<td>{{ $att->school_no }}</td>
				<td>{{ $att->school_name }}</td>
				<td>{{ $att->boys }}</td>
				<td>{{ $att->girls }}</td>
			</tr>	
		<?php } ?> 
		@endforeach

	</table>

<?php } ?>

<!-- Stat Urban -->

<table class="table table-bordered">
		<tr style="background:#DFF0D8;">
			<th><center>Location: Urban</center></th>
		</tr>
	</table>	
	
	<?php for($l = 0; $l < count($urban_levels); $l++) { ?>	
	
	<table class="table table-bordered">	
		<tr style="background:#FCF8E3;">
			<th>School Level:&nbsp;<?php echo $urban_levels[$l]; ?></th>
		</tr>
	</table>

	<table class="table table-bordered">
		<tr>
			<th>School No.</th>
			<th>School Name</th>
			<th>Boys</th>
			<th>Girls</th>
		</tr>

		@foreach($attendance as $att)
		<?php if($att->location == "Urban" && $att->school_level == $urban_levels[$l]) { ?>
			<tr>
				<td>{{ $att->school_no }}</td>
				<td>{{ $att->school_name }}</td>
				<td>{{ $att->boys }}</td>
				<td>{{ $att->girls }}</td>
			</tr>	
		<?php } ?> 
		@endforeach

	</table>
		
		

<?php }}
	else {
		echo "<h4>There is no Data Record!</h4>";
	}
	//}
}
catch(\Exception $e)
{
	echo "<br /><table><tr><td style='color:red;font-size:20px;font-weight:bold;'>Please Check Searching!</td></tr></table>";
}
 ?>


</div>

<script src="assets/js/backend_script.js"></script>
@stop