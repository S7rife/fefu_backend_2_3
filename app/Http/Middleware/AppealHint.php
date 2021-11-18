<?php

namespace App\Http\Middleware;

use App\Models\Settings;
use Closure;
use Illuminate\Http\Request;

class AppealHint
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->session()->get('appealed') !== true)
        {
            if ($request->session()->missing('attempts'))
            {
                $request->session()->put('attempts', 0);
                $request->session()->put('periodicity', 0);
            }
            $settings = app(Settings::class);

            if ($request->session()->get('attempts') < $settings->attempts)
            {
                if ($request->session()->get('periodicity') < $settings->periodicity)
                {
                    $request->session()->increment('periodicity');
                } else
                {
                    $request->session()->now('show_hint', true);
                    $request->session()->put('show_message', true);
                    $request->session()->increment('attempts');
                    $request->session()->put('periodicity', 0);
                }
            }
        }
        return $next($request);
    }
}
