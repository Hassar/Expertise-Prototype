<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Facades\App\Http\Services\AuthService;

class LoginController extends Controller
{
    /**
     * Login user.
     *
     * @param \App\Http\Requests\LoginRequest
     * 
     * @return \Illuminate\Http\Response
    */
    public function login(LoginRequest $request)
    {
        return AuthService::login($request);
    }

    public function logout()
    {
        \Auth::logout();
    }

    protected function guard()
    {
        return \Auth::guard();
    }
}
