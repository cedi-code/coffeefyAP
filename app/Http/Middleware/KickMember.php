<?php

namespace App\Http\Middleware;

use Closure;
use App\Events;

class KickMember
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
        $eid = $request->event;
        if($request->user()->is_admin ||
            Events::find($eid)->creator == $request->user()->id ||
            $request->user()->id == $id) {
            return $next($request);

        }
        return response()->json(0, 403);

    }
}
