<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
    
    public function loginsubmit(Request $request)
    {
     
    $email = $request->input('email');
    $name = $request->input('name');

    $user = User::where('email', $email)->where('name', $name)->first();

    if ($user) {
        Auth::login($user);

        if ($user->role === 'admin') {
            return redirect('/admin/dashboard');
        } else {
            return redirect('/dashboard');
        }
    }

    return back()->withErrors(['Invalid credentials']);
    }

    

    


    
}
