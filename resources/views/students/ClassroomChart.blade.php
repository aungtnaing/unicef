@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">

        <li>

        	<a href="javascript:void(0);">Perminent/Temporary Classroom With Chart</a>

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

<!-- Stat Rural -->
<table class="table table-bordered">
    <tr style="background:#DFF0D8;">
        <th><center>Location: Rural</center></th>
    </tr>
</table>

<div id="RuralChart"></div>

    @columnchart('Classes', 'RuralChart') 

<?php } ?>
<br/><br/>

<?php if(isset($UrbanChart)) { ?>

<!-- Stat Urban -->
<table class="table table-bordered">
    <tr style="background:#DFF0D8;">
        <th><center>Location: Urban</center></th>
    </tr>
</table>

<div id="UrbanChart"></div>

    @columnchart('UrbanClasses', 'UrbanChart') 

<?php } ?>

</div>
<script type="text/javascript" src="assets/js/backend_script.js"></script>
@stop	