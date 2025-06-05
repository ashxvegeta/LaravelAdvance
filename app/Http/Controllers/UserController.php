<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    //


    public function register(Request $request)
{
    $request->validate([
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6'
    ]);

    $user = User::create([
        'email' => $request->email,
        'password' => Hash::make($request->password)
    ]);

    // Trigger Welcome Email Event if set up
    event(new \App\Events\UserRegistered($user));

    return back()->with('success', 'Registration successful. Please check your email.');
}
}
