@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">

        <li>

        	<a href="javascript:void(0);">Net Intake Rate(NIR)</a>

        </li>

    </ul>

</div>



<div class="box inner-content">

	<div class="row" style='margin:15px auto;'>
		<form action="" method="post" style="display:inline;" class="form-horizontal">
			@include('students.search_form')&nbsp;
			<input type="submit" id="btnSearch" value="Search" name="btn_search" class="btn btn-success" onclick = "this.form.action='{{ URL::route('TypeReportList') }}'" />
			<input type="submit" class="btn btn-close btn-round" id="btnExport" value="Export Excel" />
		</form>&nbsp;<!-- <a href="#">View All</a> -->
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
			<th align='right'>Academic Year:&nbsp;<?php echo (Session::get('academic_year'))? Session::get('academic_year'):Input::get('academic_year'); ?></th>
		</tr>
		<tr>
			<th colspan='2'>Township:&nbsp;<?php if(isset($Ir->township_name)) { ?> {{ $r->township_name }} <?php } ?></th>
		</tr>
	@endforeach
	</table>
	@endif
	<?php 
		if (isset($record)) {
			echo $record;
		}

	 ?>

		
</div>

<script type="text/javascript" src="assets/js/backend_script.js"></script>
@stop