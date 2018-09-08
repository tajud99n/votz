<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'destroy']);
    }

    public function create()
    {
        return view('sessions.create');
    }

    public function store()
    {
        // Authenticate the user
        if (!auth()->attempt(request('email', 'password'))) {
            return back()->withErrors([
                'message' => 'Invalid Email and/or Password'
            ]);
        }

        //Else 
        return redirect('/dashboard');
    }

    public function destroy()
    {
        auth()->logout();

        return redirect('/login');
    }
}
