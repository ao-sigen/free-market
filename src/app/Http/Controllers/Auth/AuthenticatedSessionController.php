<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class AuthenticatedSessionController extends Controller
{
    /**
     * ログイン処理
     */
    public function store(LoginRequest $request)
    {
        // 認証を試みる
        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            return back()
                ->withErrors([
                    'login' => 'ログイン情報が登録されていません',
                ])
                ->withInput();
        }

        $request->session()->regenerate();

        return redirect()->intended('/');
    }

    /**
     * ログアウト処理
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
