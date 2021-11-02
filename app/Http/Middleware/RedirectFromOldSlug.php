<?php

namespace App\Http\Middleware;

use App\Models\Redirect;
use Closure;
use Illuminate\Http\Request;

class RedirectFromOldSlug
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
        $url = str_replace('news/', '', $request->path());

        $redirect = Redirect::where('old_slug', $url)
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->first();

        if ($redirect !== null)
        {
            $redirect2 = Redirect::where('old_slug', $redirect->new_slug)
                ->where('created_at', '>', $redirect->created_at)
                ->orderByDesc('created_at')
                ->orderByDesc('id')
                ->first();
            if ($redirect2 !== null)
            {
                return redirect()->route('news_item', ['slug' => $redirect2->new_slug]);
            }
            return redirect()->route('news_item', ['slug' => $redirect->new_slug]);
        }
        return $next($request);
    }
}
