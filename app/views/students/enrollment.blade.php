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
		</form>	
	</div>
	<?php if(isset($region)) { ?>

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
	<?php } ?>
	@if(isset($r_sLevel))
	<?php  for ($n=0; $n < count($r_sLevel); $n++) {

			$sch_level[]=$r_sLevel[$n]->school_level;

		} 
		$levels=array_values(array_unique($sch_level));
		
	?>
	
	<table class="table table-bordered">
		<tr>
			<th><center>Location : {{$r_sLevel[0]->location}}</center></th>
		</tr>
		<?php $i=0; $j=0; $k=0; $l=0; ?>
		<?php for($row=0;$row<count($levels);$row++){ ?>
		<tr style="background:#FCF8E3;">
			<th>School Level:&nbsp;<?php echo $levels[$row]; ?></th>
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
		
		
	@foreach($r_sLevel as $School)
	<?php if($School->school_level == $levels[$row]) { ?>
		<tr>
			<td>
				{{ $School->school_no}}
			</td>
			<td>
				{{ $School->school_name}}
			</td>
			<td>
				{{ isset($dtG1Stds[$l][0]->total_students)? $dtG1Stds[$l][0]->total_students:'-'}}
			</td>
			<td>
				{{ isset($dtPStds[$i][0]->total_students)? $dtPStds[$i][0]->total_students:'-'}}
			</td>
			<td>
				{{ isset($dtMStds[$j][0]->total_students)? $dtMStds[$j][0]->total_students:'-'}}
			</td>
			<td>
				{{ isset($dtHStds[$k][0]->total_students)? $dtHStds[$k][0]->total_students:'-'}}
			</td>
		</tr>
		<?php $i++; $j++; $k++;$l++; }?>
	@endforeach
	
	</table>
	</td>
		</tr>
		
	<?php }  ?>	
	</table>
	@endif

	@if(isset($u_sLevel))
	<?php for ($n=0; $n < count($u_sLevel); $n++) {

			$sch_levels[]=$u_sLevel[$n]->school_level;

		} 
		$levels_u=array_values(array_unique($sch_levels));
		

	?>
	<table class="table table-bordered">
		<tr>
			<th><center>Location:&nbsp;{{isset($u_sLevel[0]->location)? $u_sLevel[0]->location:''}}</center></th>
		</tr>
		<?php $i=0; $j=0; $k=0; $l=0; ?>
		<?php for($row=0;$row<count($levels_u);$row++){ ?>
		<tr style="background:#FCF8E3;">
			<th>School Level:&nbsp;<?php echo $levels_u[$row]; ?></th>
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
		
		
	@foreach($u_sLevel as $School)
	<?php if($School->school_level == $levels_u[$row]) { ?>
		<tr>
			
			<td>
				{{ $School->school_no}}
			</td>
			<td>
				{{ $School->school_name}}
			</td>
			<td>
				{{ isset($dtuG1Stds[$l][0]->total_students)? $dtuG1Stds[$l][0]->total_students:'-'}}
			</td>
			<td>
				{{ isset($dtuPStds[$i][0]->total_students)? $dtuPStds[$i][0]->total_students:'-'}}
			</td>
			<td>
				{{ isset($dtuMStds[$j][0]->total_students)? $dtuMStds[$j][0]->total_students:'-'}}
			</td>
			<td>
				{{ isset($dtuHStds[$k][0]->total_students)? $dtuHStds[$k][0]->total_students:'-'}}
			</td>
		</tr>
		<?php $i++; $j++; $k++;$l++; }?>
	@endforeach
	
	</table>
		</td>
		</tr>
		<?php } ?>
	</table>
		
	@endif
	
</div>

{{ HTML::script('assets/js/backend_script.js')}}
@stop