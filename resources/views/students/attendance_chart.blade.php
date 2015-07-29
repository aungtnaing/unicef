@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">
        <li>
            <a href="javascript:void(0);">Attendance < 75%</a>
        </li>
    </ul>

</div>

<div class="box inner-content">
    
    <div class="row" style='margin:15px auto;'>
        <form action="{{ URL::route('StdAttendanceChartList') }}" method="post" style="display:inline;" class="form-horizontal">
            @include('students.search_form')&nbsp;
            <input type="submit" id="btnSearch" value="Submit" name="btn_search" class="btn btn-success" />
        </form>
    </div><br/>

<?php if(isset($RuralChart)) { ?>

<div id="RuralView"></div>

    @piechart('RuralAttendance', 'RuralView') 

<?php } ?>

<?php if(isset($UrbanChart)) { ?>

<div id="UrbanView"></div>

    @piechart('UrbanAttendance', 'UrbanView') 

<?php 
} 

if(isset($error)) { echo "<p style='color:#ff0000;font-size:14px;'><b>". $error ."</b></p>"; }
?>

</div>

<script type="text/javascript" src="assets/js/backend_script.js"></script>
@stop	