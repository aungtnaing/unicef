<?php 
namespace App\Providers;

use View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\DB;

class ComposerServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
		View::composer('students.search_form', function($view) {

			$state = DB::select('select * from state_division');
			
			$town = DB::select('select * from township');
			
			$academic = DB::select('select * from academicyear');

			$view->with(compact('state', 'academic', 'town'));
		
		});
		
		View::composer('students.level_form', function($view) {

			$level = DB::select('select * from school_level');
			
			$view->with(compact('level'));
		
		});
	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'App\Services\Registrar'
		);
	}

}
