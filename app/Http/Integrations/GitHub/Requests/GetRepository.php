<?php

declare(strict_types=1);

namespace App\Http\Integrations\GitHub\Requests;

use Saloon\Enums\Method;
use Saloon\Http\Request;

class GetRepository extends Request
{
    protected Method $method = Method::GET;

    /**
     * @inheritDoc
     */
    public function resolveEndpoint() : string
    {
        return sprintf(
            '/repos/%s/%s',
            config('github.owner'),
            config('github.repo')
        );
    }
}
