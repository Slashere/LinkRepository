<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Entity\User;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Mail\VerifyMail;
use App\Entity\VerifyUser;
use Illuminate\Support\Facades\Config;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Get the needed authorization credentials from the request.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function authenticated(Request $request, User $user)
    {
        if (!$user->status) {
            $this->guard()->logout();

            $verifyUser = VerifyUser::where('user_id', '=', $user->id)->first();

            if ($verifyUser == null) {

                VerifyUser::create([
                    'user_id' => $user->id,
                    'token' => str_random(40),
                    'expired_date' => Carbon::now()->addHours(Config::get('constants.options'))
                ]);

                VerifyMail::sendAuthCode($user);
                return back()->with('message', 'You need to confirm your account. We have sent you an activation code, please check your email.');
            } else {
                return view('auth.code',compact('user'));
            }

        }
        return redirect()->intended($this->redirectPath());
    }
}
