@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">

        <li>

        	<a href="javascript:void(0);">Promotion Rate for Grade 1 to Grade 10</a>

        </li>

    </ul>

</div>



<div class="box inner-content">

	<div class="row" style='margin:15px auto;'>
		<form action="" method="post" style="display:inline;" class="form-horizontal">
			<div>
			<input type="hidden" id="previous_year" name="previous_year" />			
			</div>
			
			<br/>
			@include('students.search_form')

		</form>&nbsp; <!-- <a href="#">View All</a> -->
	</div><br/>



	@if(isset($region))	
	<table class="table table-bordered">
		<tr>
			<th colspan="2" ><center>Township Education Management System</center></th>
		</tr>
		<tr>
			<th colspan='2' id="header"><center>Promotion Rate for Grade 1 to Grade 10 Report</center></th>
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

	@if(isset($new_total))
	<?php

		$total = ""; 

		for($i = 0; $i < count($new_total); $i++) {

			if($new_total[$i]->location == "Rural" && $pre_total[$i]->location=="Rural") {
				$grade_rural[]=$new_total[$i]->grade;
				$percent_rural[]=($new_total[$i]->total_students/$pre_total[$i]->total_students)*100;
				
			}

			if($new_total[$i]->location == "Urban" && $pre_total[$i]->location=="Urban") {
				$grade_urban[]=$new_total[$i]->grade;
				$percent_urban[]=($new_total[$i]->total_students/$pre_total[$i]->total_students)*100;
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
			<th>Grade</th>
			<th>Promotion Rate for Grade 2 to Grade 10</th>
		</tr>

		@for($k = 0; $k < count($grade_rural); $k++)	
			<tr>
				<td><?php echo "Grade&nbsp;".$grade_rural[$k]; ?></td>
				<td>{{ $percent_rural[$k] }}</td>
			</tr>
		@endfor
	</table>


<!-- Stat Urban -->
	<table class="table table-bordered">
		<tr style="background:#DFF0D8;">
			<th><center>Location: Urban</center></th>
		</tr>
	</table>	
	
	<table class="table table-bordered">
		<tr>
			<th>Grade</th>
			<th>Promotion Rate for Grade 2 to Grade 10</th>
		</tr>

		@for($k = 0; $k < count($grade_urban); $k++)	
			<tr>
				<td><?php echo "Grade&nbsp;". $grade_urban[$k]; ?></td>
				<td>{{ $percent_urban[$k] }}</td>
			</tr>
		@endfor
	</table>
	@endif	
</div>

{{ HTML::script('assets/js/backend_script.js')}}

@stop