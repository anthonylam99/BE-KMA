<?php

namespace App\Http\Controllers\Admin\Classes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ClassController extends Controller
{
    public function add(Request $request)
    {
        $class_code         = $request->has('class_code') ? $request->class_code : "";
        $class_name         = $request->has('class_name') ? $request->class_name : "";
        $class_status       = $request->has('class_status') ? $request->class_status : 0;
        $class_type         = $request->has('class_type') ? $request->class_type : "";
        $class_start        = $request->has('class_start') ? $request->class_start : "";
        $class_end          = $request->has('class_end') ? $request->class_end : "";

        $dateRange = range(strtotime($class_start), strtotime($class_end), "86400");
        array_walk_recursive($dateRange, function (&$element) {
            $element = date("Y-m-d", $element);
        });
        $dateCount = count($dateRange);

        $num_of_sesssion    = $dateCount;
        $session_per_week   = round($num_of_sesssion / 7);
        $fee                = $request->has('fee') ? $request->fee : "";

        $insert = DB::table('class')->updateOrInsert(
            [
                'class_code'        => $class_code,
                'class_name'        => $class_name
            ],
            [
                'class_code'        => $class_code,
                'class_name'        => $class_name,
                'class_status'      => $class_status,
                'class_type'        => $class_type,
                'class_start'       => $class_start,
                'class_end'         => $class_end,
                'number_of_sessions_per_week' => $session_per_week,
                'number_of_sessions'    => $num_of_sesssion,
                'fee'               => $fee
            ]
        );
        if ($insert) {
            return response()->json(['message'      => 'Thêm mới thành công']);
        } else {
            return response()->json(['message'      => 'Thêm mới thất bại'], 500);
        }
    }
}
