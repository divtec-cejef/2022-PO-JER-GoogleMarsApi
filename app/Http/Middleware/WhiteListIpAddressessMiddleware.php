<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 *
 */
class WhiteListIpAddressessMiddleware
{

    /**
     * @var string[]
     */
    public $whitelistIps = [
        '10.4.23.29' // IP Infomaniak
    ];


    /**
     * @param Request $request
     * @param Closure $next
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!in_array($request->getClientIp(), $this->whitelistIps)) {
            return response()->json(['status' => 'error', 'message' => 'Adresse IP non reconnue !'], 403);
        }
        return $next($request);
    }
}