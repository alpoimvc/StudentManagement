<?php

namespace App\Http\Middleware;

use Auth;
use App\User;
use Closure;
use Illuminate\Http\Response;

class AlunoMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() && ($request->user()->type == 'aluno'))
        {
            return $next($request);
        }
        return new Response(view('unauthorized')->with('role', 'ALUNO'));
    }
}
