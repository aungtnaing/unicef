@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">
        <li>
            <a href="javascript:void(0);">Percentage of Grade One Intake Report by Chart</a>
        </li>
    </ul>

</div>

<div class="box inner-content">
    
    <div class="row" style='margin:15px auto;'>
        <form action="{{ URL::route('grade_one_intake_list') }}" method="post" style="display:inline;" class="form-horizontal">
            @include('students.search_form')&nbsp;
            <input type="submit" id="btnSearch" value="Submit" name="btn_search" class="btn btn-success" />
        </form>
    </div><br/>

<?php if(isset($RuralChart)) { ?>

<div id="RuralView"></div>

    @piechart('RuralPercentage', 'RuralView') 

<?php } ?>

<?php if(isset($UrbanChart)) { ?>

<div id="UrbanView"></div>

    @piechart('UrbanPercentage', 'UrbanView') 

<?php 
} 

if(isset($error)) { echo "<p style='color:#ff0000;font-size:14px;'><b>". $error ."</b></p>"; }
?>

</div>

<script type="text/javascript" src="assets/js/backend_script.js"></script>
@stop	