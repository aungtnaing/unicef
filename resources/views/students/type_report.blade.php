@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">

        <li>

        	<a href="javascript:void(0);">Type Report</a>

        </li>

        <div class="box-icon" style='margin-top:-4px;'>
			<a href="#" class="btn btn-setting btn-round"><i class="icon-print"></i></a>
			<a href="#" class="btn btn-minimize btn-round"><i class="icon-print"></i></a>
			<a href="#" class="btn btn-close btn-round"><i class=" icon-download-alt"></i></a>
		</div>

    </ul>

</div>

<div class="box inner-content">

	<div class="row" style='margin:15px auto;'>
		<form action="{{ URL::route('type_report_export') }}" method="post" id="TypeReportForm" style="display:inline;" class="form-horizontal">
			@include('students.search_form')&nbsp;
			<input type="submit" id="btnSearch" value="Search" name="btn_search" class="btn btn-success" onclick = "this.form.action='{{ URL::route('TypeReportList') }}'" />
			<input type="submit" class="btn btn-close btn-round" id="btnExport" value="Export Excel" />
		</form>
	</div><br/>

<?php if(isset($type_report)) { ?>

	<table class="table table-bordered">
		<tr>
			<th colspan="2" ><center>Township Education Management System</center></th>
		</tr>
		<tr>
			<th colspan='2' ><center>No of School by School Type, Urban/Rual Report</center></th>
		</tr>
	@foreach($region as $r)
		<tr>
			<th>Division:&nbsp;{{ $r->state_division }}</th>
			<th align='right'>Academic Year:&nbsp;<?php echo (Session::get('academic_year'))? Session::get('academic_year'):Input::get('academic_year'); ?></th>
		</tr>
		<tr>
			<th colspan='2'>Township:&nbsp;<?php if(isset($r->township_name)) { ?> {{ $r->township_name }} <?php } ?></th>
		</tr>
	@endforeach
	
	</table>

	<?php

		$total = ""; 

		for($i = 0; $i < count($type_report); $i++) {

			if($type_report[$i]->location == "Rural") {
				$rural_level[] = $type_report[$i]->school_level;
			}

			if($type_report[$i]->location == "Urban") {
				$urban_level[] = $type_report[$i]->school_level;
			}

			$total += (int)$type_report[$i]->TotalSchools;

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
	
	<table class="table table-bordered">
		<tr>
			<th>School Level</th>
			<th>Total Schools</th>
		</tr>

		@for($k = 0; $k < count($rural_levels); $k++)	
			@foreach($type_report as $tr)
				@if($tr->location == "Rural" && $tr->school_level == $rural_levels[$k])
					<tr>
						<td><?php echo $rural_levels[$k]; ?></td>
						<td>{{ $tr->TotalSchools }}</td>
					</tr>	
				@endif 
			@endforeach
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
			<th>School Level</th>
			<th>Total Schools</th>
		</tr>

		@for($l = 0; $l < count($urban_levels); $l++)
			@foreach($type_report as $tr)
				@if($tr->location == "Urban" && $tr->school_level == $urban_levels[$l])
					<tr>
						<td><?php echo $urban_levels[$l]; ?></td>
						<td>{{ $tr->TotalSchools }}</td>
					</tr>	
				@endif
			@endforeach
		@endfor

	</table>

	<table class="table table-bordered">
		<tr>
			<th>Total:</th>
			<th><?php echo $total; ?></th>
		</tr>
	</table>	
	
<?php } ?>
</div>	

<script src="assets/js/backend_script.js"></script>
@stop	