<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Console\Scheduling\Schedule;

// $delaySchedules = DB::table('whatsapp_servers')->get();

// app(Schedule::class)->tap(function (Schedule $schedule) use ($delaySchedules) {
//     foreach ($delaySchedules as $delay) {
//         $delayInMinutes = ceil($delay->delay / 60); // Konversi ke menit jika delay dalam detik
//         $schedule->command("queue:work --stop-when-empty")
//             ->everyMinutes($delayInMinutes) // Gunakan delay dari kolom
//             ->withoutOverlapping()
//             ->description("Queue Worker for Server {$delay->name}");
//     }
// });