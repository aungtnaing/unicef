@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">

        <li>

        	<a href="javascript:void(0);">Perminent/Temporary Classroom</a>

        </li>

    </ul>

</div>

<div class="box inner-content">

	<div class="row" style='margin:15px auto;'>
		<form action="{{ URL::route('calssroom_list_export') }}" method="post" style="display:inline;" class="form-horizontal">
			@include('students.search_form')&nbsp;
			<input type="submit" id="btnSearch" value="Search" name="btn_search" class="btn btn-success" onclick = "this.form.action='{{ URL::route('calssroom_list') }}'" />
			<input type="submit" class="btn btn-default" id="btnExport" value="Export" />
			
		</form>
	</div><br/>


<?php if(isset($classroom)) { ?>

	<table class="table table-bordered">
		<tr>
			<th colspan="2" ><center>Township Education Management System</center></th>
		</tr>
		<tr>
			<th colspan='2' ><center>Students /Permenent & Temporary Classroom Ratio Report</center></th>
		</tr>
	<?php if(is_array($region)) { ?>
		@foreach($region as $r)
			<tr>
				<th>Division:&nbsp;{{ $r->state_division }}</th>
				<th align='right'>Academic Year:&nbsp;<?php echo (Session::get('academic_year'))? Session::get('academic_year'):Input::get('academic_year'); ?></th>
			</tr>
			<tr>
				<th colspan='2'>Township:&nbsp;<?php if(isset($r->township_name)) { ?> {{ $r->township_name }} <?php } ?></th>
			</tr>
		@endforeach
	<?php } ?>
	
	</table>

	<?php 

		for($i = 0; $i < count($classroom); $i++) {

			if($classroom[$i]->location == "Rural") {
				$rural_level[] = $classroom[$i]->school_level;
			}

			if($classroom[$i]->location == "Urban") {
				$urban_level[] = $classroom[$i]->school_level;
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
			<th>Total Students</th>
			<th>Permanent + Temp Classroom</th>
			<th>Ratio</th>
			<th>School Level ID</th>
		</tr>

		@for($k = 0; $k < count($rural_levels); $k++)	
			@foreach($classroom as $c)
				@if($c->location == "Rural" && $c->school_level == $rural_levels[$k])
					<tr>
						<td><?php echo $rural_levels[$k]; ?></td>
						<td>{{ $totalstd = $c->boys + $c->girls }}</td>

						@foreach($rural_walls as $w)
							@if($w->school_level_id == $c->school_level_id)
								<td>{{ $w->rooms }}</td>

								<td>
								@if($w->rooms)	
									{{ round($totalstd/$w->rooms, 2) }}
								@endif	
								</td>
							@endif
						@endforeach

						<td>{{ $c->school_level_id }}</td>
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
			<th>Permanent + Temp Classroom</th>
			<th>Ratio</th>
			<th>School Level ID</th>
		</tr>

		@for($l = 0; $l < count($urban_levels); $l++)
			@foreach($classroom as $c)
				@if($c->location == "Urban" && $c->school_level == $urban_levels[$l])
					<tr>
						<td><?php echo $urban_levels[$l]; ?></td>
						<td>{{ $totalstd = $c->boys + $c->girls }}</td>

						@foreach($urban_walls as $w)
							@if($w->school_level_id == $c->school_level_id)
								<td>{{ $w->rooms }}</td>

								<td>
								@if($w->rooms)	
									{{ round($totalstd/$w->rooms, 2) }}
								@endif	
								</td>
							@endif
						@endforeach

						<td>{{ $c->school_level_id }}</td>
					</tr>	
				@endif
			@endforeach
		@endfor

	</table>

<?php 
}
	
	if(isset($error)) { echo "<p style='color:#ff0000;font-size:14px;'><b>". $error ."</b></p>"; }


?> 

</div>	

<script type="text/javascript" src="assets/js/backend_script.js"></script>
@stop	