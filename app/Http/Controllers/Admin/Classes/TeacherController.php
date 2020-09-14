<?php

namespace App\Http\Controllers\Admin\Classes;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;

class TeacherController extends Controller
{
    public function addTeacher(Request $request)
    {
        $tc_id         = $request->has('tc_id') ? $request->tc_id : 0;
        $class_info    = $request->has('class_info') ? $request->class_info : [];

        

        if (!empty($class_info)) {
            foreach ($class_info as $value) {
                $status     = 1;
                $start_date = strtotime($value['start_date']);
                $now        = strtotime(date("Y-m-d"));

                if($start_date > $now){
                    $status = 0;
                }
                DB::table('teacher_in_class')->updateOrInsert(
                    [
                        'tc_id'                         =>  $tc_id,
                        'tc_class_name_id'              =>  $value['class_id']
                    ],
                    [
                        'tc_id'                         =>  $tc_id,
                        'tc_class_name_id'              =>  $value['class_id'],
                        'tc_teacher_class_status'       =>  $status,
                        'start_date'                    =>  $value['start_date']
                    ]
                );
            }
        }
    }
}
