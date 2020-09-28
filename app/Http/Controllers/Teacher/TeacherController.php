<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Resources\Teacher\TeacherResources;
use Illuminate\Http\Request;
use DB;

class TeacherController extends Controller
{
    public function getList(Request $request){
        $data = DB::table('adm_user')->where('adm_group_id','LIKE','%' . 2 .'%')->get();
        
        $return =  TeacherResources::collection($data);
        return response()->json($return);
    }
}
