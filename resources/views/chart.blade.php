@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">

        <li>

        	<a href="javascript:void(0);">Lavachart Test</a>

        </li>

        <div class="box-icon" style='margin-top:-4px;'>
			<a href="#" class="btn btn-setting btn-round"><i class="icon-print"></i></a>
			<a href="#" class="btn btn-minimize btn-round"><i class="icon-print"></i></a>
			<a href="#" class="btn btn-close btn-round"><i class=" icon-download-alt"></i></a>
		</div>

    </ul>

</div>

<div class="box inner-content">
	
<div id="myStocks"></div>
<?php
//echo Lava::render('LineChart', 'myFancyChart', 'myStocks');

// Example #2, have the library create the div
//echo Lava::render('LineChart', 'myFancyChart', 'myStocks', true);

// Example #3, have the library create the div with a fixed size
//echo Lava::render('LineChart', 'myFancyChart', 'myStocks', array('height'=>300, 'width'=>600));

?>

@columnchart('myFancyChart', 'myStocks') 
</div>	
@stop	