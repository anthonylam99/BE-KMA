<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\Student\StudentResource;
use Illuminate\Http\Request;
use DB;

class StudentController extends Controller
{
    public function allList(Request $request){
        $class_id =  $request->has('class_id') ? $request->class_id : 0 ;

        $data = DB::table('students_in_class')
        ->join('adm_user','st_id','=','adm_id')
        ->where('st_class_id', $class_id)
        ->get();
        
        
        
        $return =  StudentResource::collection($data);
        return response()->json($return);
            
    }
}
