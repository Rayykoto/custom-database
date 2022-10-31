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
            'group' => DB::table('master_tablegroup')->where('is_show',1)->get(),
            'forms' => DB::table('master_tables')->latest()->paginate(10)
        ]);
    }

    public function create()
    {
        return view('master.forms.create',[
            'group' => DB::table('master_tablegroup')->where('is_show',1)->get(),
        ]);
    }

    public function edit(Request $request, $name)
    {
        $select_field = '';$form = '';
        $select = DB::table('master_tables')->where('name',$name)->first();
        $table_name = $select->description;
        $description = $name.'_description';
        $title  = DB::table($description)->where('is_show',1)->get();
        $header = DB::table($description)->get();
        if ($title->count() > 0){
			foreach ($title as $t){
				$select_field .= 'id,'.$t->field_name.',';
			}
			$selected = substr($select_field, 0,-1	);
            $form = DB::table($name)->selectRaw($selected)->get();
		} else {
            $form = DB::table($name)->get();
        }
        $field  = DB::table('master_datatype')->get();
        return view('master.forms.edit', [
            'group'         => DB::table('master_tablegroup')->get(),
            'table'         => $name,
            'table_name'    => $table_name,
            'title'         => $title,
            'field'         => $field,
            'header'        => $header,
            'form'          => $form,
        ]);
    }

    public function manage(Request $request){
        $table_name     = $request->table;
		$description 	= $table_name.'_description';
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
         function searchTypebyId($id, $array) {
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
            if(IsChecked('is_show',$row->field_name)){
                $show_selector = '1';
            } else {
                $show_selector = '0';
            }
            $myjawab[] = array(
                "field_name"        => $row->field_name,
                "is_show"           => $show_selector
            );
        }
        
        function modify($table_name,$fields,$data_type){
            $query_alter = "ALTER TABLE `$table_name` MODIFY COLUMN `$fields` $data_type";
            $mod = DB::statement($query_alter);
        }

        $result  = array();
			$queryin	 = DB::table($description)->get();
			foreach ($queryin as $i => $row)
			{
				$result[] = array(
				"field_name"		=> $row->field_name,
                "data_type"		    => $request->managedata_type[$i],//$request->get('managedata_type'),
				"is_show"			=> searchJawabanbyId($row->field_name, $myjawab)
				);
			}
            //dd($result);
        for ($i = 0; $i < count($result); $i++){
            $fields     = $result[$i]["field_name"];
            $is_show    = $result[$i]["is_show"];
            $data_type  = $result[$i]["data_type"];
            $query = "UPDATE $description SET is_show='$is_show',data_type = '$data_type' WHERE field_name='$fields';";

            $modify = modify($table_name,$fields,$data_type);

            DB::statement($query);
        }
        return back()->with('success', 'Data Edited');
    }

    public function addcolumn(Request $request)
    {
        $field_name = str_replace(' ', '',strtolower($request->name));
        $table_name = $request->table;
		$description 	= $table_name.'_description';
        $data_type      = $request->data_type;
        //dd($field_name, $table_name);

        $query = "ALTER TABLE `$table_name` ADD `$field_name` $data_type";
        //dd($query);
		DB::insert("INSERT INTO $description (field_name,field_description,is_show,data_type) VALUES ('$field_name','$request->name','1','$data_type')");

        DB::statement($query);

        return back()->with('success', 'Column Was Created');
    }

    public function add_record(Request $request)
    {
        $table			= $request->table;
		$table_desc		= $table."_description";
		$table_head		= DB::table($table_desc)->where('is_show',1)->get();
		$select_field	= '';
		$values	        = '';
        //dd($table_head);
			foreach ($table_head as $t){
                $fields = $t->field_name;
				$select_field .= $t->field_name.',';
				$values .= "'".$request->$fields."',";
			}
			$selected = substr($select_field, 0,-1	);
			$insert_value = substr($values, 0,-1	);
		
        //dd($insert_value);
		$insert = DB::statement("INSERT INTO $table ($selected) VALUES ($insert_value);");
		if($insert){
			return back()->with('success', 'Data Added');

		}
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
        $data .= '<thead class="thead-dark"><tr><th>#</th><!-- <th>Name</th> --><th>Table Name</th><th>Tanggal Dibuat</th><th class="b">Aksi</th></tr></thead><tbody>';

        foreach ($forms as $form ){
            $checked = '';
            //if($form->is_show == '1') {$checked='<input type="hidden" name="value" value="0"><button type="submit" class="btn btn-success btn-sm">Hide</button>';}else{$checked='<input type="hidden" name="value" value="1"><button type="submit" class="btn btn-danger btn-sm">Show</button>';}
            $data .=
                '<tr>

                    <td>'.$i.'</td>
                    <td>'.$form->description.'</td>
                    <td>'.$form->created_at.'</td>

                    <td>
                        <div class="input-group">
                            <a href="'.route('master.forms.edit', $form->name).'" class="btn btn-primary">Detail</a> &nbsp
                            <form method="post" action="'.route('master.table-group.hide_show').'">
                                <input type="hidden" name="field" value="'.$form->name.'">
                                '.$checked.'
                            </form>
                        </div>
                    </td>

                </tr>';
            $i++;
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
				$select_field .= $t->field_name."='".$request->$fields."',";
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

    public function delete(Request $request){
		$id			 	= $request->id;
		$table			= $request->table_name;
		$table_desc		= $table."_description";
		$table_head		= DB::statement("DELETE FROM $table WHERE id='$id';");
        if($table_head){
            return back()->with('success', 'Data Edited');
        }
	}
}
