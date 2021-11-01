<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Socialite;
use App\User;
use Auth;
use App\Jobs\Sms;

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

    protected $maxAttempts = 3;
    protected $decayMinutes = 5;

    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->scopes(['email'])->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();
        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        return redirect($this->redirectTo);
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('provider_id', $user->id)->first();
        if ($authUser) {
            return $authUser;
        }
        return User::create([
            'name'     => $user->name,
            'email'    => $user->email,
            'provider' => $provider,
            'provider_id' => $user->id
        ]);
    }

    /**
     * Sends an OTP to the user for logging in
     */
    public function otpSend(Request $request)
    {
        $user = User::where('phone_number', $request->phone_number)->first();
        $otp =  mt_rand(1000,9999);
        $user->password = Hash::make($otp);
        $user->save();

        $phone_number = $user->phone_number;
        $phone_number = substr($phone_number, -9);
        $phone_number = '0'.$phone_number;
        $message = 'Hello '.$user->first_name.'.SupamallEscrow has received your request to change your password. If this was not initiated by you, contact customer care to confirm any irregularities. If you did however request for a password change use the One-Time-Password "'.$otp . '" to login. Once logged in, head to your profile page and change your password to a more suitable one. Thank you for using SupamallEscrow';
        $SID = 'DEPTHSMS';
        Sms::dispatch($phone_number, $message, $SID )->onQueue('sms');

        return redirect('login')->with('success', 'Check your phone for the one-time-password');
    }

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::TRANSACTION;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function logout() {
        session()->flush();
        return Redirect('login');
        }
}
