<?php

use App\Entity\VerifyUser;
use Illuminate\Database\Seeder;
use App\Entity\User;
use Carbon\Carbon;

class VerifySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::select('id')->where('role_id', 1)->where('status', 0)->get();
        foreach($users as $user){
            VerifyUser::create([
                'user_id' => $user->id,
                'token' => str_random(40),
                'expired_date' => Carbon::now()->addHours(Config::get('constants.options'))
            ]);
        }
    }
}