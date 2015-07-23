@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">

        <li>

        	<a href="javascript:void(0);">Percentage of Schools with Library</a>

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
		<form action="{{ URL::route('percentage_school_library_export') }}" method="post" style="display:inline;" class="form-horizontal">
			@include('students.search_form')&nbsp;
			<input type="submit" id="btnSearch" value="Search" name="btn_search" class="btn btn-success" onclick = "this.form.action='{{ URL::route('percentage_school_library_list') }}'" />
			<input type="submit" class="btn btn-default" id="btnExport" value="Export" />
		</form>
	</div><br/>

<?php if(isset($total_std)) { ?>

	<table class="table table-bordered">
		<tr>
			<th colspan="2" ><center>Township Education Management System</center></th>
		</tr>
		<tr>
			<th colspan='2' ><center>Percentage of Schools with Library Report</center></th>
		</tr>
	<?php if(is_array($region)) { ?>
		@foreach($region as $r)
			<tr>
				<th>Division:&nbsp;{{ $r->state_division }}</th>
				<th align='right'>Academic Year:&nbsp;<?php echo Input::get('academic_year'); ?></th>
			</tr>
			<tr>
				<th colspan='2'>Township:&nbsp;<?php if(isset($r->township_name)) { ?> {{ $r->township_name }} <?php } ?></th>
			</tr>
		@endforeach
	<?php } ?>
	
	</table>

	<?php 
		if (isset($total_std) && count($total_std)>0) {
			for($i = 0; $i < count($total_std); $i++) {

			if($total_std[$i]->location == "Rural") {
				$rural_level[] = $total_std[$i]->school_level;
			}

			if($total_std[$i]->location == "Urban") {
				$urban_level[] = $total_std[$i]->school_level;
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
	
	<table class="table table-bordered">
		<tr>
			<th>School Level</th>
			<th><div>No. of Schools</div><div> with Library</div></th>
			<th><div>Total School</div></th>
			<th><div>Percentage of Schools</div><div>with Library</div></th>
		</tr>

		@for($k = 0; $k < count($rural_levels); $k++)
		@foreach($total_std as $std)
			@foreach($library as $lib)
				
				<?php 
					if($std->location == "Rural" && $lib->location == "Rural" && $std->school_level == $rural_levels[$k]) { 
						if($std->school_level == $lib->school_level) {	
				?>

					<tr>
						<td><?php echo $rural_levels[$k]; ?></td>
						<td>{{ $lib->school_library }}</td>
						<td>{{ $std->total_school }}</td>
						<td><?php echo ($lib->school_library/$std->total_school) * 100; ?></td>
					</tr>	
				
				<?php }} ?> 
			
			@endforeach
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
			<th><div>No. of Schools</div><div> with Library</div></th>
			<th><div>Total School</div></th>
			<th><div>Percentage of Schools</div><div>with Library</div></th>
		</tr>

		@for($l = 0; $l < count($urban_levels); $l++)
		@foreach($total_std as $std)
			@foreach($library as $lib)
				
				<?php 
					if($std->location == "Urban" && $lib->location == "Urban" && $std->school_level == $urban_levels[$l]) { 
						if($std->school_level == $lib->school_level) {	
				?>

					<tr>
						<td><?php echo $urban_levels[$l]; ?></td>
						<td>{{ $lib->school_library }}</td>
						<td>{{ $std->total_school }}</td>
						<td><?php echo ($lib->school_library/$std->total_school) * 100; ?></td>
					</tr>	
				
				<?php }} ?> 
			
			@endforeach
		@endforeach
		@endfor
	</table>

<?php 
}} 
if(isset($record)) echo $record;
?>

</div>	

<script src="assets/js/backend_script.js"></script>
@stop	