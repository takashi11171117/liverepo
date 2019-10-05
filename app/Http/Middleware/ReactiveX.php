<?php

namespace App\Http\Middleware;

use Closure;
use Rx\Scheduler;
use Rx\Scheduler\ImmediateScheduler;

class ReactiveX
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        $immediateScheduler = new ImmediateScheduler();
        Scheduler::setDefaultFactory(function () use ($immediateScheduler) {
            return $immediateScheduler;
        });

        return $next($request);
    }
}
