<?php

namespace App\Http\Middleware;
use Closure;

class Front
{

    public function handle($request, Closure $next)
    {

        // Chek if User loged in
        if (! auth()->check()) {
          if ( $request->expectsJson() ) {
            // get response format
            return response()->json( ['response'=> ['error' => trans('auth.unauthorized')]], 401 );
          } else {
            return redirect()->route('front.login')->withErrors([trans('auth.unauthorized')]);
          }
        }


        // Check if User Active
        if( $request->user()->is_active  == 0 || $request->user()->is_active_admin == 0 ) {
          if ( $request->expectsJson() ) {
            return response()->json( ['response'=> ['error' => trans('auth.in_active')]], 401 );
          } else {
            auth()->logout();
            return redirect()->route('front.login')->withErrors([trans('auth.in_active')]);
          }
        }


        if (auth()->user()->isVerified(0)){
          return redirect()->route('front.verifications.show');
        }


        return $next($request);

    }
}
