<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\master_table;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;

class FormController extends Controller
{
    public function index()
    { 
        return view('master.forms.index', [
           'forms' => DB::table('master_tables')->latest()->paginate(10)
        ]);
    }

    public function create()
    {
        return view('master.forms.create');
    }

    public function edit(Request $request, $name)
    {
        return view('master.forms.edit', [
        'table' => $name,
        'title' => DB::table($name.'_description')->get(),
        'form' => DB::table($name)->get()
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

    public function update($name)
    {
        $value = DB::table($name)->get();
        
        dd($value);
    }
}
