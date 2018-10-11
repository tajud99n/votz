<?php

namespace App\Http\Controllers;

use Auth;
use File;
use Hash;
use Session;
use JD\Cloudder\Facades\Cloudder;
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
            $result = $this->uploadImage($request);
            $user->profile->avatar = $result['url'];
            $user->profile->avatar_publicID = $result['public_id'];
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
        $avatar = $request->file('avatar');

        Cloudder::upload($avatar);

        $c = Cloudder::getResult();

        $old_profile = Auth::user()->profile;

        if ($old_profile->avatar_publicID)
        {
            Cloudder::destroyImage($old_profile->avatar_publicID);
            Cloudder::delete($old_profile->avatar_publicID); 
        }

        return $c;
    }
}
