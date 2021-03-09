<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Log\Logger as BaseLogger;

/**
 * Log request's info
 */
class Logger
{
    private BaseLogger $logger;

    public function __construct(BaseLogger $logger)
    {
        $this->logger = $logger;
    }

    public function handle(Request $request, Closure $next)
    {
        $this->logger->debug(
            sprintf('Request [%s]: %s', $request->getMethod(), $request->getUri()),
            array_filter([
                'query' => $request->query->all(),
                'post' => $request->request->all(),
            ])
        );

        return $next($request);
    }
}
