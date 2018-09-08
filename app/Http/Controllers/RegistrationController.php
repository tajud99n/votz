<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Mail\Registration;

class RegistrationController extends Controller
{
    public function create()
    {
        return view('registration.create');
    }

    public function store()
    {
        // Form validation
        $this->validate(request(), [
            'firstname' => 'required',
            'lastname'  => 'required',
            'email'     => 'required|email',
            'password'  => 'required|confirmed|min:8'
        ]);

        // Create and save user
        $request = request();
        $request->request->add(['activation_token' => hash('sha256', uniqid())]);
        $request->request->add(['status' => 0]);
        
        $user = User::create(request(['firstname', 'lastname', 'email', 'password', 'activation_token', 'status']));

        // Send verification link to email address(would be implemented later)
        //\Mail::to($user)->send(new Registration($user));

        // Sign User In
        auth()->login($user);

        // Redirect to dashboard
        return redirect('/dashboard');
    }

    public function edit()
    {
        $email = request('email');
        $activation_token = request('_token');
        echo hash('sha256', uniqid());
        

        // find User

        // verify credentials

        // activate account

        // go to login
    }
}
