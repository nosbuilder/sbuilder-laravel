<?php

namespace App\Console\Commands\GitHub;

use App\Http\Integrations\GitHub\GitHubConnector;
use App\Http\Integrations\GitHub\Requests\ListCommitsRequest;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GetLastCommitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'github:last-commit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @param  \App\Http\Integrations\GitHub\GitHubConnector  $connector
     *
     * @throws \ReflectionException
     * @throws \Throwable
     * @return int
     */
    public function handle(GitHubConnector $connector) : int
    {
        $response = $connector->send(new ListCommitsRequest);

        if(!$response->ok()) {
            return self::FAILURE;
        }

        $sha = $response->json('0.sha');

        if(blank($sha)) {
            return self::FAILURE;
        }

        Storage::put('last_commit', substr($sha, 0, 7));

        $this->components->info('OK');

        return self::SUCCESS;
    }
}
