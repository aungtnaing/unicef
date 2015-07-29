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
		<form action="{{ URL::route('NetIntakeRateExport') }}" method="post" style="display:inline;" class="form-horizontal">
			@include('students.search_form')&nbsp;
			<input type="submit" id="btnSearch" value="Search" name="btn_search" class="btn btn-success" onclick = "this.form.action='{{ URL::route('NetIntakeRateNIR') }}'" />
			<input type="submit" class="btn btn-close btn-round" id="btnExport" value="Export" />
		</form>&nbsp;<!-- <a href="#">View All</a> -->
	</div><br/>



	@if(isset($region))	
	<table class="table table-bordered">
		<tr>
			<th colspan="2" ><center>Township Education Management System</center></th>
		</tr>
		<tr>
			<th colspan='2'><center>Net Intake Rate Report</center></th>
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
	<?php if(isset($total_intake_one)) { 
		
		?>
	<table class="table table-bordered">
		<tr>
			<th>School Levels</th>
			<th>Ratio</th>
		</tr>
		
		@for($i=0;$i<count($total_intake_one);$i++)
		<tr>
			<td>{{ $total_intake_one[$i]->school_level }}</td>
			<td>
				<?php 
					if($total_intake_one[$i]->total_grade_one!=0 && $total_intake_one[$i]->total_grade_one!='' && $total_populations_5[0]->total_pop!=0)
					{
						echo round(($total_intake_one[$i]->total_grade_one/$total_populations_5[0]->total_pop)*100,2);
					}
					else if($total_intake_one[$i]->total_grade_one==0 && $total_intake_one[$i]->total_grade_one=='' && $total_populations_5[0]->total_pop==0)
					{
						echo "There is no records for grade one records and population aged 5!";
					}
					else if($total_intake_one[$i]->total_grade_one!=0 && $total_intake_one[$i]->total_grade_one!='')
					{
						echo "There is no records for stuent total grade one record in this school level";
					}
					else
					{
						echo "There is no records for population at aged 5.";
					}
				?>	
			</td>
		</tr>	
		@endfor
	</table> 
	

<?php 		}
	if(isset($error)) { echo "<p style='color:#ff0000;font-size:14px;'><b>". $error ."</b></p>"; }
	?>
			
</div>

<script type="text/javascript" src="assets/js/backend_script.js"></script>
@stop