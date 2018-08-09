<?php

namespace App\Http\Middleware;

use Closure;
use App\Events;

class IsCreator
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
        $id =  $request->route('id');
        if(!$request->user()->is_admin || Events::find($id)->creator != $request->user()->id ){
            return response()->json(0, 403);
        }
        return $next($request);
    }
}
