<?php

namespace App\Jobs\Middleware;

use Illuminate\Support\Facades\Redis;

class RateLimited
{
    /**
     * Process the queued job.
     *
     * @param  mixed  $job
     * @param  callable  $next
     * @return mixed
     */
    public function handle($job, $next)
    {
        Redis::throttle('mail_send')
                ->allow(config('mailness.sending_rate_limit.number_of_mails'))
                ->every(config('mailness.sending_rate_limit.number_of_mails_every'))
                ->then(function () use ($job, $next) {
                    $next($job);
                }, function () use ($job) {
                    $job->release(60);
                });
    }
}
