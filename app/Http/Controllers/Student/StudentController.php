<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\Student\StudentResource;
use Illuminate\Http\Request;
use DB;

class StudentController extends Controller
{
    public function allList(){
        $data = DB::table('adm_user')
        ->where('adm_group_id','LIKE', '%'. 2 .'%')
        ->leftJoin('students_in_class','st_id','=','adm_id')
        ->leftJoin('student_check_in','student_check_in.st_id','=','adm_id')
        ->get();

        
        
        $return =  StudentResource::collection($data);
        return response()->json($return);
            
    }
}
