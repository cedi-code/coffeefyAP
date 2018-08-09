<?php

namespace App\Http\Middleware;

use Closure;

class IsMemberOrCreator
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
        $requestEvent =  $request->route('event');
        if($requestEvent->creator == $request->user()->id ||$request->user()->is_admin) {
            return $next($request);
        }
        $events =  Eventmembers::select('event')->where("user", $request->user()->id)->get();
        foreach ($events as $event) {
            if($event->event == $requestEvent->id) {
                return $next($request);
            }
        }
        return response()->json(0, 403);
    }
}
