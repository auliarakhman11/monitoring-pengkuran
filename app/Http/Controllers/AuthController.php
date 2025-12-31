<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login_page()
    {
        return view('auth.login', ['title' => 'Login Page']);
    }

    public function login(Request $request)
    {
        $attributes = $request->validate([
            'username' => ['required'],
            'password' => ['required']
        ]);

        // if(Auth::attempt($attributes)){
        //     return redirect(RouteServiceProvider::HOME);
        // }

        $user = User::where('username', $request->username)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                // dd($user);
                if ($user->aktif) {

                    Auth::login($user);
                    session()->put('username', $user->username);
                    session()->put('role_id', $user->role_id);
                    session()->put('name', $user->name);

                    return redirect(route('home'));
                } else {
                    throw ValidationException::withMessages([
                        'username' => 'User tidak aktif'
                    ]);
                }
            } else {
                throw ValidationException::withMessages([
                    'username' => 'Username atau password salah'
                ]);
            }
        }

        throw ValidationException::withMessages([
            'username' => 'Username atau password salah'
        ]);
    }

    public function logout()
    {
        Auth::logout();
        session()->forget('username');
        session()->forget('role_id');
        session()->forget('name');
        return redirect(route('loginPage'))->with('success', 'Logout Berhasil');
    }

    public function block()
    {
        return view('auth.block');
    }
}
