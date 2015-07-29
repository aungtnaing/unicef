@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">

        <li>

        	<a href="javascript:void(0);">Sanitation</a>

        </li>

    </ul>

</div>

<div class="box inner-content">

	<div class="row" style='margin:15px auto;'>
		<form action="{{ URL::route('SearchStdSanitation_excel')}}" method="post" style="display:inline;" class="form-horizontal">
			@include('students.search_form')&nbsp;
			<input type="submit" id="btnSearch" value="Search" name="btn_search" class="btn btn-success" onclick = "this.form.action='{{ URL::route('SearchStdSanitation') }}'" />
			<input type="submit" class="btn btn-close btn-round" id="btnExport" value="Export" />
		</form>&nbsp;
	</div><br/>


	<?php //try {
		if(isset($region)) { ?>
	<table class="table table-bordered">
		<tr>
			<th colspan="2" ><center>Township Education Management System</center></th>
		</tr>
		<tr>
			<th colspan='2'><center>Sanitation/Students Ratio Report</center></th>
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
	<php } ?>
		
	<?php 
		if(count($dtSchool)){
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
			<th colspan="5"></th>
			<th	colspan="3">Sanitation</th>
			<th colspan="3">Water</th>
		</tr>
		<tr>
			<th>School No.</th>
			<th>School Name</th>
			<th>Total Latrines</th>
			<th>Total Good Latrines</th>
			<th>Total Students</th>
			<th>Ratio Total Latrine</th>
			<th>Ratio Total Good Latrine</th>
			<th>Rank</th>
			<th>Availability</th>
			<th>Quality</th>
			<th>Safe to Drink</th>
			
		</tr>

		@for($row=0;$row<count($dtSchool);$row++)
		<?php if($dtSchool[$row]->location == "Rural" && $dtSchool[$row]->school_level == $rural_levels[$k]) { 
				//if ($row<count($tStudents) && $row<count($tLatrine)) {
				$total_latrine=$dtSchool[$row]->latrine_totalboy+$dtSchool[$row]->latrine_totalgirl+$dtSchool[$row]->latrine_totalboth;

				$total_good_latrine=$total_latrine-$dtSchool[$row]->latrine_repair_boy+$dtSchool[$row]->latrine_repair_girl+$dtSchool[$row]->latrine_repair_both;

			?>
			<tr>
				<td>{{ $dtSchool[$row]->school_no }}</td>
				<td>{{ $dtSchool[$row]->school_name }}</td>
				<td>{{ $total_latrine }}</td>
				<td>{{ $total_good_latrine }}</td>
				<td>{{ $dtSchool[$row]->total_students }}</td>
				<td style="backgroun-color:#ededed">{{ ($total_latrine!=0 )? round($dtSchool[$row]->total_students / $total_latrine,2) :'0' }}</td>
				<td style="backgroun-color:#ededed">{{ ($total_good_latrine)? round($dtSchool[$row]->total_students / $total_good_latrine,2) : '0' }} </td>
				<td>
					<?php
						$LatrineRatio=($total_latrine!=0 )? round($dtSchool[$row]->total_students / $total_latrine,2) :'0';
						$GLatrineRatio=($total_good_latrine)? round($dtSchool[$row]->total_students / $total_good_latrine,2) : '0';
					
					 if ($LatrineRatio <= 50 && $GLatrineRatio <= 50)
					 {
					 	echo "A";
					 }                        
                     else if ($LatrineRatio <= 50 || $GLatrineRatio <= 50)
                     {
                     	echo "B";
                     }	
                     else
                     {
                     	echo "C";
                     }
                        
				?>
				</td>
				<td>
					<?php
						if ($dtSchool[$row]->enough_whole_year + $dtSchool[$row]->enough_other_use ==2) 
						{
							echo "A";
						}
						elseif ($dtSchool[$row]->enough_whole_year+$dtSchool[$row]->enough_other_use==1) 
						{
							echo "B";
						}
						else
						{
							echo "C";
						}
					?>	
				</td>
				<td>
				<?php
					if ($dtSchool[$row]->quality=="Tube Well" || $dtSchool[$row]->quality=="Piped") {
						echo "A";
					}
					elseif ($dtSchool[$row]->quality=="Well" || $dtSchool[$row]->quality=="Hand Pump") {
						echo "B";
					}
					elseif ($dtSchool[$row]->quality=="Rain") {
						echo "C";
					}
					elseif ($dtSchool[$row]->quality=="Pond" || $dtSchool[$row]->quality=="River") {
						echo "D";
					}
					elseif ($dtSchool[$row]->quality=="Bottled/ Tank water") {
						echo "E";
					}
					elseif ($dtSchool[$row]->quality=="No") {
						echo "F";
					}
				?>

				</td>
				<td>
					<?php
						if ($dtSchool[$row]->safe_to_drink=='1') 
						{
							echo "Yes";
						}
						else
						{
							echo "No";
						}
						
					?>
				

				</td>
			</tr>	
				
				
		<?php }//} ?> 
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
			<th colspan="5"></th>
			<th	colspan="3">Sanitation</th>
			<th colspan="3">Water</th>
		</tr>
		<tr>
			<th>School No.</th>
			<th>School Name</th>
			<th>Total Latrines</th>
			<th>Total Good Latrines</th>
			<th>Total Students</th>
			<th>Ratio Total Latrine</th>
			<th>Ratio Total Good Latrine</th>
			<th>Rank</th>
			<th>Availability</th>
			<th>Quality</th>
			<th>Safe to Drink</th>
			
		</tr>

		@for($j=0;$j<count($dtSchool);$j++)
		<?php if($dtSchool[$j]->location == "Urban" && $dtSchool[$j]->school_level == $urban_levels[$k]) { 
			//if ($j<count($tStudents) && $j<count($tLatrine)) {
			$total_latrine=$dtSchool[$j]->latrine_totalboy+$dtSchool[$j]->latrine_totalgirl+$dtSchool[$j]->latrine_totalboth;

				
				$total_good_latrine=$total_latrine-$dtSchool[$j]->latrine_repair_boy+$dtSchool[$j]->latrine_repair_girl+$dtSchool[$j]->latrine_repair_both;
			?>	
			<tr>
				<td>{{ $dtSchool[$j]->school_no }}</td>
				<td>{{ $dtSchool[$j]->school_name }}</td>
				<td>{{ $total_latrine }}</td>
				<td>{{ $total_good_latrine }}</td>
				<td>{{ $dtSchool[$j]->total_students }}</td>
				<td style="backgroun-color:#ededed">{{ ($total_latrine!=0 )? round($dtSchool[$j]->total_students / $total_latrine,2) :'0' }}</td>
				<td style="backgroun-color:#ededed">{{ ($total_good_latrine)? round($dtSchool[$j]->total_students / $total_good_latrine,2) : '0' }} </td>
				<td>
					<?php
						$LatrineRatio=($total_latrine!=0 )? round($dtSchool[$j]->total_students / $total_latrine,2) :'0';
						$GLatrineRatio=($total_good_latrine)? round($dtSchool[$j]->total_students / $total_good_latrine,2) : '0';
					
					 if ($LatrineRatio <= 50 && $GLatrineRatio <= 50)
					 {
					 	echo "A";
					 }                        
                     else if ($LatrineRatio <= 50 || $GLatrineRatio <= 50)
                     {
                     	echo "B";
                     }	
                     else
                     {
                     	echo "C";
                     }
                   ?>
				</td>
				<td>
					<?php
						if ($dtSchool[$j]->enough_whole_year + $dtSchool[$j]->enough_other_use ==2) 
						{
							echo "A";
						}
						elseif ($dtSchool[$j]->enough_whole_year+$dtSchool[$j]->enough_other_use==1) 
						{
							echo "B";
						}
						else
						{
							echo "C";
						}
					?>	
				</td>
				<td>
					<?php
					if ($dtSchool[$j]->quality=="Tube Well" || $dtSchool[$j]->quality=="Piped") {
						echo "A";
					}
					elseif ($dtSchool[$j]->quality=="Well" || $dtSchool[$j]->quality=="Hand Pump") {
						echo "B";
					}
					elseif ($dtSchool[$j]->quality=="Rain") {
						echo "C";
					}
					elseif ($dtSchool[$j]->quality=="Pond" || $dtSchool[$j]->quality=="River") {
						echo "D";
					}
					elseif ($dtSchool[$j]->quality=="Bottled/ Tank water") {
						echo "E";
					}
					elseif ($dtSchool[$j]->quality=="No") {
						echo "F";
					}
				?>
				</td>
				<td>
					<?php
						if ($dtSchool[$j]->safe_to_drink=='1') 
						{
							echo "Yes";
						}
						else
						{
							echo "No";
						}
						
					?>
				

				</td>
			</tr>	
		<?php } ?> 
		@endfor

	</table>

<?php } ?>

<?php  } 
	
}
else{
		if(isset($record)){
			echo "<p style='color:#ff0000;font-size:14px;'><b>".$record."</b></p>";
		}
		
	}

	?>
</div>

<script src="assets/js/backend_script.js"></script>
@stop