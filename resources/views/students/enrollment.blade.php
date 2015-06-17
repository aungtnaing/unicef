@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">

        <li>

        	<a href="javascript:void(0);">Students Enrollment</a>

        </li>

    </ul>

</div>



<div class="box inner-content">

	<div class="row" style='margin:15px auto;'>
		<form action="" method="post" class="form-horizontal">
			@include('students.search_form')
			<input type="submit" id="btnSearch" value="Search" name="btn_search" class="btn btn-success" onclick = "this.form.action='{{ URL::route('SearchStdEnrollment') }}'" />
		</form>	
	</div>

	<?php try{ if(isset($region)) { ?>

	<table class="table table-bordered">
		<tr>
			<th colspan="2" ><center>Township Education Management System</center></th>
		</tr>
		<tr>
			<th colspan='2' ><center>Students Enrollment Report</center></th>
		</tr>
	@foreach($region as $r)
		<tr>
			<th>Division:&nbsp;{{ $r->state_division }}</th>
			<th align='right'>Academic Year:&nbsp;<?php echo Input::get('academic_year'); ?></th>
		</tr>
		<tr>
			<th colspan='2'>Township:&nbsp;{{ $r->township_name }}</th>
		</tr>
	@endforeach
	
	</table>
	<?php } 
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
	
	<table class="table table-bordered">
		<tr>
			<th><center>Location : Rural</center></th>
		</tr>
		<?php $i=0; $j=0; $k=0; $l=0; ?>
		<?php for($row=0;$row<count($rural_levels);$row++){ ?>
		<tr style="background:#FCF8E3;">
			<th>School Level:&nbsp;<?php echo $rural_levels[$row]; ?></th>
		</tr>
		<tr>
			<td>
			<table class="table table-bordered">
		<tr>
			<th>School No.</th>
			<th>School Name</th>
			<th>G1 Students</th>
			<th>Primary Students</th>
			<th>Middle Students</th>
			<th>High Students</th>
		</tr>
		
		
	@foreach($dtSchool as $School)
	<?php if($School->school_level == $rural_levels[$row]) { ?>
		<tr>
			<td>
				{{ $School->school_no}}
			</td>
			<td>
				{{ $School->school_name}}
			</td>
			<td>
				<?php 
					if($School->school_id==$dtG1Stds[$l]->school_id)// && $dtG1Stds[$l]->total_students!=0)
					{
						echo $dtG1Stds[$l]->total_students;
						$l++;
					}
				?>
			</td>
			<td>
				<?php 
					if($School->school_id==$dtPStds[$i]->school_id)// && $dtPStds[$i]->total_students!=0)
					{
						echo $dtPStds[$i]->total_students;
						$i++;
					}
				?>
				
			</td>
			<td>
				<?php 
					if($School->school_id==$dtMStds[$j]->school_id)// && $dtMStds[$j]->total_students!=0)
					{
						echo $dtMStds[$j]->total_students;
						$j++;
					}
				?>
				
			</td>
			<td>
				<?php 
					if($School->school_id==$dtHStds[$k]->school_id)// && $dtHStds[$k]->total_students!=0)
					{
						echo $dtHStds[$k]->total_students;
						$k++;	
					}
				?>
				
			</td>
		</tr>
		<?php } ?>
	@endforeach
	
	</table>
	</td>
		</tr>
		
	<?php }  ?>	
	</table>

	
	<table class="table table-bordered">
		<tr>
			<th><center>Location:&nbsp;Urban</center></th>
		</tr>
		@if(isset($urban_levels))
		<?php $i=0; $j=0; $k=0; $l=0; ?>
		<?php for($row=0;$row<count($urban_levels);$row++){ ?>
		<tr style="background:#FCF8E3;">
			<th>School Level:&nbsp;<?php echo $urban_levels[$row]; ?></th>
		</tr>
		
		<tr>
			<td>
			<table class="table table-bordered">
		<tr>
			<th>School No.</th>
			<th>School Name</th>
			<th>G1 Students</th>
			<th>Primary Students</th>
			<th>Middle Students</th>
			<th>High Students</th>
		</tr>
		
		
	@foreach($dtSchool as $School)
	<?php if($School->school_level == $urban_levels[$row]) { ?>
		<tr>
			
			<td>
				{{ $School->school_no}}
			</td>
			<td>
				{{ $School->school_name}}
			</td>
			<td>
				<?php 
					if($School->school_id==$dtG1Stds[$l]->school_id)// && $dtG1Stds[$l]->total_students!=0)
					{
						echo $dtG1Stds[$l]->total_students;
						$l++;
					}
				?>
			</td>
			<td>
				<?php 
					if($School->school_id==$dtPStds[$i]->school_id)// && $dtPStds[$i]->total_students!=0)
					{
						echo $dtPStds[$i]->total_students;
						$i++;
					}
				?>
				
			</td>
			<td>
				<?php 
					if($School->school_id==$dtMStds[$j]->school_id)// && $dtMStds[$j]->total_students!=0)
					{
						echo $dtMStds[$j]->total_students;
						$j++;
					}
				?>
				
			</td>
			<td>
				<?php 
					if($School->school_id==$dtHStds[$k]->school_id)// && $dtHStds[$k]->total_students!=0)
					{
						echo $dtHStds[$k]->total_students;
						$k++;	
					}
				?>
				
			</td>
		</tr>
		<?php } ?>
	@endforeach
	
	</table>
		</td>
		</tr>
		<?php } ?>
		@endif
	</table>
	<?php }
		if (isset($record)) {
			echo $record;
		}
	}
	catch(\Exception $ex){

		echo "<br /><table><tr><td style='color:red;font-size:20px;font-weight:bold;'>Please Check Searching!</td></tr></table>";
	}
	 ?>
	
</div>

<script src="assets/js/backend_script.js"></script>
@stop