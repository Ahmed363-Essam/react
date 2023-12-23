<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Helpers\ApiResponse;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRegisterRequest;

class UserController extends Controller
{
    //
    public function Register(UserRegisterRequest $request)
    {
        try {
            $input = $request->only(['name', 'email']);
            $password = Hash::make($request->password);
            $input['password'] = $password;

            $user = User::create($input);

            return ApiResponse::sendResponse(200, $user, 'users Registered successfully');
        } catch (\Exception $e) {
            ApiResponse::sendResponse(422, NULL, $e->getMessage());
        }
    }

    public function Login(Request $request)
    {
        try {

            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                $user = auth('web')->user();
     
                return ApiResponse::sendResponse(200, $user, 'users logined successfully');
            } else {
                return ApiResponse::sendResponse(400, null, 'Credintial Not Founded');
            }
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
