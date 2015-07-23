@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">

        <li>

        	<a href="javascript:void(0);">Repetition Rate</a>

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
		<form action="{{ URL::route('repetition_rate_export') }}" method="post" style="display:inline;" class="form-horizontal">
			<input type = "hidden" name = "previous_year" value="<?php echo Input::get('previous_year'); ?>" id = "previous_year" />
			@include('students.search_prev')&nbsp;
			<input type="submit" id="btnSearch" value="Search" name="btn_search" class="btn btn-success" onclick = "this.form.action='{{ URL::route('repetition_rate_list') }}'" />
			<input type="submit" class="btn btn-default" id="btnExport" value="Export" />
		</form>
	</div><br/>

<?php if(isset($repeater)) { ?>

	<table class="table table-bordered">
		<tr>
			<th colspan="2" ><center>Township Education Management System</center></th>
		</tr>
		<tr>
			<th colspan='2' ><center>Repetition Rate Report</center></th>
		</tr>
	<?php if(is_array($region)) { ?>
		@foreach($region as $r)
			<tr>
				<th>Division:&nbsp;{{ $r->state_division }}</th>
				<th align='right'>Academic Year:&nbsp;<?php echo Input::get('academic_year'); ?></th>
			</tr>
			<tr>
				<th colspan="2">Township:&nbsp;<?php if(isset($r->township_name)) { ?> {{ $r->township_name }} <?php } ?></th>
			</tr>
		@endforeach
	<?php } ?>
	
	</table>

	<?php if(isset($repeater) && count($repeater)>0) { ?>

<!-- Stat Rural -->
	
	<table class="table table-bordered">
		<tr>
			<th>Grade</th>
			<th><div>No. of Repeaters</div><div>in current year <?php echo Input::get('academic_year'); ?></div></th>
			<th><div>No. of Students</div><div>in previous year <?php echo Input::get('previous_year'); ?></div></th>
			<th>Repetition Rate</th>
		</tr>

		@foreach($repeater as $r)
			@foreach($total_std AS $std)
		<?php 
			if($r->grade == $std->grade) {	
		?>
			<tr>
				<td>Grade&nbsp;{{ $r->grade }}</td>
				<td>{{ $r->repeaters }}</td>
				<td>{{ $std->students }}</td>
				<td><?php echo round(($r->repeaters/$std->students) * 100, 2) . "%"; ?></td>
			</tr>	
		<?php } ?>
			@endforeach
		@endforeach

	</table>

<?php 
	} else{

		echo "<h4> There is no data record.</h4>";
	}
}

	if(isset($record)) echo $record;	
?>

</div>	

<script src="assets/js/backend_script.js"></script> 
@stop	