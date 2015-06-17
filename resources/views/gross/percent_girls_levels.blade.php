@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">

        <li>

        	<a href="javascript:void(0);">Percentage of Girls in Primary, Middle and High School Levels</a>

        </li>

    </ul>

</div>



<div class="box inner-content">

	<form action="{{ URL::route('ExportPercentGrilLevel') }}" method="post" style="display:inline;" class="form-horizontal">	
		<div class="row" style='margin:15px auto;'>
		
			State/Region&nbsp;
			<select name="state_id" id='region_id' style="width:20%;">

				<option value="">All</option>

				  	@foreach($state as $st)

				    	<option value="{{ $st->id }}">{{ $st->state_division }}</option>

				    @endforeach

			</select>


		Township&nbsp;
			<select name="township_id" id='township_id' style="width:20%;">
				<option value="">All</option>
			</select>
			
		Academic Year&nbsp;
			<select name="academic_year" style="width:20%;">

			  	@foreach($academic as $ac)

			    	<option value="{{ $ac->academic_year }}">{{ $ac->academic_year }}</option>

			    @endforeach

			</select>

	</div>
			<div class="row" style='margin:15px auto;'>
		School Levels&nbsp;
			<select name="school_level" style="width:20%;">
			<option value="All">--All--</option>
			<option value="Primary">Primary</option>
			<option value="Middle">Middle</option>
			<option value="High">High</option>
			</select>	
			
			<input type="submit" class="btn btn-default" id="btnExport" value="Export Excel" />
			<input type="submit" id="btnSearch" value="Search" name="btn_search" class="btn btn-success" onclick = "this.form.action='{{ URL::route('SearchPercentGrilLevel') }}'" />
	</div>
	</form>
	<br/>



	<?php try{ if(isset($region)){	?>
	<table class="table table-bordered">
		<tr>
			<th colspan="2" ><center>Township Education Management System</center></th>
		</tr>
		<tr>
			<th colspan='2'><center>Percentage of Girls In {{$school_level}} Level Report</center></th>
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
	
		
	<?php  }
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
			<th>Percentage of Girls</th>
		</tr>

		@for($row=0;$row<count($tStudents);$row++)
		<?php if($dtSchool[$row]->location == "Rural" && $dtSchool[$row]->school_level == $rural_levels[$k]) { ?>
			<tr>
				<td>{{ $dtSchool[$row]->school_no }}</td>
				<td>{{ $dtSchool[$row]->school_name }}</td>
				<td style="backgroun-color:#ededed">
				<?php
					$total=$tStudents[$row]->total_boy+$tStudents[$row]->total_girl;
					$total_girl=$tStudents[$row]->total_girl;
					if($total_girl!=0)
					{
						$percent=($total_girl/$total) * 100;
						echo $percent." %";
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
		<?php if($dtSchool[$j]->location == "Urban" && $dtSchool[$j]->school_level == $urban_levels[$k]) { ?>
			<tr>
				<td>{{ $dtSchool[$j]->school_no }}</td>
				<td>{{ $dtSchool[$j]->school_name }}</td>
				<td>
				<?php
					$total=$tStudents[$j]->total_boy+$tStudents[$j]->total_girl;
					$total_girl=$tStudents[$j]->total_girl;
					if($total_girl!=0)
					{
						$percent=($total_girl/$total) * 100;
						echo $percent." %";
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

<?php  } 
	if(isset($record))
	{
		echo $record;
	}
}

catch(\Exception $e){
	echo "<br /><table><tr><td style='color:red;font-size:20px;font-weight:bold;'>Please Check Searching!</td></tr></table>";

}

?>

</div>

<script src="assets/js/backend_script.js"></script>
@stop