@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">

        <li>

        	<a href="javascript:void(0);">Gross Enrollment Ratio : Primary, Middle and High School Level</a>

        </li>

    </ul>

</div>



<div class="box inner-content">

	<div class="row" style='margin:15px auto;'>
		<form action="{{ URL::route('GrossEnrollmentRationLevelsExport') }}" method="post" style="display:inline;" class="form-horizontal">
			@include('students.search_form')&nbsp;
			<input type="submit" id="btnSearch" value="Search" name="btn_search" class="btn btn-success" onclick = "this.form.action='{{ URL::route('GrossEnrollmentRationLevels') }}'" />
			<input type="submit" class="btn btn-close btn-round" id="btnExport" value="Export" />
		</form>&nbsp;<!-- <a href="#">View All</a> -->
	</div><br/>
	



	@if(isset($region))	
	<table class="table table-bordered">
		<tr>
			<th colspan="2" ><center>Township Education Management System</center></th>
		</tr>
		<tr>
			<th colspan='2'><center>Gross Enrollment Ratio : Primary, Middle and High School Level Report</center></th>
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

	@if(isset($total_intake_pri) && count($total_intake_pri)>0)
	
	
	<table class="table table-bordered">
		<tr>
			<th>School Levels</th>
			<th>Total Students</th>
			<th>Population</th>
			<th>Gross Enrollment Ratio</th>
		</tr>
		<tr>
			<td>Primary Level<br>(Grade 1 to Grade 5)</td>
			<td>{{ ($total_intake_pri[0]->total_students_pri>0)? $total_intake_pri[0]->total_students_pri:'-' }}</td>
			<td>{{($total_populations[0]->total5_9!='')? $total_populations[0]->total5_9:'-'}}(age5 - 9)</td>
			<td>
				<?php
					if ($total_populations[0]->total5_9>0 && $total_intake_pri[0]->total_students_pri>0) {
						$pri_ratio=$total_intake_pri[0]->total_students_pri/$total_populations[0]->total5_9 *100;
						echo round($pri_ratio,2)."%";
					}
					elseif ($total_intake_pri[0]->total_students_pri==0) {
						echo "There is no student for primary level.";
					}
					else
					{
						echo "There is no population record(age5-9)";
					}
				?>
			</td>
		</tr>
		<tr>
			<td>Middle Level<br>(Grade 6 to Grade 9)</td>
			<td>{{ $total_intake_mid[0]->total_students_mid }}</td>
			<td>{{($total_populations[0]->total10_13>0)? $total_populations[0]->total10_13:'-'}}(age10 - 13)</td>
			<td>
				<?php
					if ($total_populations[0]->total10_13>0 && $total_intake_mid[0]->total_students_mid > 0) {
						$pri_ratio=$total_intake_mid[0]->total_students_mid/$total_populations[0]->total10_13 *100;
						echo round($pri_ratio,2)."%";
					}
					elseif ($total_intake_mid[0]->total_students_mid==0) {
						echo "There is no student for Middle Level.";
					}
					else
					{
						echo "There is no population record(age10-13)";
					}
				?>
			</td>
		</tr>
		<tr>
			<td>High Level<br>(Grade 10 to Grade 11)</td>
			<td>{{ $total_intake_high[0]->total_students_high }}</td>
			<td>{{($total_populations[0]->total14_15>0)? $total_populations[0]->total14_15:'-'}}(age14 - 15)</td>
			<td>
				<?php
					if ($total_populations[0]->total14_15>0 && $total_intake_high[0]->total_students_high>0) {
						$pri_ratio=$total_intake_high[0]->total_students_high/$total_populations[0]->total14_15 *100;
						echo round($pri_ratio,2)."%";
					}
					elseif ($total_intake_high[0]->total_students_high==0) {
						echo "There is no student for High level.";
					}
					else
					{
						echo "There is no population record(age14-15)";
					}
				?>
			</td>
		</tr>
		
		
	</table>


@endif	


</div>

<script type="text/javascript" src="assets/js/backend_script.js"></script>
@stop