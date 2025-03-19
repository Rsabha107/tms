<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckEventSelection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Log::info('CheckEventSelection');
        if (config('mds.check_event_selection')) {
            // Log::info('CheckEventSelection: Checking event selection: '. session()->has('EVENT_ID'));
            if (!session()->has('EVENT_ID') && auth()->check()) {
                if (auth()->user()->is_admin) {
                    return redirect()->route('tms.admin.booking.pick');
                } else {
                    return redirect()->route('tms.customer.booking.pick');
                }
                // return redirect()->route('mds.admin.booking.pick');
            }
        }
        return $next($request);
    }
}
