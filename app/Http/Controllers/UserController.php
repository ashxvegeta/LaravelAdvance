<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Jobs\SendWelcomeEmail;

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

      // Queue the welcome email
     SendWelcomeEmail::dispatch($user);

    return back()->with('success', 'User registered, email will be sent.');
}
}
