<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('home', compact('user'));
    }

    public function edit()
    {
        $user = Auth::user();
        $profile = $user->profile;

        if (!$profile) {
            return redirect()->route('profile.create');
        }

        return view('profile.edit', compact('profile'));
    }


    public function update(ProfileRequest $request)
    {
        $user = auth()->user();

        // プロフィールがない場合は新規作成
        $profile = $user->profile;
        if (!$profile) {
            $profile = $user->profile()->create([]);
        }

        // アイコンアップロード
        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('icons', 'public');
            $profile->icon = $path;
        }

        // その他の情報を更新
        $profile->username = $request->input('username');
        $profile->postcode = $request->input('postcode');
        $profile->address  = $request->input('address');
        $profile->building = $request->input('building');

        // 保存
        $profile->save();

        return redirect()->route('profile.edit')->with('success', 'プロフィールを更新しました');
    }




    public function create()
    {
        // すでにプロフィールがある場合は編集画面へ
        if (Auth::user()->profile) {
            return redirect()->route('profile.edit', Auth::user()->profile->id);
        }

        return view('profile.create');
    }


    public function store(ProfileRequest $request)
    {
        $profile = new Profile();
        $profile->user_id = Auth::id();
        $profile->username = $request->username;
        $profile->postcode = $request->postcode;
        $profile->address  = $request->address;
        $profile->building = $request->building;

        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('public/icons');
            $profile->icon = basename($path);
        }

        $profile->save();

        return redirect()->route('home')->with('success', 'プロフィールを作成しました');
    }
}