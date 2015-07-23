@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">

        <li>

        	<a href="javascript:void(0);">Completion Rate: High School Level</a>

        </li>
    </ul>

</div>

<div class="box inner-content">

	<div class="row" style='margin:15px auto;'>
		<form action="{{ URL::route('high_school_level_completion_rate_list_export_excel') }}" method="post" style="display:inline;" class="form-horizontal">
			
			<input type = "hidden" name = "previous_year" id = "previous_year" />
			@include('students.search')
			<input type="submit" id="btnSearch" value="Search" name="btn_search" class="btn btn-success" onclick = "this.form.action='{{ URL::route('high_school_level_completion_rate_list') }}'" /><i class="glyphicon glyphicon-search"></i>
			<input type="submit" class="btn btn-default" id="btnExport" value="Export" />
			
		</form>
	</div><br/>

<?php if(isset($current_year)) { ?>

	<table class="table table-bordered">
		<tr>
			<th colspan="2" ><center>Township Education Management System</center></th>
		</tr>
		<tr>
			<th colspan='2' ><center>Completion Rate: High School Level</center></th>
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
		<tr>
			<th>Township Name</th>
			<th align="center"><p>Successful completers in Grade 11</p><p>in current year</p></th>
			<th align="center"><p>Enrolment in Grade 10</p><p>in previous year</p></th>
			<th>Completion Rate</th>
		</tr>

			<?php
				for($c = 0; $c < count($current_year); $c++) {
					for ($p=0; $p < count($previous_year) ; $p++) {
						if($current_year[$c]->id == $previous_year[$p]->id) {
			?>
					<tr>
						<td><?php echo $current_year[$c]->township_name; ?></td>
						<td><?php echo $current_year[$c]->current_total_std; ?></td>
						<td><?php echo $previous_year[$p]->previous_total_std; ?></td>
						<td><?php echo round(($current_year[$c]->current_total_std/$previous_year[$p]->previous_total_std) * 100, 2) . "%"; ?></td>
					</tr>	
			<?php 
							
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