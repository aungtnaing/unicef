@extends('layouts.base')
@section('content')
<div>

    <ul class="breadcrumb">

        <li>

        	<a href="javascript:void(0);">Type Report</a>

        </li>

    </ul>

</div>



<div class="box inner-content">

	<div class="row" style='margin:15px auto;'>
		<form action="{{ URL::route('TypeReportList') }}" method="post" style="display:inline;">
			@include('students.search_form')
		</form
	</div><br/>
</div>

<?php if(Input::get('btn_search')) { ?>

	<table class="table table-bordered">

	@foreach($region as $r)
		<tr>
			<th>Division:&nbsp;{{ $r->state_division }}</th>
			<th align='right'>Academic Year:&nbsp;<?php echo (Session::get('academic_year'))? Session::get('academic_year'):Input::get('academic_year'); ?></th>
		</tr>
		<tr>
			<th colspan='2'>Township:&nbsp;<?php if(isset($r->township_name)) { ?> {{ $r->township_name }} <?php } ?></th>
		</tr>
	@endforeach
	
	</table>

<?php } ?>	

{{ HTML::script('assets/js/backend_script.js')}}
@stop	