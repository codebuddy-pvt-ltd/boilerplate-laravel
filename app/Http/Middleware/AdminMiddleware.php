<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Services\Http\Response\APIResponse;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var User */
        $user = Auth::user();

        if (!Auth::check() || !optional($user)->isSuperAdmin()) {
            if (isRequestForAPI()) {
                return APIResponse::build()
                    ->status('error')
                    ->message('You do not have the rights to access this endpoint!')
                    ->send();
            }

            return redirect()->route('admin.login.index');
        }

        return $next($request);
    }
}
