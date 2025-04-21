<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckCandidateRole
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->role !== 'candidate') {
            return redirect()->route('home')->with('error', 'Accès non autorisé.');
        }

        return $next($request);
    }
}