<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Date;

class SetTimezone
{
    public function handle($request, Closure $next)
    {
        // Get the user's IP address
        $ip = $request->ip();
        
        // Call the ipinfo.io API or any other API to get the timezone
        $response = Http::get("http://ipinfo.io/{$ip}/json?token=9113f167aec40e");

        // If the request is successful and the timezone is available, set the timezone
        if ($response->successful()) {
            $data = $response->json();
            if (isset($data['timezone'])) {
                $timezone = $data['timezone'];
                // Set the application's timezone dynamically
                config(['app.timezone' => $timezone]);

                // Set the timezone for the current request
                date_default_timezone_set($timezone);
            }
        }

        // If no timezone is found or the API call fails, use the default timezone
        if (!isset($timezone)) {
            $timezone = config('app.timezone');
            config(['app.timezone' => $timezone]);
            date_default_timezone_set($timezone);
        }

        return $next($request);
    }
}
