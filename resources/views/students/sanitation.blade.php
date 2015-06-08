@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">

        <li>

        	<a href="javascript:void(0);">Sanitation</a>

        </li>

    </ul>

</div>



<div class="box inner-content">

	<div class="row" style='margin:15px auto;'>
		<form action="" method="post" style="display:inline;" class="form-horizontal">
			@include('students.search_form')
		</form>&nbsp;<!-- <a href="#">View All</a> -->
	</div><br/>


	<?php try {
		if(isset($region)) { ?>
	<table class="table table-bordered">
		<tr>
			<th colspan="2" ><center>Township Education Management System</center></th>
		</tr>
		<tr>
			<th colspan='2'><center>Sanitation/Students Ratio Report</center></th>
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
	<php } ?>
		
	<?php 
		if(isset($dtSchool)){
		for($i = 0; $i < count($dtSchool); $i++) {

			if($dtSchool[$i]->location == "Rural") {
				$rural_level[] = $dtSchool[$i]->school_level;
			}

			if($dtSchool[$i]->location == "Urban") {
				$urban_level[] = $dtSchool[$i]->school_level;
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
			<th colspan="5"></th>
			<th	colspan="3">Sanitation</th>
			<th colspan="3">Water</th>
		</tr>
		<tr>
			<th>School No.</th>
			<th>School Name</th>
			<th>Total Latrines</th>
			<th>Total Good Latrines</th>
			<th>Total Students</th>
			<th>Ratio Total Latrine</th>
			<th>Ratio Total Good Latrine</th>
			<th>Rank</th>
			<th>Availability</th>
			<th>Quality</th>
			<th>Safe to Drink</th>
			
		</tr>

		@for($row=0;$row<count($dtSchool);$row++)
		<?php if($dtSchool[$row]->location == "Rural" && $dtSchool[$row]->school_level == $rural_levels[$k]) { ?>
			<tr>
				<td>{{ $dtSchool[$row]->school_no }}</td>
				<td>{{ $dtSchool[$row]->school_name }}</td>
				<td>{{ $tLatrine[$row]->total_latrine }}</td>
				<td>{{ $tLatrine[$row]->total_good_latrine }}</td>
				<td>{{ $tStudents[$row]->total_students }}</td>
				<td style="backgroun-color:#ededed">{{ ($tLatrine[$row]->total_latrine!=0 )? $tStudents[$row]->total_students / $tLatrine[$row]->total_latrine :'0' }}</td>
				<td style="backgroun-color:#ededed">{{ ($tLatrine[$row]->total_good_latrine)? $tStudents[$row]->total_students / $tLatrine[$row]->total_good_latrine : '0' }} </td>
				<td>-</td>
				<td>{{ $tLatrine[$row]->Availability }}</td>
				<td>{{ $tLatrine[$row]->quality }}</td>
				<td>{{ $tLatrine[$row]->safe_to_drink }}</td>
			</tr>	
		<?php } ?> 
		@endfor

	</table>

<?php } ?>

<!-- Stat Urban -->

<table class="table table-bordered">
		<tr style="background:#DFF0D8;">
			<th><center>Location: Urban</center></th>
		</tr>
	</table>	
	
	<?php for($k = 0; $k < count($urban_levels); $k++) { ?>	
	
	<table class="table table-bordered">	
		<tr style="background:#FCF8E3;">
			<th>School Level:&nbsp;<?php echo $urban_levels[$k]; ?></th>
		</tr>
	</table>

	<table class="table table-bordered">
		<tr>
			<th colspan="5"></th>
			<th	colspan="3">Sanitation</th>
			<th colspan="3">Water</th>
		</tr>
		<tr>
			<th>School No.</th>
			<th>School Name</th>
			<th>Total Latrines</th>
			<th>Total Good Latrines</th>
			<th>Total Students</th>
			<th>Ratio Total Latrine</th>
			<th>Ratio Total Good Latrine</th>
			<th>Rank</th>
			<th>Availability</th>
			<th>Quality</th>
			<th>Safe to Drink</th>
			
		</tr>

		@for($j=0;$j<count($dtSchool);$j++)
		<?php if($dtSchool[$j]->location == "Urban" && $dtSchool[$j]->school_level == $rural_levels[$k]) { ?>
			<tr>
				<td>{{ $dtSchool[$j]->school_no }}</td>
				<td>{{ $dtSchool[$j]->school_name }}</td>
				<td>{{ $tLatrine[$j]->total_latrine }}</td>
				<td>{{ $tLatrine[$j]->total_good_latrine }}</td>
				<td>{{ $tStudents[$j]->total_students }}</td>
				<td style="backgroun-color:#ededed">{{ ($tLatrine[$j]->total_latrine!=0 )? $tStudents[$j]->total_students / $tLatrine[$j]->total_latrine :'0' }}</td>
				<td style="backgroun-color:#ededed">{{ ($tLatrine[$j]->total_good_latrine)? $tStudents[$j]->total_students / $tLatrine[$j]->total_good_latrine : '0' }} </td>
				<td>-</td>
				<td>{{ $tLatrine[$j]->Availability }}</td>
				<td>{{ $tLatrine[$j]->quality }}</td>
				<td>{{ $tLatrine[$j]->safe_to_drink }}</td>
			</tr>	
		<?php } ?> 
		@endfor

	</table>

<?php } ?>

<?php  } 
	else{
		if(isset($record)){
			echo $record;
		}
		else{
			echo "Please Check!";
		}
	}
}
}
	catch (Exception $e) {
		echo "<br /><table><tr><td style='color:red;font-size:20px;font-weight:bold;'>Please Check Searching!</td></tr></table>";
	}
	?>
</div>

<script src="assets/js/backend_script.js"></script>
@stop