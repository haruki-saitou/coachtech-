<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ProfileController extends Controller
{
    public function index()
    {
        return view('profiles.index');
    }

    public function edit()
    {
        $user = Auth::user();
        return view('profiles.edit', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        $data = $request->all();

        if ($request->hasFile('image_path')) {
            if ($user->image_path) {
                Storage::delete($user->image_path);
            }
            $file = $request->file('image_path');
            $data['image_path'] = $file->store('profile_images', 'public');
        }

        $user->update($data);

        return redirect()->route('profile.edit')->with('status', 'プロフィールを更新しました。');
    }
}
