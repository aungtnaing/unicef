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
		<form action="" method="post" style="display:inline;" class="form-horizontal">
			@include('students.search_form')
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
	<?php

		$total = ""; 

		for($i = 0; $i < count($total_intake_pri); $i++) {

			if($total_intake_pri[$i]->location == "Rural" && $total_intake_mid[$i]->location=="Rural" && $total_intake_high[$i]->location=="Rural") {
				$pri_rural[]=($total_intake_pri[$i]->total_students_pri/$total_populations_pri[$i]->total_population_pri)*100;
				$mid_rural[]=($total_intake_mid[$i]->total_students_mid/$total_populations_mid[$i]->total_populations_mid)*100;
				$high_rural[]=($total_intake_high[$i]->total_students_high/$total_populations_high[$i]->total_populations_high)*100;
			}

			if($total_intake_pri[$i]->location == "Urban" && $total_intake_mid[$i]->location=="Urban" && $total_intake_high[$i]->location=="Urban") {
				$pri_urban[]=($total_intake_pri[$i]->total_students_pri/$total_populations_pri[$i]->total_population_pri)*100;
				$mid_urban[]=($total_intake_mid[$i]->total_students_mid/$total_populations_mid[$i]->total_populations_mid)*100;
				$high_urban[]=($total_intake_high[$i]->total_students_high/$total_populations_high[$i]->total_populations_high)*100;
				
			}
		}
		
		
	?>

<!-- Stat Rural -->
	<table class="table table-bordered">
		<tr style="background:#DFF0D8;">
			<th><center>Location: Rural</center></th>
		</tr>
	</table>	
	
	<table class="table table-bordered">
		<tr>
			<th>School Levels</th>
			<th>Gross Enrolment Rate</th>
		</tr>
		<tr>
			<td>Primary Level</td>
			<td>{{ $pri_rural[0]."%" }}</td>
		</tr>
		<tr>
			<td>Middle Level</td>
			<td>{{ $mid_rural[0] ."%"}}</td>
		</tr>
		<tr>
			<td>High Level</td>
			<td>{{ $high_rural[0] ."%"}}</td>
		</tr>
		
	</table>


<!-- Stat Urban -->
	<table class="table table-bordered">
		<tr style="background:#DFF0D8;">
			<th><center>Location: Urban</center></th>
		</tr>
	</table>	
	
	<table class="table table-bordered">
		<tr>
			<th>School Levels</th>
			<th>Gross Enrolment Rate</th>
		</tr>
		<tr>
			<td>Primary Level</td>
			<td>{{ $pri_urban[0] ."%"}}</td>
		</tr>
		<tr>
			<td>Middle Level</td>
			<td>{{ $mid_urban[0] ."%"}}</td>
		</tr>
		<tr>
			<td>High Level</td>
			<td>{{ $high_urban[0] ."%"}}</td>
		</tr>
	</table>
	@else
		@if(isset($record))
		{{ $record }}
		@endif
	@endif	
	

</div>

{{ HTML::script('assets/js/backend_script.js')}}
@stop