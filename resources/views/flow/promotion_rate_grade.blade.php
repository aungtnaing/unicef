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
		<form action="{{ URL::route('PromotionRateGradeExport') }}" method="post" style="display:inline;" class="form-horizontal">
			<input type = "hidden" name = "previous_year" value="<?php echo Input::get('previous_year'); ?>" id = "previous_year" />
			@include('students.search_prev')
			<input type="submit" id="btnSearch" value="Search" name="btn_search" class="btn btn-success" onclick = "this.form.action='{{ URL::route('PromotionRateGrade') }}'" />
			<input type="submit" class="btn btn-default" id="btnExport" value="Export" />
			
		</form>&nbsp;
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

	@if(isset($new_total) && count($new_total)>0)
	
	<table class="table table-bordered">
		<tr>
			<th>Grade</th>
			<th>Newly promoted students</th>
			<th><div>Number of students</div><div>from the same cohort</div></th>
			<th>Promotion Rate</th>
		</tr>

		@for($i = 0; $i < count($new_total); $i++)
			<tr>
				<td><?php echo "Grade&nbsp;".$new_total[$i]->grade; ?></td>
				<td><?php echo $new_total[$i]->total_students; ?></td>
				<td><?php echo $pre_total[$i]->total_students; ?></td>
				<td><?php echo round(($new_total[$i]->total_students/$pre_total[$i]->total_students)*100, 2); ?></td>
			</tr>
		@endfor
	</table>


@endif
<?php	
	if(isset($error)) { echo "<p style='color:#ff0000;font-size:14px;'><b>". $error ."</b></p>"; } 
?>		
</div>

<script src="assets/js/backend_script.js"></script>

@stop