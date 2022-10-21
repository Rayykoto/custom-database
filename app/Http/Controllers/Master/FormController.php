<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\master_table;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class FormController extends Controller
{
    public function index()
    { 
        return view('master.forms.index', [
            'group' => DB::table('master_tablegroup')->get(),
            'forms' => DB::table('master_tables')->latest()->paginate(10)
        ]);
    }

    public function create()
    {
        return view('master.forms.create',[
            'group' => DB::table('master_tablegroup')->get(),
        ]);
    }

    public function edit(Request $request, $name)
    {
        $select = DB::table('master_tables')->where('name',$name)->first();
        $table_name = $select->description;
        return view('master.forms.edit', [
            'group'         => DB::table('master_tablegroup')->get(),
            'table'         => $name,
            'table_name'    => $table_name,
            'title'         => DB::table($name.'_description')->get(),
            'form'          => DB::table($name)->get()
        ]);
    }

    public function addcolumn(Request $request)
    {
        $field_name = str_replace(' ', '',strtolower($request->name));
        $table_name = $request->table;
		$description 	= $table_name.'_description';
        
        // dd($field_name, $table_name);

		$query = "ALTER TABLE $table_name ADD $field_name VARCHAR(255)";
		DB::insert("INSERT INTO $description (field_name,field_description,is_show,data_type) VALUES ('$field_name','$request->name','1','VARCHAR(255)')");

        DB::statement($query);

        return back()->with('success', 'Column Was Created');
    }

    public function show($name)
    {

        $url = url()->current();
        //return response
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Post',
            'data'    => $url
        ]); 
    }

    public function get_tables($group)
    {
        $forms = DB::table('master_tables')->where('group',$group)->latest()->paginate(10);
        //dd($forms);
        $i = 1;
        $data = '';
        $data .= '<thead class="thead-dark"><tr><th>#</th><!-- <th>Name</th> --><th>Table Name</th><th>Tanggal Dibuat</th><th>Tanggal Diupdate</th><th>Aksi</th></tr></thead><tbody>';

        foreach ($forms as $form ){
        $data .=
            '<tr>

                <td>'.$i.'</td>
                <td>'.$form->description.'</td>
                <td>'.$form->created_at.'</td>
                <td>'.$form->updated_at.'</td>
                <td>
                    <a href="'.route('master.forms.edit', $form->name).'" class="btn btn-primary btn-sm">Detail</a>
                </td>

            </tr>';
        }

        $data .= '</tbody>';
        return $data;
    }

    public function update(Request $request)
    {
		$table			= $request->table;
		$edit_id		= $request->data_id;
		$table_desc		= $table."_description";
		$table_head		= DB::select(DB::raw("SELECT * FROM ".$table_desc." where is_show = '1';"));
		$select_field	= '';
		if ($table_head > 0){
			foreach ($table_head as $t){
                $fields = $t->field_name;
				$select_field .= $t->field_name.'="'.$request->$fields.'",';
				//$values .= '"'.$this->input->post($t->field_name).'",';
			}
			$selected = substr($select_field, 0,-1	);
			//$insert_value = substr($values, 0,-1	);
		}
		$insert = DB::statement("UPDATE $table SET $selected WHERE id='$edit_id';");
		//var_dump($insert);
		if($insert){
			return back()->with('success', 'Data Edited');
		}
    }
}
