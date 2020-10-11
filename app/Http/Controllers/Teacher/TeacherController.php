<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Http\Resources\Teacher\TeacherResources;
use Illuminate\Http\Request;
use DB;

class TeacherController extends Controller
{
    public function all()
    {
        $data = DB::table('adm_user')->where('adm_group_id', 'LIKE', '%' . 3 . '%')->get()
            ->map(function ($item) {
                $item->adm_birthday = date("Y-m-d", $item->adm_birthday);

                return $item;
            });
        return response()->json($data);
    }
}
