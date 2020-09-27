<?php

namespace App\Http\Controllers\Web\Admin\Classes;

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

                if ($start_date > $now) {
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

    public function checkIn(Request $request)
    {
        $tc_id                  = $request->has('tc_id') ? $request->tc_id : 0;
        $tc_class_name          = $request->has('tc_class_name') ? $request->tc_class_name : "";
        $tc_class_id            = $request->has('tc_class_id') ? $request->tc_class_id : 0;
        $time_checkin           = Carbon::now();

        $insert = DB::table('teacher_check_in')->insert([
            'tc_id'             => $tc_id,
            'tc_class_name'     => $tc_class_name,
            'tc_class_id'       => $tc_class_id,
            'time_check_in'     => $time_checkin
        ]);

        $mess = ($insert) ? "Thêm mới thành công" : "Thêm mới thất bại";
        return response()->json(['mess' => $mess]);
    }

    public function deleteTeacherInClass(Request $request)
    {
        $tc_id                  = $request->has('tc_id') ? $request->tc_id : 0;
        $tc_class_id            = $request->has('tc_class_id') ? $request->tc_class_id : 0;

        $update = DB::table('teacher_in_class')->where([
            'tc_id'             => $tc_id,
            'tc_class_id'       => $tc_class_id
        ])->update([
            'tc_teacher_class_status' => 3,
            'end_date'                => Carbon::now()
        ]);
        if ($update) {
            return response()->json(['message'      => 'Xóa thành công']);
        } else {
            return response()->json(['message'      => 'Xóa thất bại'], 500);
        }
    }
}
