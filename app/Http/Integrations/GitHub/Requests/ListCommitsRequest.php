<?php

declare(strict_types=1);

namespace App\Http\Integrations\GitHub\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class ListCommitsRequest extends Request
{
    /**
     * The HTTP method of the request
     */
    protected Method $method = Method::GET;

    /**
     * The endpoint for the request
     */
    public function resolveEndpoint() : string
    {
        return sprintf(
            '/repos/%s/%s/commits',
            config('github.owner'),
            config('github.repo')
        );
    }
}
