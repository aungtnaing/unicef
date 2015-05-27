<?php

class ExcelImportController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		//
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{

		/*$file_name = Input::file('my_file')->getClientOriginalName();

         $upload_success = Input::file('my_file')->move('imports', $file_name);

         $excelChecker = Excel::selectSheetsByIndex(1)->load($upload_success, function($reader){})->get()->toArray();

         print_r($excelChecker);*/
		
		$upload_success = Input::file('my_file')->move('imports', Input::file('my_file'));
		$reader = Excel::load($upload_success)->get();
	
		$excelChecker = Excel::selectSheetsByIndex(3)->load($upload_success, function($reader){})->get()->toArray();
		
		print_r($excelChecker);

	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}


}
