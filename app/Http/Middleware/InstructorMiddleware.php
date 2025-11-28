<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class InstructorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && auth()->user()->isInstructor()) {
            return $next($request);
        }
        abort(403, 'Unauthorized. Instructor access required.');
    }
}
