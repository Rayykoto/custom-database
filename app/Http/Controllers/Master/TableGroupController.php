<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TableGroupController extends Controller
{
    public function add(Request $request)
    {
        $field_name = str_replace(' ', '',strtolower($request->name));
        //dd($field_name);
		$description 	= 'master_tablegroup';

		$query = DB::insert("INSERT INTO $description (`name`,`description`,`is_show`) VALUES ('$field_name','$request->name','1')");

        if ($query){
            return redirect('/dashboard');
        }
    }

    public function manage(Request $request){
		$description 	= 'master_tablegroup';
        function IsChecked($chkname,$value){
            if(!empty($_POST[$chkname]))
            {
                foreach($_POST[$chkname] as $chkval)
                {
                    if($chkval == $value)
                    {
                        return true;
                    }
                }
            }
            return false;
        }
        function searchJawabanbyId($id, $array) {
            foreach ($array as $key => $val) {
                if ($val['field_name'] === $id) {
                    return $val['is_show'];
                }
            }
            return null;
         }
        $myjawab  = array();
        $query	 = DB::table($description)->get();
        foreach ($query as $i => $row) {
            if(IsChecked('show_group',$row->name)){
                $show_selector = '1';
            } else {
                $show_selector = '0';
            }
            $myjawab[] = array(
                "field_name"        => $row->name,
                "is_show"           => $show_selector
            );
        }

        $result  = array();
			$queryin	 = DB::table($description)->get();
			foreach ($queryin as $i => $row)
			{
				$result[] = array(
				"field_name"		=> $row->name,
				"is_show"			=> searchJawabanbyId($row->name, $myjawab)
				);
			}
            //dd($result);
        for ($i = 0; $i < count($result); $i++){
            $fields     = $result[$i]["field_name"];
            $is_show    = $result[$i]["is_show"];
            $query = "UPDATE $description SET `is_show`='$is_show' WHERE `name`='$fields';";

            DB::statement($query);
        }
        return back()->with('success', 'Data Edited');
    }
}
