@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">

        <li>

        	<a href="javascript:void(0);">Combined (Primary and Middle School Levels)</a>

        </li>

    </ul>

</div>



<div class="box inner-content">

	<div class="row" style='margin:15px auto;'>
		<form action="{{ URL::route('CombinedGrossEnrollmentRatioLevelsExport') }}" method="post" style="display:inline;" class="form-horizontal">
			@include('students.search_form')&nbsp;
			<input type="submit" id="btnSearch" value="Search" name="btn_search" class="btn btn-success" onclick = "this.form.action='{{ URL::route('CombinedGrossEnrollmentRatioLevels') }}'" />
			<input type="submit" class="btn btn-close btn-round" id="btnExport" value="Export" />
		</form>&nbsp;<!-- <a href="#">View All</a> -->
	</div><br/>
	



	@if(isset($region))	
	<table class="table table-bordered">
		<tr>
			<th colspan="2" ><center>Township Education Management System</center></th>
		</tr>
		<tr>
			<th colspan='2'><center>Combined (Primary and Middle School Levels) Report</center></th>
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
	@endif

	@if(Input::get('btn_search'))
	
	
	<table class="table table-bordered">
		<tr>
			<th>School Levels</th>
			<th>Total Students</th>
			<th>Population</th>
			<th>Gross Enrollment Ratio</th>
		</tr>
		<tr>
			<td>Primary and Middle Levels<br>(Grade 1 to Grade 9)</td>
			<td>{{ ($total_intake_com[0]->total_students_com>0)? $total_intake_com[0]->total_students_com:'-' }}</td>
			<td>{{($total_populations[0]->total_pop_com!='')? $total_populations[0]->total_pop_com:'-'}}(age5 - 13)</td>
			<td>
				<?php
					if ($total_populations[0]->total_pop_com>0 && $total_intake_com[0]->total_students_com>0)
					{
						$com_ratio=$total_intake_com[0]->total_students_com/$total_populations[0]->total_pop_com *100;
						echo round($com_ratio,2)."%";
					}
					elseif ($total_intake_com[0]->total_students_com==0) {
						echo "There is no student for primary level.";
					}
					else
					{
						echo "There is no population record(age5-13)";
					}
				?>
			</td>
		</tr>
		
		
	</table>


@endif	


</div>

<script type="text/javascript" src="assets/js/backend_script.js"></script>
@stop