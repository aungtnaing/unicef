@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">

        <li>

        	<a href="javascript:void(0);">Perminent/Temporary Classroom by Chart</a>

        </li>

       <!--  <div class="box-icon" style='margin-top:-4px;'>
			<a href="#" class="btn btn-setting btn-round"><i class="icon-print"></i></a>
			<a href="#" class="btn btn-minimize btn-round"><i class="icon-print"></i></a>
			<a href="#" class="btn btn-close btn-round"><i class=" icon-download-alt"></i></a>
		</div> -->

    </ul>

</div>

<div class="box inner-content">
    
    <div class="row" style='margin:15px auto;'>
        <form action="{{ URL::route('classroom_chart_list') }}" method="post" style="display:inline;" class="form-horizontal">
            @include('students.search_form')&nbsp;
            <input type="submit" id="btnSearch" value="Submit" name="btn_search" class="btn btn-success" />
        </form>
    </div><br/>

<?php if(isset($RuralChart)) { ?>

<div id="RuralChart"></div>

    @columnchart('Classes', 'RuralChart') 

<?php 
} 

if(isset($error)) { echo "<p style='color:#ff0000;font-size:14px;'><b>". $error ."</b></p>"; }
?>

</div>
<script type="text/javascript" src="assets/js/backend_script.js"></script>
@stop	