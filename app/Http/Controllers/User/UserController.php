<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Model\UserModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use DB;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function add(Request $request)
    {
        $delimiter = '-';
        $adm_hash = rand(100, 10000);
        $str = $request->name;
        $no_name = strtolower(trim(preg_replace('/[\s-]+/', $delimiter, preg_replace('/[^A-Za-z0-9-]+/', $delimiter, preg_replace('/[&]/', 'and', preg_replace('/[\']/', '', iconv('UTF-8', 'ASCII//TRANSLIT', $str))))), $delimiter));

        $pattern = array('/\[/', '/\]/');
        $arr_depot_replace = preg_replace($pattern, "", $request->group_id);
        $adm_group = implode(",", $arr_depot_replace);

        $user = DB::table('adm_user')->where('adm_username', $request->username)->get();
        $email = DB::table('adm_user')->where('adm_gmail', $request->gmail)->get();
        $phone = DB::table('adm_user')->where('adm_phone', $request->phone)->get();

        if (count($user) > 0) {
            return response()->json([
                'message' => 'Tên đăng nhập đã được sử dụng'
            ]);
        } else if (count($email) > 0) {
            return response()->json([
                'message'          => 'Email đã được sử dụng'
            ]);
        } else if (count($phone) > 0) {
            return response()->json([
                'message'          => 'Số điện thoại đã được sử dụng'
            ]);
        } else {
            $id = DB::table('adm_user')->insertGetId([
                'adm_username'          => $request->username,
                'adm_username_md5'      => md5($request->username),
                'adm_password'          => md5($request->password . $adm_hash),
                'adm_hash'              => $adm_hash,
                'adm_status'            => 1,
                'adm_name'              => $request->name,
                'adm_no_name'           => $no_name,
                'adm_sex'               => $request->sex,
                'adm_birthday'          => strtotime($request->birthday),
                'adm_phone'             => $request->phone,
                'adm_gmail'             => $request->gmail,
                'adm_group_id'          => $adm_group,
                'adm_register_time'     => Carbon::now()
            ]);


            if ($id) {
                return "Success";
            }
        }
    }

    public function login(Request $request)
    {
        extract($request->only(['username', 'password']));

        $result = [
            'message'      => '',
            'accessToken'  => '',
            'refreshToken' => '',
            'adm_name'     => '',
            'last_login'   => '',
            'adm_id'       => '',
        ];
        $username          = mb_strtolower($username, "UTF-8");
        $adm_loginname_md5 = md5($username);
        $dataUser = DB::table('adm_user')->where('adm_username_md5', $adm_loginname_md5)
            ->where('adm_status', 1)
            ->first();
        if (is_null($dataUser)) {
            $result['message'] = 'Không tồn tại tài khoản';
            return response()->json($result, 401);
        }
        $adm_hash      = $dataUser->adm_hash;
        $password      = md5($password . $adm_hash);
        $adm_password  = $dataUser->adm_password;
        if ($password == $adm_password) {
            $adm_id        = $dataUser->adm_id;
            $strToken = base64_encode($dataUser->adm_name) . '.' . base64_encode($adm_password) . '.' . base64_encode($dataUser->adm_id);
            $token = md5($strToken);

            $dataUser->adm_token = $token;
            DB::table('adm_user')->where('adm_id', $dataUser->adm_id)->update([
                'adm_token' => $token
            ]);

            $result['message']      = 'Đăng nhập thành công!';
            $result['adm_id']       = (int)$dataUser->adm_id;
            $result['adm_name']     = $dataUser->adm_name;
            $result['last_login']   = date('d-m-Y H:i:s');
            $result['accessToken']  = $token;
            $result['refreshToken'] = $token;

            return response()->json($result);
        } else {
            $result['message'] = 'Mật khẩu không đúng';
            return response()->json($result, 401);
        }
        return response()->json($result);
    }

    public function home(Request $request){
        
        return "home";
    }
}
