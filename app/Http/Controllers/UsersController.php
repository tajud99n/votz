<?php

namespace App\Http\Controllers;

use session;
use App\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    
    public function index()
    {
        return view('admin.users.index', ['users' => User::orderBy('created_at', 'desc')->paginate(5)]);
    }

    public function suspend($id)
    {
        $user = User::find($id);

        $user->delete();

        Session::flash('success', 'User successfully suspended.');

        return redirect()->back();
    }

    public function suspended_users()
    {
        return view('admin.users.suspended', ['users' => Users::withTrashed()->paginate(5)]);
    }

    public function reinstate($id)
    {
        $user = User::find($id);

        // reinstate user

        return redirect()->back();
    }
}
