@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">

        <li>

        	<a href="javascript:void(0);">Promotion Rate for Grade 5 or 9 or 11 of Year "t"</a>

        </li>

    <!--     <div class="box-icon" style='margin-top:-4px;'>
			<a href="#" class="btn btn-setting btn-round"><i class="icon-print"></i></a>
			<a href="#" class="btn btn-minimize btn-round"><i class="icon-print"></i></a>
			<a href="#" class="btn btn-close btn-round"><i class=" icon-download-alt"></i></a>
		</div> -->

    </ul>

</div>

<div class="box inner-content">

	<div class="row" style='margin:15px auto;'>
		<form action="{{ URL::route('promotion_rate_for_grade_5_or_9_or_11_list_exports') }}" method="post" style="display:inline;" class="form-horizontal">

			Grade&nbsp;
			<select name = "grade" id="grade" style="width:9%;">
				<option value="05" <?php echo 05 == Input::get('grade') ? ' selected="selected"' : ''; ?>>Grade 5</option>
				<option value="09" <?php echo 09 == Input::get('grade') ? ' selected="selected"' : ''; ?>>Grade 9</option>
				<option value="11" <?php echo 11 == Input::get('grade') ? ' selected="selected"' : ''; ?>>Grade 11</option>
			</select>
			<input type = "hidden" name = "previous_year" value="<?php echo Input::get('previous_year'); ?>" id = "previous_year" />

			@include('students.search_prev')&nbsp;<br/><br/>
			
			<div class="row" align="right">
				<input type="submit" id="btnSearch" value="Search" name="btn_search" class="btn btn-success" onclick = "this.form.action='{{ URL::route('promotion_rate_for_grade_5_or_9_or_11_list') }}'" />
				<input type="submit" class="btn btn-default" id="btnExport" value="Export" />
			</div>
				
		</form>
	</div><br/>


<?php if (isset($region)) { ?>
	
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
			<th>Successful Completers</th>
			<th><p>Number of</p><p>Students Enrollment</p></th>
			<th>Promotion Rate</th>
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
				<td><?php echo $sc[$c]->successful_completers; ?></td>
				<td><?php echo $se[$p]->students_enrollment; ?></td>
				<td>
					<?php
						if ($sc[$c]->successful_completers!=0 && $se[$p]->students_enrollment!=0) {
							echo round(($sc[$c]->successful_completers/$se[$p]->students_enrollment) * 100, 2) . "%";
						}
						else {
							echo "-";
						}
						
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
			<th>Successful Completers</th>
			<th><p>Number of</p><p>Students Enrollment</p></th>
			<th>Promotion Rate</th>
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
				<td><?php echo $sc[$c]->successful_completers; ?></td>
				<td><?php echo $se[$p]->students_enrollment; ?></td>
				<td>
					<?php
						echo round(($sc[$c]->successful_completers/$se[$p]->students_enrollment) * 100, 2) . "%";
					?>
				</td>
						
			</tr>	
	<?php 
		}}}} 
	?> 
</table>

<?php 
	
	}}} 
	
	if(isset($record)) echo $record;
	
?>
</div>

<script src="assets/js/backend_script.js"></script>
@stop