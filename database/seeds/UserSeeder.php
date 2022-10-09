<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = "@Admin@123#";
        User::create(['f_name'=>'lakhmanis',
                      'l_name'=>'lakhmanis',
                      'user_name'=>'lakhmanis',
                      'provider'=>'general',
                      'provider_id'=>'general',
                      'email'=>'admin@gmail.com',
                      'email_verified_at'=>now() ,
                      'mobile_verified_at'=>now(),
                      'mobile'=>8887603331,
                      'roll_id'=>1,
                      'password'=>Hash::make($password),
                      'user_status'=>'A',
                      'wallet_amount'=>0,
                      'term_and_condition_status'=>1,
                      'is_signed'=>1,
                      'remember_token'=>222221,   
        ]);
        
    }
}
