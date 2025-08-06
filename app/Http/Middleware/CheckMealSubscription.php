<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;

class CheckMealSubscription
{
    public function handle($request, Closure $next)
    {
        // Check if student is authenticated via session
        if (session()->has('student_authenticated') && session()->has('subscription_data')) {
            $endDate = Carbon::parse(session('subscription_data.end_date'));
            
            // Clear expired subscription from session
            if ($endDate->isPast()) {
                session()->forget('subscription_data');
                session()->forget('has_active_subscription');
            }
        }
        
        return $next($request);
    }
}
