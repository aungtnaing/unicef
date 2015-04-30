<?php
class UserListImport extends \Maatwebsite\Excel\Files\ExcelFile {

    public function save()
    {
        
        /*$cover = Input::file('my_file')->getClientOriginalName();
        $upload_success = Input::file('my_file')->move('imports', $cover);
        
        $reader = Excel::load($upload_success)->get();

            $first = $reader->toArray();

            foreach ($reader as $row) {
                $r = $row->toArray();
            }

            Country::insert($r);*/

            $file = Input::file('my_file');
            $files = getFile($file);

            // Return it's location
            echo "Get File - ". $files;
    
    }

    public function getFile($file) {

        
        $filename = $this->doSomethingLikeUpload($file);

        return $filename;
    }

}