<?php namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Khill\Lavacharts\Lavacharts;
use Lava;
use Illuminate\Http\Request;

class ChartController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$lava = new Lavacharts; // See note below for Laravel

		$finances = Lava::DataTable();

		$finances->addDateColumn('Year')
		         ->addNumberColumn('Sales')
		         ->addNumberColumn('Expenses')
		         ->setDateTimeFormat('Y')
		         ->addRow(array('2004', 1000, 400))
		         ->addRow(array('2005', 1170, 460))
		         ->addRow(array('2006', 660, 1120))
		         ->addRow(array('2007', 1030, 54));

		$columnchart = Lava::ColumnChart('Finances')
		                    ->setOptions(array(
			                       'datatable' => $finances,
			                       'title' => 'Company Performance',
			                       'titleTextStyle' => Lava::TextStyle(array(
			                       'color' => '#eb6b2c',
			                       'fontSize' => 14
		                    	))
		                    ));
		
		return view('chart', compact('columnchart'));
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{	
		$stocksTable = Lava::DataTable();

		$stocksTable->addDateColumn('Day of Month')
            ->addNumberColumn('Projected')
            ->addNumberColumn('Official');

        // Random Data For Example
		for ($a = 1; $a < 30; $a++)
		{
		    $rowData = array(
		      "2014-8-$a", rand(800,1000), rand(800,1000)
		    );

		    $stocksTable->addRow($rowData);
		}    

		$chart = Lava::ColumnChart('myFancyChart');
		$chart->datatable($stocksTable);

		//dd($stocksTable);
		//echo "<br/><br/>";
		//dd($chart);
		return view('chart', compact('chart'));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
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
