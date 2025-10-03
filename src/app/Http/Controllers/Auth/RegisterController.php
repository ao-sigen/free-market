<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
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

        Auth::login($user); // 登録後に自動ログイン

        return redirect()->route('profile.create')->with('success', 'アカウントを作成しました');
    }
    public function create()
    {
        return view('profile.create'); // resources/views/profile/create.blade.php
    }

    public function store(Request $request)
    {
        // バリデーションやプロフィール作成処理
    }
}
