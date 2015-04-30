<?php

View::composer('students.search_form', function($view) {

	$state = State::orderBy('id','desc')->get();
	
	$academic = Academic::all();

	$view->with(compact('state', 'academic'));

});

View::composer('gross.percent_girls_levels', function($view) {

	$state = State::orderBy('id','desc')->get();
	
	$academic = Academic::all();

	$view->with(compact('state', 'academic'));

});

?>