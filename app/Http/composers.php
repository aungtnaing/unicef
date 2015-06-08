<?php

View::composer('students.search_form', function($view) {

	$state = DB::select('select * from state_division'); //State::orderBy('id','desc')->get();

	
	$academic = DB::select('select * from academicyear'); //Academic::all();

	$view->with(compact('state', 'academic'));

});

/*View::composer('gross.percent_girls_levels', function($view) {

	$state = State::orderBy('id','desc')->get();
	
	$academic = Academic::all();

	$view->with(compact('state', 'academic'));

});

View::composer('students.level_form', function($view) {

	$level = Level::orderBy('id','asc')->get();
	
	$view->with(compact('level'));

});*/

?>