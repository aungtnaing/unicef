@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">

        <li>

        	<a href="javascript:void(0);">Pupil/Teacher Ratio by chart</a>

        </li>

    </ul>

</div>

<div class="box inner-content">

	<div class="row" style='margin:15px auto;'>
		<form action="{{ URL::route('TeacherRatioChartList') }}" method="post" class="form-horizontal">
			@include('students.search_form')&nbsp;
			<input type="submit" id="btnSearch" value="Submit" name="btn_search" class="btn btn-success" />
		</form>	
	</div>
	
<?php if(isset($RuralChart)) { ?>

<!-- Stat Rural -->
<div id="RuralChart"></div>

    @columnchart('RuralTeacher', 'RuralChart') 

<?php 
} 

if(isset($error)) { echo "<p style='color:#ff0000;font-size:14px;'><b>". $error ."</b></p>"; }
?>
</div>

<script src="assets/js/backend_script.js"></script>
@stop