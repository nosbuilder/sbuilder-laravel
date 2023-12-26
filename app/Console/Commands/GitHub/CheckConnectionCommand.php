<?php

declare(strict_types=1);

namespace App\Console\Commands\GitHub;

use App\Http\Integrations\GitHub\GitHubConnector;
use App\Http\Integrations\GitHub\Requests\GetRepository;
use Illuminate\Console\Command;

class CheckConnectionCommand extends Command
{
    protected $signature = 'github:check';

    /**
     * @throws \Saloon\Exceptions\Request\FatalRequestException
     * @throws \Saloon\Exceptions\Request\RequestException
     * @return int
     */
    public function handle() : int
    {
        $response = GitHubConnector::make()->send(new GetRepository);

        if(!$response->ok()) {
            $this->components->error('Connect error! Status: ' . $response->status());

            return self::FAILURE;
        }

        $this->components->info('Connect success!');

        return self::SUCCESS;
    }
}
