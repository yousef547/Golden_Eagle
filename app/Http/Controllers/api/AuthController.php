<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $username = $request->get('username');
        $password = $request->get('password');
        $user_mes = User::where('username', '=', $username)->first();
        if (!$user_mes || !Hash::check($password, $user_mes->password)) {
            return "اسم المستخدم أو كلمة المرور غير صحيحة";
        }
        $token = JWTAuth::fromUser($user_mes); // إنشاء رمز مميز
        if (!$token) {
            return "فشل تسجيل الدخول. يرجى المحاولة مرة أخرى";
        }
        return response()->json(['token' => $token]);
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
