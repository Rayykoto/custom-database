<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TableController extends Controller
{
    public function index()
    {
        $group = DB::table('master_tablegroup')->get();
        return view('master.tables.index', [
            'users' => User::latest()->paginate(10),
            'group' => DB::table('master_tablegroup')->get(),
        ]);
    }

    public function create()
    {
        return view('master.tables.create',[
            'group' => DB::table('master_tablegroup')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $carbon         = Carbon::now();
        $table_name     = str_replace(' ','',strtolower($request->name));
        $group_name     = str_replace(' ','',strtolower($request->table_group));
        $description 	= $table_name.'_description';
        $query          = "CREATE TABLE $table_name (id int(11) NOT NULL AUTO_INCREMENT, created_at timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY (`id`) USING BTREE)";
        $query2         = "CREATE TABLE $description (id int(11) NOT NULL AUTO_INCREMENT,crated_at timestamp(0) NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP(0), field_name VARCHAR(255) NOT NULL, field_description
            VARCHAR(255) NOT NULL,is_show VARCHAR(1) NOT NULL,data_type VARCHAR(255) NULL,PRIMARY KEY (`id`) USING BTREE)";

        DB::statement($query);
        
        DB::statement($query2);

        DB::insert("INSERT INTO master_tables (`group`, `name`, `description`) VALUES ('$group_name','$table_name','$request->name')");

        //DB::insert("INSERT INTO master_tablegroup (name, description, created_at, updated_at) VALUES ('$group_name','$request->table_group','$carbon','$carbon')");

        return back()->with('success', 'Table was created');
    }
}
