<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $moodboards = \App\Models\Moodboard::where('creator', $user->name)->latest()->get();
        $favorites = $user->favorites()->latest()->get();
        return view('user.profile', compact('user', 'moodboards', 'favorites'));
    }

    public function edit()
    {
        $user = Auth::user();
        return view('user.edit-profile', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $input = $request->only(['name', 'email']);

        if ($request->filled('password')) {
            $input['password'] = Hash::make($request->password);
        }

        if ($request->hasFile('foto')) {
            // Delete old photo if exists
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }
            $input['foto'] = $request->file('foto')->store('foto', 'public');
        }

        $user->update($input);

        return redirect()->route('user.profile')
                         ->with('success', 'Profile berhasil diupdate!');
    }
}
