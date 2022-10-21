<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TableController extends Controller
{
    public function index()
    {
        return view('master.tables.index', [
            'users' => User::latest()->paginate(10),
        ]);
    }

    public function create()
    {
        return view('master.tables.create');
    }

    public function store(Request $request)
    {
        $table_name = str_replace(' ','',strtolower($request->name));
        $description 	= $table_name.'_description';
        $query = "CREATE TABLE $table_name (id int(11) NOT NULL AUTO_INCREMENT, created_at timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY (`id`) USING BTREE)";
        $query2 = "CREATE TABLE $description (id int(11) NOT NULL AUTO_INCREMENT,crated_at timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0), field_name VARCHAR(255) NOT NULL, field_description
             VARCHAR(255) NOT NULL,is_show VARCHAR(1) NOT NULL,data_type VARCHAR(255) NULL,PRIMARY KEY (`id`) USING BTREE)";

        DB::statement($query);
        
        DB::statement($query2);

        DB::insert("INSERT INTO master_tables (name, description) VALUES ('$table_name','$request->name')");
        
        return back()->with('success', 'Table was created');
    }
}
