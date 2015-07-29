<?php 

namespace App\Http\Controllers;

class TestExportExcel extends Controller{
	
	public function getColumnNames($object) {

		$rip_headers = $object->toArray();

		$keys = array_keys($rip_headers[0]);

		foreach ($keys as $value) {
			$headers[$value] = $value;
		}

		return array($headers);
	}
	public function export () {
	
		$headers=array();
		$posts = Country::all();
		$headers = $this->getColumnNames($posts);		
		$posts_array = array_merge((array)$headers, (array)$posts->toArray());
		
		Excel::create('Document', function($excel) use($posts_array) {
			$excel->sheet('Sheet', function($sheet) use($posts_array){
			
				$sheet->fromArray($posts_array);
        });
		})->export('xlsx');

	}
	
	public function import()
	{
		
	}	
	
}