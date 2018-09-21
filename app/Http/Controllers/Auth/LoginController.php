<?php

namespace App\Http\Controllers\Auth;

use Auth;
use App\User;
use App\Profile;
use Socialite;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->stateless()->user();

        $authUser = $this->findOrRegUser($user, $provider);

        Auth::login($authUser);

        return redirect($this->redirectTo);
    }

    public function findOrRegUser($user, $provider)
    {
        $authUser = User::where('email', $user->email)->first();

        return ($authUser) ? $authUser : $this->createUser($user, $provider);
    }

    public function createUser($user, $provider)
    {
        $account = User::create([
            'name'  => $user->name,
            'email' => $user->email,
            'provider'  => $provider,
            'provider_id'   => $user->id
        ]);

        $profile = new Profile;
        $profile->user_id = $account->id;
        $profile->avatar = $user->avatar;

        return $account;
    }
}
