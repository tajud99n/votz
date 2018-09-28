<?php

namespace App\Http\Controllers;

use Auth;
use File;
use Hash;
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

        if ($request->password && $request->new_password) {
            if ($this->checkAndUpdatePassword($request, $user->password)) {
                $user->password = $this->checkAndUpdatePassword($request, $user->password);
            } else {
                return redirect()->back()->withErrors('Current password do not match');
            }
        }

        if ($request->hasFile('avatar')) {
            $user->profile->avatar = $this->uploadImage($request);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->profile->description = $request->description;

        $user->save();
        $user->profile->save();

        Session::flash('success', 'Profile successfully updateed.');

        return redirect()->back();
    }

    protected function checkAndUpdatePassword($request,$old_password)
    {
        if (Hash::check($request->password, $old_password)) {
            $password = Hash::make($request->new_password);
            return $password;
        }

        return false;
    }

    protected function uploadImage($request)
    {
        $avatar = $request->avatar;

        $avatar_new_name = time() . $avatar->getClientOriginalName();

        $avatar->move('uploads' . DIRECTORY_SEPARATOR .'profile', $avatar_new_name);

        $old_profile = Auth::user()->profile;

        $upload = DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . 'profile' . DIRECTORY_SEPARATOR . $avatar_new_name;

        if (File::exists(public_path() . $old_profile->avatar))
        {
            File::delete(public_path() . $old_profile->avatar); 
        }

        return $upload;
    }
}
