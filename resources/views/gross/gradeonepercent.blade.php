@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">

        <li>

        	<a href="javascript:void(0);">Grade One Intake Percentage</a>

        </li>

    </ul>

</div>

<div class="box inner-content">

	<div class="row" style='margin:15px auto;'>
		<form action="{{ URL::route('ExcelGradeOnePer') }}" method="post" style="display:inline;" class="form-horizontal">
			@include('students.search_form')
			<input type="submit" id="btnSearch" value="Search" name="btn_search" class="btn btn-success" onclick = "this.form.action='{{ URL::route('SearchGradeOnePer') }}'" />
			<input type="submit" class="btn btn-default" id="btnExport" value="Export" />
			
		</form>
	</div><br/>



	@if(isset($region))	
	<table class="table table-bordered">
		<tr>
			<th colspan="2" ><center>Township Education Management System</center></th>
		</tr>
		<tr>
			<th colspan='2'><center>Percentage of Grade One Intake with Preprimary/Preschool(ECCE) Experiences Report</center></th>
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
		
	<?php 

		 if(isset($tStudents)) { 
		 	
		 		for($i = 0; $i < count($tStudents); $i++) {

			if($tStudents[$i]->location == "Rural") {
				$rural_level[] = $tStudents[$i]->school_level;
			}

			if($tStudents[$i]->location == "Urban") {
				$urban_level[] = $tStudents[$i]->school_level;
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
			<th>Percentage</th>
		</tr>

		@for($row=0;$row<count($tStudents);$row++)
		<?php if($tStudents[$row]->location == "Rural" && $tStudents[$row]->school_level == $rural_levels[$k]) { ?>
			<tr>
				<td>{{ $tStudents[$row]->school_no }}</td>
				<td>{{ $tStudents[$row]->school_name }}</td>
				<td style="backgroun-color:#ededed">
				<?php
					$total=$tStudents[$row]->total_boy+$tStudents[$row]->total_girl;
					$total_ppeg=$tStudents[$row]->ppeg1_boy+$tStudents[$row]->ppeg1_girl;
					if($total_ppeg!=0)
					{
						$percent=($total_ppeg/$total) * 100;
						echo round($percent,2)." %";
					}
					else
					{
						echo "0%";
					}
					
				?>
				</td>
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
			<th>School No.</th>
			<th>School Name</th>
			<th>Percentage</th>
			
		</tr>

		@for($j=0;$j<count($tStudents);$j++)
		<?php if($tStudents[$j]->location == "Urban" && $tStudents[$j]->school_level == $urban_levels[$k]) { ?>
			<tr>
				<td>{{ $tStudents[$j]->school_no }}</td>
				<td>{{ $tStudents[$j]->school_name }}</td>
				<td>
				<?php
					$total=$tStudents[$j]->total_boy+$tStudents[$j]->total_girl;
					$total_ppeg=$tStudents[$j]->ppeg1_boy+$tStudents[$j]->ppeg1_girl;
					if($total_ppeg!=0)
					{
						$percent=($total_ppeg/$total) * 100;
						echo round($percent,2)." %";
					}
					else
					{
						echo "0%";
					}
				?>
				</td>

			</tr>	
		<?php } ?> 
		@endfor

	</table>

<?php } 

	
		 	}
		 	if(isset($error)) { echo "<p style='color:#ff0000;font-size:14px;'><b>". $error ."</b></p>"; }
?>


		

</div>

<script src="assets/js/backend_script.js"></script>
@stop