<?php

namespace App\Http\Middleware;

use Closure;

class ChooseService
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!session()->has('branch_id') && !session()->has('address_branch_id')){
            session()->put('status','not');
            return redirect('menu');
        }

        return $next($request);
    }
}
