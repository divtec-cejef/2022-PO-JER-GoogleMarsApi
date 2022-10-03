<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Support\Facades\DB;

/**
 *
 */
class ResponsableMiddleware
{
    /**
     * @var Auth
     */
    protected $auth;

    /**
     * @param Auth $auth
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param $request
     * @param Closure $next
     * @param $guard
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $user = $request->user();

        if ($this->auth->guard($guard)->guest() or !DB::table('responsable')->where('user_id', '=', $user->id)->where('badge_id', '=', $request->badgeId)->exists()) {
            return response()->json(['status' => 'error', 'message' => 'Accès responsable non autorisé'], 401);
        }
        return $next($request);
    }


}