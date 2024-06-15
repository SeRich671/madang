<?php

namespace App\Http\Middleware;

use App\Enums\User\StatusEnum;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HasNoDeletedStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if(!$user || ($user->status !== StatusEnum::DELETED && $user->status !== StatusEnum::ARCHIVED)) {
            return $next($request);
        }

        Auth::logout();
        return redirect()->route('home')->with('error', 'Proszę o kontakt z firmą');
    }
}
