<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\Student\StudentResource;
use Illuminate\Http\Request;
use DB;

class StudentController extends Controller
{
    public function allList(){
        $data = DB::table('students_in_class')
        ->join('adm_user','st_id','=','adm_id')
        ->get();
        
        
        
        $return =  StudentResource::collection($data);
        return response()->json($return);
            
    }
}
