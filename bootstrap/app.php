<?php

use App\Console\Commands\ProcessPendingOrders;
use App\Http\Middleware\SetTimezone;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        channels: __DIR__ . '/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
        // $middleware->append(SetTimezone::class);
        $middleware->append([

            \ipinfo\ipinfolaravel\ipinfolaravel::class

        ]);
    })
    ->withSchedule(function (Schedule $schedule) {
        $schedule->command('orders:process')->everyMinute();
        $schedule->command('queue:run-once')->everyTwentySeconds();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
