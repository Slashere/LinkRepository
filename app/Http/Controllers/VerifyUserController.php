<?php

namespace App\Http\Controllers;

use App\Entity\VerifyUser;
use App\Mail\VerifyMail;
use App\Entity\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;


class VerifyUserController extends Controller
{
    public function updateExpiredTime($id)
    {
        $user = User::findOrFail($id);

        $verifyUser = VerifyUser::where('user_id', '=', $id)->first();
        $verifyUser->expired_date = Carbon::now()->addHours(Config::get('constants.options'));
        $verifyUser->save();

        VerifyMail::sendAuthCode($user);
        return redirect(route('login'))->with('message', 'We have sent you an activation code, please check your email.');
    }
}
