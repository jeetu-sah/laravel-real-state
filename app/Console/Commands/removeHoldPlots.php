<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\SocietyPlotsNumber;
use App\User;
use Illuminate\Support\Facades\Hash;
use DB;
use App\OtpVerify;

class removeHoldPlots extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notify:removeholdstatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        OtpVerify::create(['mobile_number'=>8887603331 , 
                            'otp'=>123,
                            'otp_type'=>1,
                            'otp_verified_at'=>now()
                          ]);
        
        $plots=  SocietyPlotsNumber::where([['booking_status','=',2]])->get();
        if($plots->count() > 0){
            $plotArr = $plots->pluck('id')->all();
            SocietyPlotsNumber::whereIn('id',$plotArr)->update(['booking_status'=>1 , 'hold_date'=>NULL]);
        }
    }
}
