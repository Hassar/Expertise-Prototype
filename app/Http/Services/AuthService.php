<?php
namespace App\Http\Services;

use App\Models\User;
use App\Http\Resources\User as UserResource;

class AuthService
{
    /**
     * Login user.
     *
     * @param \App\Http\Requests\LoginRequest
     * 
     * @return \Illuminate\Http\Response
    */
    public function login($request)
    {
        try {
            if($request->device_name == 'mobile_app'){
                $user = User::whereEmail($request->email)->first();
    
                if (! $user || ! \Hash::check($request->password, $user->password)) {
                    return response()->json([
                        'error' => 'The provided credentials are incorrect!'
                    ], 401);
                }
                \Log::info("New user login : {$request->email}, from device name : {$request->device_name}, from IP : {$request->ip()}");
                return response()->json([
                    'token' => $user->createToken($request->device_name)->plainTextToken,
                    'user' => new UserResource($user)
                ], 200);
            }
            $credentials = $request->only('email', 'password');
            
            if (\Auth::attempt($credentials)) {
                \Log::info("New user login : {$request->email}, from device name : {$request->device_name}, from IP : {$request->ip()}");
                return response()->json([
                    'res' => true
                ], 200);
            }
            else return response()->json([
                'res' => false,
                'msg' => 'The provided credentials are incorrect!'
            ], 401);
        } catch (\Throwable $th) {
            \Log::error("Login user error: {$th->getMessage()}");
            return ['res' => false, 'msg' => $th->getMessage()];
        }
    }
}