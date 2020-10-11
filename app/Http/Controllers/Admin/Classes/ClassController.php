<?php

namespace App\Http\Controllers\Admin\Classes;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;

class ClassController extends Controller
{
    public function all(){
        $data = DB::table('class')->get()
        ->map(function($item){
            $item->class_start = date("Y-m-d",$item->class_start);
            $item->class_end = date("Y-m-d",$item->class_end);

            return $item;
        });
        return response()->json($data);
    }
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
                'class_start'       => strtotime($class_start),
                'class_end'         => strtotime($class_end),
                'number_of_sessions_per_week' => $session_per_week,
                'number_of_sessions'    => $num_of_sesssion,
                'fee'               => $fee
            ]
        );
        $id = DB::table('class')->where([
            'class_code'    => $class_code,
            'class_name'    => $class_name
        ])->pluck('class_id')->toArray();

        $dateRange = range(strtotime($class_start), strtotime($class_end), "86400");
        array_walk_recursive($dateRange, function (&$element) {
            $element = date("Y-m-d", $element);
        });
        $num = 0;
        foreach ($dateRange as $value) {
            $num += 1;
            DB::table('class_schedule')->insert([
                'class_id'          => $id[0],
                'date_on_duty'      => $value,
                'number_of_session' => $num
            ]);
        }

        if ($insert) {
            return response()->json(['message'      => 'Thêm mới thành công']);
        } else {
            return response()->json(['message'      => 'Thêm mới thất bại'], 500);
        }
    }
    public function getSchedule(Request $request)
    {
        $date = [];
        $startDate           =  $request->has('startDate') ? $request->startDate : "";
        $endDate             =  date("Y-m-t", strtotime($startDate));

        $data = DB::table('class_schedule')
            ->selectRaw('
                class.class_id,
                date_on_duty,
                class_code,
                class_name,
                class_start,
                class_end,
                number_of_sessions
            ')
            ->join('class', 'class.class_id', '=', 'class_schedule.class_id')
            ->whereBetween(DB::raw('date(date_on_duty)'), [$startDate, $endDate])
            ->get()->map(function($item){
                $item->class_start = date("Y-m-d",$item->class_start);
                $item->class_end = date("Y-m-d",$item->class_end);

                return $item;
            });

        $group = array();

        foreach ($data as $value) {
            $group[$value->date_on_duty][] = $value;
        }
        return response()->json($group);
    }
}
