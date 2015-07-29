@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">

        <li>

        	<a href="javascript:void(0);">Dropout Rate</a>

        </li>

<!--         <div class="box-icon" style='margin-top:-4px;'>
			<a href="#" class="btn btn-setting btn-round"><i class="icon-print"></i></a>
			<a href="#" class="btn btn-minimize btn-round"><i class="icon-print"></i></a>
			<a href="#" class="btn btn-close btn-round"><i class=" icon-download-alt"></i></a>
		</div> -->

    </ul>

</div>

<div class="box inner-content">

	<div class="row" style='margin:15px auto;'>
		<form action="{{ URL::route('dropout_rate_list_export') }}" method="post" style="display:inline;" class="form-horizontal">
			<input type = "hidden" name = "previous_year" value="<?php echo Input::get('previous_year'); ?>" id = "previous_year" />
			@include('students.search_prev')&nbsp;
			<input type="submit" id="btnSearch" value="Search" name="btn_search" class="btn btn-success" onclick = "this.form.action='{{ URL::route('dropout_rate_list') }}'" />
			<input type="submit" class="btn btn-default" id="btnExport" value="Export" />
		</form>
	</div><br/>

<?php

 if(isset($new_total)) { ?>

	<table class="table table-bordered">
		<tr>
			<th colspan="2" ><center>Township Education Management System</center></th>
		</tr>
		<tr>
			<th colspan='2' ><center>Dropout Rate Report</center></th>
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

	<table class="table table-bordered">
		<tr>
			<th>Grade</th>
			<th>Promotion Rate</th>
			<th>Repetition Rate</div></th>
			<th>Dropout Rate</th>
		</tr>

		<?php 
			for($i = 0; $i < count($new_total); $i++) {
		?>		
			<tr>
				<td>Grade&nbsp;<?php echo $new_total[$i]->grade; ?> - Grade&nbsp;<?php echo $repeater[$i]->grade; ?></td>
				<td><?php echo $Promotion = round(($new_total[$i]->total_students/$pre_total[$i]->total_students) * 100, 2); ?></td>
				<td><?php echo $Repetition = round(($repeater[$i]->repeaters/$total_std[$i]->students) * 100, 2); ?></td>
				<td><?php echo $Promotion - $Repetition; ?></td>
			</tr>	
		
		<?php } ?>
	</table>



<?php }

if(isset($error)) { echo "<p style='color:#ff0000;font-size:14px;'><b>". $error ."</b></p>"; }
?>
</div>	

<script src="assets/js/backend_script.js"></script> 
@stop	