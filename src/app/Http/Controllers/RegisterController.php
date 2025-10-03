<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    // 登録画面表示
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // 登録処理
    public function register(RegisterRequest $request)
    {
        // バリデーションは RegisterRequest が自動で行う

        $user = User::create([
            'name'     => $request->username,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        Auth::login($user);
        return redirect()->route('verification.notice');
    }
}
