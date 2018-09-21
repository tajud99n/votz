<?php

namespace App\Http\Controllers;

use Auth;
use Session;

use App\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return view('users.profile')->with('user', Auth::user()); 
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        if ($request->email == $user->email) {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email',
                'description'   => 'required'
            ]);
        } else {
            $this->validate($request, [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'description' => 'required'
            ]);
        }

        if ($request->hasFile('avatar')) {
            $avatar = $request->avatar;

            $avatar_new_name = time() . $avatar->getClientOriginalName();

            $avatar->move('uploads/avatars', $avatar_new_name);

            $user->profile->avatar = '/uploads/avatars/' . $avatar_new_name;

        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->profile->description = $request->description;

        if ($request->has('password') == null) {
            $user->password = bcrypt($request->password);
        }

        $user->save();
        $user->profile->save();

        Session::flash('success', 'Profile successfully updateed.');

        return redirect()->back();
    }
}
