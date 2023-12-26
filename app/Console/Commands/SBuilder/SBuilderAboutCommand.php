<?php

declare(strict_types=1);

namespace App\Console\Commands\SBuilder;

use App\Http\Integrations\GitHub\GitHubConnector;
use App\Http\Integrations\GitHub\Requests\GetRepository;
use App\Services\StorageService;
use App\SoapPlugin;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use League\Flysystem\UnableToListContents;
use Symfony\Component\Console\Output\OutputInterface;

class SBuilderAboutCommand extends Command
{
    protected $signature = 'sbuilder:about';

    /**
     * @throws \Saloon\Exceptions\Request\FatalRequestException
     * @throws \Saloon\Exceptions\Request\RequestException
     */
    public function handle(StorageService $storageService) : int
    {
        $this->components->twoColumnDetail('URL:', config('sbuilder.url'), OutputInterface::VERBOSITY_QUIET);
        $this->components->twoColumnDetail('IP:', gethostbyname(parse_url(config('sbuilder.url'), PHP_URL_HOST)));


        if(Http::withoutVerifying()->get(config('sbuilder.url'))->ok()) {
            $this->components->twoColumnDetail('Connect status:', '<fg=green>Success</>');
        } else {
            $this->components->twoColumnDetail('Connect status:', '<fg=red>Failed</>');
        }

        $this->aboutFTP($storageService);
        $this->aboutDatabase();
        $this->aboutSoap();
        $this->aboutGitHub();

        return self::SUCCESS;
    }

    private function aboutFTP(StorageService $storageService) : void
    {
        $this->components->twoColumnDetail('<fg=green;options=bold>FTP</>');
        $this->components->twoColumnDetail('Host:', config('filesystems.disks.sbuilder-ftp.host'));
        $this->components->twoColumnDetail('Username:', config('filesystems.disks.sbuilder-ftp.username'));
        $this->components->twoColumnDetail('Password:', config('filesystems.disks.sbuilder-ftp.password'));
        $this->components->twoColumnDetail('Root:', config('filesystems.disks.sbuilder-ftp.root'));

        try {
            $storageService->ftp()->directories('/');

            $this->components->twoColumnDetail('FTP connection status:', '<fg=green>Success</>');
        } catch (UnableToListContents $exception) {
            $this->components->twoColumnDetail('FTP connection status:', '<fg=red>Failed</>');
            $this->components->twoColumnDetail('', "<fg=yellow>{$exception->getMessage()}</>");
        }
    }

    private function aboutDatabase() : void
    {
        $this->components->twoColumnDetail('<fg=green;options=bold>Database</>');
        $this->components->twoColumnDetail('Host:', config('database.connections.mysql-sbuilder.host'));
        $this->components->twoColumnDetail('database:', config('database.connections.mysql-sbuilder.database'));
        $this->components->twoColumnDetail('username:', config('database.connections.mysql-sbuilder.username'));
        $this->components->twoColumnDetail('Password:', config('database.connections.mysql-sbuilder.password'));

        try {
            DB::connection('mysql-sbuilder')->getPdo();

            $this->components->twoColumnDetail('Database connection status:', '<fg=green>Success</>');
        } catch (\PDOException $exception) {
            $this->components->twoColumnDetail('Database connection status:', '<fg=red>Failed</>');

            $this->components->twoColumnDetail('', "<fg=yellow>{$exception->getMessage()}</>");
        }
    }

    private function aboutSoap() : void
    {
        $this->components->twoColumnDetail('<fg=green;options=bold>Soap</>');
        $this->components->twoColumnDetail('Url', config('sbuilder.url') . '/cms/admin/soap.php?wsdl');
        $this->components->twoColumnDetail('Key', config('sbuilder.soap.key'));

        try {
            $this->laravel->make(SoapPlugin::class);

            $this->components->twoColumnDetail('Status', '<fg=green>Success</>');
        } catch (\SoapFault $exception) {
            $this->components->twoColumnDetail('Status', '<fg=red>Failed</>');

            $this->components->twoColumnDetail('', "<fg=yellow>{$exception->getMessage()}</>");
        }
    }

    /**
     * @throws \Saloon\Exceptions\Request\FatalRequestException
     * @throws \Saloon\Exceptions\Request\RequestException
     * @return void
     */
    private function aboutGitHub() : void
    {
        $this->components->twoColumnDetail('<fg=green;options=bold>GitHub</>');
        $this->components->twoColumnDetail('Owner', config('github.owner'));
        $this->components->twoColumnDetail('Repository', config('github.repo'));
        $this->components->twoColumnDetail('Token', config('github.token'));

        $response = GitHubConnector::make()->send(new GetRepository);

        if($response->ok()) {
            $this->components->twoColumnDetail('Status', '<fg=green>Success</>');
        } else {
            $this->components->twoColumnDetail('Status', '<fg=red>Failed</>');
        }
    }
}
