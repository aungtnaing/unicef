@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">

        <li>

        	<a href="javascript:void(0);">Type Report Detail</a>

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
		<form action="{{ URL::route('TypeReportDetailListExport') }}" method="post" style="display:inline;" class="form-horizontal">
			@include('students.search_form')&nbsp;
			<input type="submit" id="btnSearch" value="Search" name="btn_search" class="btn btn-success" onclick = "this.form.action='{{ URL::route('TypeReportDetailList') }}'" />
			<input type="submit" class="btn btn-default" id="btnExport" value="Export Excel" />
		</form>
	</div><br/>

<?php if(isset($type_report_detail)) { ?>

	<table class="table table-bordered">
		<tr>
			<th colspan="2" ><center>Township Education Management System</center></th>
		</tr>
		<tr>
			<th colspan='2' ><center>No of School by School Type, Urban/Rual Detail Report</center></th>
		</tr>
	<?php if(is_array($region)) { ?>
		@foreach($region as $r)
			<tr>
				<th>Division:&nbsp;{{ $r->state_division }}</th>
				<th align='right'>Academic Year:&nbsp;<?php echo (Session::get('academic_year'))? Session::get('academic_year'):Input::get('academic_year'); ?></th>
			</tr>
			<tr>
				<th colspan='2'>Township:&nbsp;<?php if(isset($r->township_name)) { ?> {{ $r->township_name }} <?php } ?></th>
			</tr>
		@endforeach
	<?php } ?>
	
	</table>

	<?php 
		if (count($type_report_detail)>0) {
			for($i = 0; $i < count($type_report_detail); $i++) {

			if($type_report_detail[$i]->location == "Rural") {
				$rural_level[] = $type_report_detail[$i]->school_level;
			}

			if($type_report_detail[$i]->location == "Urban") {
				$urban_level[] = $type_report_detail[$i]->school_level;
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
		</tr>

		@foreach($type_report_detail as $tr)
		<?php if($tr->location == "Rural" && $tr->school_level == $rural_levels[$k]) { ?>
			<tr>
				<td>{{ $tr->school_no }}</td>
				<td>{{ $tr->school_name }}</td>
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
		</tr>

		@foreach($type_report_detail as $tr)
		<?php if($tr->location == "Urban" && $tr->school_level == $urban_levels[$l]) { ?>
			<tr>
				<td>{{ $tr->school_no }}</td>
				<td>{{ $tr->school_name }}</td>
			</tr>	
		<?php } ?> 
		@endforeach

	</table>
		
		

<?php }}
	else{

		echo "<h4> There is no data record.</h4>";
	}

} ?>

</div>	

<script src="assets/js/backend_script.js"></script>
@stop	