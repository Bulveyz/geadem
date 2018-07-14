<?php

namespace App\Http\Middleware;

use Closure;
use App\Channel as Channels;

class Channel
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
        $channel = $request->channel;

        if ($channel->access != 'All') {
            if ($channel->access == 'Password') {
                if (session()->has($channel->name . 'Access') || $channel->IsSubscribedTo) {
                    return $next($request);
                } else {
                    return redirect("/channel/access/{$channel->name}/password");
                }
            } elseif($channel->access == 'Private') {
              if ($channel->user_id == auth()->id()) {
                return $next($request);
              } else {
                return redirect('/');
              }
            }
        }
        return $next($request);
    }
}
