<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

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
        if($this->checkIp($request->ip())) {
            return $next($request);
        }

        if($this->checkReferrer($request->header('referer'))) {
            return $next($request);
        }

        $hasBasicAuth = isset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);

        if($hasBasicAuth && $request->exists('logout')) {
            unset($_SERVER['PHP_AUTH_USER'], $_SERVER['PHP_AUTH_PW']);

            return redirect(
                to: $request->path(),
            );
        }

        if(!$hasBasicAuth) {
            $this->authErrorResponse();
        }

        if(!$this->checkCredential()) {
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

    private function checkCredential() : bool
    {
        $user = config('auth.basic_auth.user');
        $pass = config('auth.basic_auth.pass');

        if(!empty($user) && !empty($pass)) {
            return $user === $_SERVER['PHP_AUTH_USER'] && $pass === $_SERVER['PHP_AUTH_PW'];
        }

        return true;
    }

    private function checkReferrer(?string $url) : bool
    {
        if($url === null) {
            return false;
        }

        return parse_url($url, PHP_URL_PATH) === '/docs/api';
    }

    private function checkIp(?string $ip) : bool
    {
        if($ip === null) {
            return false;
        }

        if($ip === '127.0.0.1') {
            return true;
        }

        return in_array(
            needle: $ip,
            haystack: array_map('trim', explode(',', config('auth.basic_auth.ip_addresses'))),
            strict: true
        );
    }
}
