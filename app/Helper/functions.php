<?php

use Illuminate\Support\Facades\Auth;

function admin_user()
{
    return Auth::guard('sanctum')->user();
}


function response_ok(array $data = [], int $status = 200)
{
    return response(
        array_merge([
            'status' => 'OK'
        ], $data),
        $status
    );
}

function current_hub_id()
{
    return admin_user()->adm_diem_ket_noi;
}
