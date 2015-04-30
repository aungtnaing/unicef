<?php

class ImportExcelController extends \BaseController {
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
		
		$cover = Input::file('my_file');

		foreach($cover as $key => $all ){
            
            $file_name = $all->getClientOriginalName();

            $upload_success = $all->move('imports', $file_name);
		
			$reader = Excel::load($upload_success)->get();

            $result[] = $reader->toArray();

            echo $file_name;
            echo "<hr/>";
 
        }

        /*print_r($result[0]);
		echo "<hr/>";
		print_r($result[1][0]);
		echo "<hr/>";
		print_r($result[1][1]);*/

		/*City::insert($result[0]);
		Country::insert($result[1][0]);
		Profile::insert($result[1][1]);*/

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
