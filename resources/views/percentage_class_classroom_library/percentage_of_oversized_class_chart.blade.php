@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">
        <li>
            <a href="javascript:void(0);">Percentage of Oversized Classes (Sections with Over 40 Pupils) Report by Chart</a>
        </li>
    </ul>

</div>

<div class="box inner-content">
    
    <div class="row" style='margin:15px auto;'>
        <form action="{{ URL::route('oversize_class_chart_list') }}" method="post" style="display:inline;" class="form-horizontal">
            @include('students.search_form')&nbsp;
            <input type="submit" id="btnSearch" value="Submit" name="btn_search" class="btn btn-success" />
        </form>
    </div><br/>

<?php if(isset($RuralChart)) { ?>

<div id="RuralView"></div>

    @piechart('RuralOversizeClasses', 'RuralView') 

<?php } ?>

<?php if(isset($UrbanChart)) { ?>

<div id="UrbanView"></div>

    @piechart('UrbanOversizeClasses', 'UrbanView') 

<?php 
} 

if(isset($error)) { echo "<p style='color:#ff0000;font-size:14px;'><b>". $error ."</b></p>"; }
?>

</div>

<script type="text/javascript" src="assets/js/backend_script.js"></script>
@stop	