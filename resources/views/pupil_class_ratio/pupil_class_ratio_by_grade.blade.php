@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">

        <li>

        	<a href="javascript:void(0);">Pupil Class Ratio By Grade</a>

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
		<form action="{{ URL::route('pupil_class_ratio_by_grade_exports') }}" method="post" style="display:inline;" class="form-horizontal">
			Grade&nbsp;
			<select name = "grade" style="width:9%;">
				<option><?php echo Input::get('grade'); ?></option>
				<option value="01">Grade 1</option>
				<option value="02">Grade 2</option>
				<option value="03">Grade 3</option>
				<option value="04">Grade 4</option>
				<option value="05">Grade 5</option>
				<option value="06">Grade 6</option>
				<option value="07">Grade 7</option>
				<option value="08">Grade 8</option>
				<option value="09">Grade 9</option>
				<option value="10">Grade 10</option>
				<option value="11">Grade 11</option>
			</select>
			@include('students.search_form')
			<input type="submit" class="btn btn-default" id="btnExport" value="Export Excel" />
			<input type="submit" id="btnSearch" value="Search" name="btn_search" class="btn btn-success" onclick = "this.form.action='{{ URL::route('pupil_class_ratio_by_grade_list') }}'" />
		</form>
	</div><br/>

<?php if(Input::get('btn_search')) { ?>

	<table class="table table-bordered">
		<tr>
			<th colspan="2" ><center>Township Education Management System</center></th>
		</tr>
		<tr>
			<th colspan='2' ><center>No of School by School Type, Urban/Rual Report</center></th>
		</tr>
	@foreach($region as $r)
		<tr>
			<th>Division:&nbsp;{{ $r->state_division }}</th>
			<th align='right'>Academic Year:&nbsp;<?php echo Input::get('academic_year'); ?></th>
		</tr>
		<tr>
			<th>Township:&nbsp;<?php if(isset($r->township_name)) { ?> {{ $r->township_name }} <?php } ?></th>
			<th>Grade:&nbsp;<?php echo Input::get('grade'); ?></th>
		</tr>
	@endforeach
	
	</table>

	<?php

		for($i = 0; $i < count($sc); $i++) {

			if($sc[$i]->location == "Rural") {
				$rural_level[] = $sc[$i]->school_level;
			}

			if($sc[$i]->location == "Urban") {
				$urban_level[] = $sc[$i]->school_level;
			}

		}

		
		if(isset($rural_level)) {
			$rural_levels = array_values(array_unique($rural_level));
		}
		
		if(isset($urban_level)) {
			$urban_levels = array_values(array_unique($urban_level));
		}	

	?>

<!-- Stat Rural -->
	<table class="table table-bordered">
		<tr style="background:#DFF0D8;">
			<th><center>Location: Rural</center></th>
		</tr>
	</table>	
	
	<?php 
		if(isset($rural_level)) {
			for($k = 0; $k < count($rural_levels); $k++) { 
	?>	
	
	<table class="table table-bordered">	
		<tr style="background:#FCF8E3;">
			<th>School Level:&nbsp;<?php echo $rural_levels[$k]; ?></th>
		</tr>
	</table>

	<table class="table table-bordered">
		<tr>
			<th>School No.</th>
			<th>School Name</th>
			<th><p>Total Number</p><p>of Pupils</p></th>
			<th><p>Total Number of</p><p>Classes or Sections</p></th>
			<th>Pupil Class Ratio</th>
		</tr>

		<?php
			for($c = 0; $c < count($sc); $c++) {
				for ($p=0; $p < count($se) ; $p++) {
					if($sc[$c]->location == "Rural" && $se[$p]->location == "Rural" && $sc[$c]->school_level == $rural_levels[$k]) {
						if($sc[$c]->school_id == $se[$p]->school_id) {
		?>

			<tr>
				
				<td><?php echo $sc[$c]->school_no; ?></td>
				<td><?php echo $sc[$c]->school_name; ?></td>
				<td><?php echo $sc[$c]->pupil_no; ?></td>
				<td><?php echo $se[$p]->total_class; ?></td>
				<td>
					<?php
						echo ($sc[$c]->pupil_no/$se[$p]->total_class);
					?>
				</td>
						
			</tr>	
	<?php 
		}}}} 
	?> 
</table>
<?php }} ?>

<!-- Start Urban -->
	<table class="table table-bordered">
		<tr style="background:#DFF0D8;">
			<th><center>Location: Urban</center></th>
		</tr>
	</table>	
	
	<?php 
		if(isset($urban_level)) {
			for($l = 0; $l < count($urban_levels); $l++) { 
	?>	
	
	<table class="table table-bordered">	
		<tr style="background:#FCF8E3;">
			<th>School Level:&nbsp;<?php echo $urban_levels[$l]; ?></th>
		</tr>
	</table>

	<table class="table table-bordered">
		<tr>
			<th>School No.</th>
			<th>School Name</th>
			<th><p>Total Number</p><p>of Pupils</p></th>
			<th><p>Total Number of</p><p>Classes or Sections</p></th>
			<th>Pupil Class Ratio</th>
		</tr>

		<?php
			for($c = 0; $c < count($sc); $c++) {
				for ($p=0; $p < count($se) ; $p++) {
					if($sc[$c]->location == "Urban" && $se[$p]->location == "Urban" && $sc[$c]->school_level == $urban_levels[$l]) {
						if($sc[$c]->school_id == $se[$p]->school_id) {
		?>

			<tr>
				
				<td><?php echo $sc[$c]->school_no; ?></td>
				<td><?php echo $sc[$c]->school_name; ?></td>
				<td><?php echo $sc[$c]->pupil_no; ?></td>
				<td><?php echo $se[$p]->total_class; ?></td>
				<td>
					<?php
						echo ($sc[$c]->pupil_no/$se[$p]->total_class);
					?>
				</td>
						
			</tr>	
	<?php 
		}}}} 
	?> 
</table>

<?php 
	}} 
		if(isset($record)) echo $record;
	} 
?>
</div>

<script src="assets/js/backend_script.js"></script>
@stop