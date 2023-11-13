<?php

declare(strict_types=1);

namespace App\Http\Integrations\GitHub;

use Saloon\Contracts\Authenticator;
use Saloon\Http\Auth\TokenAuthenticator;
use Saloon\Http\Connector;
use Saloon\Traits\Plugins\AcceptsJson;

class GitHubConnector extends Connector
{
    use AcceptsJson;

    /**
     * The Base URL of the API
     */
    public function resolveBaseUrl() : string
    {
        return 'https://api.github.com';
    }

    /**
     * Default headers for every request
     */
    protected function defaultHeaders() : array
    {
        return [
            'Accept' => 'application/vnd.github+json',
        ];
    }

    protected function defaultAuth() : ?Authenticator
    {
        return new TokenAuthenticator(config('github.token'));
    }
}
