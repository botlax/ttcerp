<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\User;
use App\License;
use App\Visa;
use App\Settings;
use App\Vacation;
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

            $settings = Settings::first();

            $from = Carbon::today()->addDays($settings->hc);
            $to = Carbon::today()->addDays($settings->hc + 1);

            $hcs = User::sort()->where('hc_expiry','>=',$from)->where('hc_expiry','<=',$to)->orderBy('hc_expiry','DESC')->get();

            $from = Carbon::today()->addDays($settings->qid);
            $to = Carbon::today()->addDays($settings->qid + 1);

            $qids = User::sort()->where('qid_expiry','>=',$from)->where('qid_expiry','<=',$to)->orderBy('qid_expiry','DESC')->get();

            $from = Carbon::today()->addDays($settings->passport);
            $to = Carbon::today()->addDays($settings->passport + 1);

            $passports = User::sort()->where('passport_expiry','>=',$from)->where('passport_expiry','<=',$to)->orderBy('passport_expiry','DESC')->get();

            $from = Carbon::today()->addDays($settings->license);
            $to = Carbon::today()->addDays($settings->license + 1);

            $lics = License::where('expiry_date','>=',$from)->where('expiry_date','<=',$to)->orderBy('expiry_date','DESC')->get();

            $from = Carbon::today()->addDays($settings->visa);
            $to = Carbon::today()->addDays($settings->visa + 1);

            $visas = Visa::where('visa_expiry_date','>=',$from)->where('visa_expiry_date','<=',$to)->orderBy('visa_expiry_date','DESC')->get();

            $from = Carbon::today()->subDays($settings->vac);
            $to = Carbon::today()->subDays($settings->vac + 1);

            $vac = Vacation::where('vac_from','>=',$from)->where('vac_to','<=',$to)->orderBy('vac_from','DESC')->get();

            $data['hcs'] = $hcs;
            $data['qids'] = $qids;
            $data['passports'] = $passports;
            $data['lics'] = $lics;
            $data['visas'] = $visas;
            $data['vac'] = $vac;

            $admins = User::admin()->get();
            
            if(!empty($hcs->toArray()) || !empty($qids->toArray()) || !empty($passports->toArray()) || !empty($lics->toArray()) || !empty($visas->toArray()) || !empty($vac->toArray())){
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
