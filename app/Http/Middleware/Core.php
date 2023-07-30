<?php

namespace App\Http\Middleware;

use Closure;

class Core
{

    public function handle($request, Closure $next)
    {

        $headers = [
            'Referrer-Policy' => 'no-referrer-when-downgrade',
            'X-Content-Type-Options' => 'nosniff', // provided by nginex
            'X-XSS-Protection' => '1; mode=block', // provided by nginex
            'X-Frame-Options' => 'SAMEORIGIN',
            'Strict-Transport-Security' => 'max-age=31536000; includeSubDomains',
            // 'Feature-Policy' => 'geolocation none;midi none;notifications none;push none;sync-xhr none;microphone none;camera none;magnetometer none;gyroscope none;speaker self;vibrate none;fullscreen self;payment none;',
            // 'Content-Security-Policy' => "default-src 'self' 'unsafe-inline' https://www.facebook.com  https://www.youtube.com https://www.google-analytics.com  https://img.youtube.com http://www.w3.org  https://www.google.com https://www.google.com.eg https://stats.g.doubleclick.net  https://clients1.google.com ; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://maxcdn.bootstrapcdn.com https://www.googletagmanager.com  https://static.doubleclick.net https://code.jquery.com https://connect.facebook.net  https://www.facebook.com https://www.google.com https://www.google-analytics.com https://cse.google.com ; font-src 'self' https://fonts.gstatic.com; media-src 'self' https://www.youtube.com https://drive.google.com https://docs.google.com  https://doc-08-7k-docs.googleusercontent.com; frame-ancestors 'self' https://www.youtube.com; connect-src 'self'  https://www.facebook.com; object-src 'self' https://www.youtube.com;  ",
        ];
        //  img-src 'self' data:image/svg+xml  https://www.google-analytics.com  https://www.google.com https://clients1.google.com https://www.facebook.com https://img.youtube.com


        if ($request->isMethod('OPTIONS'))
        {
            return response()->json('{"method":"OPTIONS"}', 200, $headers);
        }

        $response = $next($request);
        foreach($headers as $key => $value)
        {
            $response->header($key, $value);
        }

        return $response;

    }
}
