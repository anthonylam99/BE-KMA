<?php

namespace App\Http\Middleware;

use Closure;
use DB;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = [1])
    {

        $token = '';
        $headers = collect($request->header())->transform(function ($item) {
            return $item[0];
        });

        if (isset($headers['authorization'])) {

            $arr = explode(" ", $headers['authorization']);
            if (count($arr) == 2) {
                $token = $arr[1];
            }
        }

        if (empty($token)) {
            return response()->json([
                'code'    => 401,
                'message' => 'Token mismatch'
            ], 401);
        }

        $dataUser = DB::table('adm_user')->where('adm_token', $token)
            ->where('adm_status', 1)->whereIn('adm_group_id', $guard)->first();

        if (is_null($dataUser)) {
            $check   = false;
        } else {
            $check   = true;
        }

        if (!$check) {
            return response()->json([
                'code'    => 401,
                'message' => 'Bạn không có quyền truy cập'
            ], 401);
        }
        return $next($request);
    }
}
