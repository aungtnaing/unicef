@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">

        <li>

        	<a href="javascript:void(0);">Transition Rate from Primary to Middle School Level (TRPMS)</a>

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
		<form action="{{ URL::route('transition_rate_primary_to_middle_list_export') }}" method="post" style="display:inline;" class="form-horizontal">
			<input type = "hidden" name = "previous_year" id = "previous_year" />
			@include('students.search_form')
						<input type="submit" class="btn btn-default" id="btnExport" value="Export Excel" />
			<input type="submit" id="btnSearch" value="Search" name="btn_search" class="btn btn-success" onclick = "this.form.action='{{ URL::route('transition_rate_primary_to_middle_list') }}'" />

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
			<th colspan='2'>Township:&nbsp;<?php if(isset($r->township_name)) { ?> {{ $r->township_name }} <?php } ?></th>
		</tr>
	@endforeach
	
	</table>

	<?php

		/*$total = ""; 

		for($i = 0; $i < count($current_year); $i++) {

			if($current_year[$i]->location == "Rural") {
				$rural_level[] = $current_year[$i]->school_level;
			}

			if($current_year[$i]->location == "Urban") {
				$urban_level[] = $current_year[$i]->school_level;
			}

			//$total += (int)$type_report[$i]->TotalSchools;

		}

		$rural_levels = array_values(array_unique($rural_level));
		$urban_levels = array_values(array_unique($urban_level));*/

	?>

<!-- Stat Rural -->
	<table class="table table-bordered">
		<tr style="background:#DFF0D8;">
			<th><center>Location: Rural</center></th>
		</tr>
	</table>	
	
	<table class="table table-bordered">
		<tr>
			<th>Township Name</th>
			<th><p>Successful completers in Grade 5</p><p>in the previous school-year</p></th>
			<th><p>New entrants to Grade 6</p><p>in current school-year</p></th>
			<th>Total</th>
		</tr>

			<?php
				for($c = 0; $c < count($current_year); $c++) {
					for ($p=0; $p < count($previous_year) ; $p++) {
						if($current_year[$c]->location == "Rural" && $previous_year[$p]->location == "Rural") {
							if($current_year[$c]->id == $previous_year[$p]->id) {
			?>
					<tr>
						<td><?php echo $current_year[$c]->township_name; ?></td>
						<td><?php echo $previous_year[$p]->previous_total_std; ?></td>
						<td><?php echo $current_year[$c]->current_total_std; ?></td>
						<td><?php echo ($current_year[$c]->current_total_std/$previous_year[$p]->previous_total_std) * 100; ?></td>
					</tr>	
			<?php 
							}
						}
					}	
				}
			?>
		
	</table>

	<!-- Stat Urban -->
	<table class="table table-bordered">
		<tr style="background:#DFF0D8;">
			<th><center>Location: Urban</center></th>
		</tr>
	</table>	
	
	<table class="table table-bordered">
		<tr>
			<th>Township Name</th>
			<th><p>Successful completers in Grade 5</p><p>in the previous school-year</p></th>
			<th><p>New entrants to Grade 6</p><p>in current school-year</p></th>
			<th>Total</th>
		</tr>

		<?php
				for($c = 0; $c < count($current_year); $c++) {
					for ($p=0; $p < count($previous_year) ; $p++) {
						if($current_year[$c]->location == "Urban" && $previous_year[$p]->location == "Urban") {
							if($current_year[$c]->id == $previous_year[$p]->id) {
			?>
					<tr>
						<td><?php echo $current_year[$c]->township_name; ?></td>
						<td><?php echo $previous_year[$p]->previous_total_std; ?></td>
						<td><?php echo $current_year[$c]->current_total_std; ?></td>
						<td><?php echo ($current_year[$c]->current_total_std/$previous_year[$p]->previous_total_std) * 100; ?></td>
					</tr>	
			<?php 
							}
						}
					}	
				}
			?>
	</table>

<?php 
	
		if(isset($record)) echo $record;
	} 

?>
</div>	

<script src="assets/js/backend_script.js"></script> 
@stop	