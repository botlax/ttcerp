<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\User;
use App\License;
use App\Visa;
use App\Notifications\Expired;
use Illuminate\Support\Facades\Notification;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {

            $from = Carbon::today()->addDays(30);
            $to = Carbon::today()->addDays(31);

            $hcs = User::sort()->where('hc_expiry','>=',$from)->where('hc_expiry','<=',$to)->orderBy('hc_expiry','DESC')->get();
            $qids = User::sort()->where('qid_expiry','>=',$from)->where('qid_expiry','<=',$to)->orderBy('qid_expiry','DESC')->get();
            $passports = User::sort()->where('passport_expiry','>=',$from)->where('passport_expiry','<=',$to)->orderBy('passport_expiry','DESC')->get();
            $lics = License::where('expiry_date','>=',$from)->where('expiry_date','<=',$to)->orderBy('expiry_date','DESC')->get();
            $visas = Visa::where('visa_expiry_date','>=',$from)->where('visa_expiry_date','<=',$to)->orderBy('visa_expiry_date','DESC')->get();

            $data['hcs'] = $hcs;
            $data['qids'] = $qids;
            $data['passports'] = $passports;
            $data['lics'] = $lics;
            $data['visas'] = $visas;

            $admins = User::admin()->get();
            
            if(!empty($hcs->toArray()) || !empty($qids->toArray()) || !empty($passports->toArray()) || !empty($lics->toArray()) || !empty($visas->toArray())){
                Notification::send($admins, new Expired($data));
            }

        })->daily();
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
