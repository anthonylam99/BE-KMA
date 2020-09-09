<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\HttpException;
use DB;
class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){
            $id             = Auth::user()->adm_id;

            $group_adm_id   = DB::table('adm_user')->where('adm_id', $id)->where('adm_group_id', "LIKE" , "%". 1 . "%")->pluck('adm_group_id');

            if(count($group_adm_id) > 0){
                return $next($request);
            }else{
                abort(403, 'Unauthorized action.');
            }
        }
    }
}
