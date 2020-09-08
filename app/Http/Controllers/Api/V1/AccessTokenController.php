<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\V1\GetAccessTokenRequest;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AccessTokenController extends Controller
{
    public function getAccessToken(Request $request)
    {
        $credentials = [
            'adm_loginname' => $request->username,
            'adm_password' => $request->password,
        ];

        if (! Auth::once($credentials)) {
            throw new HttpException(200, "username or password is invalid!");
        }

        return response_ok([
            'access_token' => Auth::user()->createToken('api')->plainTextToken
        ]);
    }
}
