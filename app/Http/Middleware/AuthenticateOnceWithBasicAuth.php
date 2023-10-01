<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use function Psy\debug;

class AuthenticateOnceWithBasicAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next)
    {
        if($request->exists('logout')) {
            unset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);

            return redirect(
                to: $request->path(),
            );
        }

        if(!isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW'])) {
            $this->authErrorResponse();
        }

        $user = User::query()
            ->where(
                column: 'u_email',
                operator: '=',
                value: $_SERVER['PHP_AUTH_USER'],
            )
            ->where(
                column: 'u_pass',
                operator: '=',
                value: md5(string: $_SERVER['PHP_AUTH_PW'])
            )
            ->exists();

        if(!$user) {
            $this->authErrorResponse();
        }

        return $next($request);
    }

    private function authErrorResponse() : void
    {
        abort(
            code: 401,
            message: __('Unauthorized'),
            headers: [
                'WWW-Authenticate' => 'Basic realm="Restricted Area"',
            ]
        );
    }
}
