<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        //Validation
        $filters = [
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required']
        ];
        $this->validate($request, $filters);

        //sigh the user in
        if (auth()->attempt($request->only('email', 'password'), $request->remember)) {
            //redirect
            return redirect()->route('dashboard');
        } else {
            return back()->with('status', 'Invalid login details.');
        }
    }
}
