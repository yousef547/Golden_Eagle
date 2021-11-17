<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\governorate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Traits\GeneralTrait;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    use GeneralTrait;

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|min:5|max:30',
            'number' => 'required|min:11|numeric',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return $this->returnError($validator->errors());
        }
        $user = User::create([
            'name'=>$request->get('username'),
            'email'=>$request->get('email'),
            'password'=>Hash::make($request->get('password')),
            'number'=>$request->get('number'),
        ]);
        $token = JWTAuth::fromUser($user);
        return response()->json(compact('user','token'),201);
              

    }
    public function login(Request $request)
    {
        $username = $request->get('email');
        $password = $request->get('password');
        $user_mes = User::where('email', '=', $username)->first();
        if (!$user_mes || !Hash::check($password, $user_mes->password)) {
            return $this->returnError("اسم المستخدم أو كلمة المرور غير صحيحة");
        }
        $token = JWTAuth::fromUser($user_mes); // إنشاء رمز مميز
        if (!$token) {
            return "فشل تسجيل الدخول. يرجى المحاولة مرة أخرى";
        }
        return $this->doneToken($token);
        // return response()->json(['token' => $token]);
    }

    // احصل على معلومات المستخدم
    public function home()
    {
        $user = JWTAuth::parseToken()->touser(); // احصل على معلومات المستخدم
        return $user;
    }

    //أوقع
    public function logout()
    {
        JWTAuth::parseToken()->invalidate(); //أوقع
        return "الخروج بنجاح";
    }
}
