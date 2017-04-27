<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    //任務排程
    protected function schedule(Schedule $schedule)
    {
        //更換賽馬首頁圖片
        $schedule->call(function () {
            $rank = array();
            $horseCount = 3;
            $count = 0;
            while ($count < $horseCount) {
                $number = rand(1, $horseCount);
                if (!in_array($number, $rank)) {  //去陣列重複值
                    $rank[$count] = $number;
                    $count++;
                    DB::table('photo')
                        ->where('num', $count)
                        ->update(['photo' => $number.'.jpg']);
                }
            }
        })->everyTenMinutes(); //十分鐘/次
    }
}
