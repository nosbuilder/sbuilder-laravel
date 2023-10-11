<?php

declare(strict_types=1);

namespace App\Console\Commands\Telegram;

use Illuminate\Console\Command;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Laravel\Facades\Telegram;

class SendFileTelegramCommand extends Command
{
    protected $signature = 'telegram:send-file {chat} {filepath}';

    protected $description = 'Send file to telegram!';

    public function handle() : int
    {
        $filepath = base_path($this->argument('filepath'));

        if(!file_exists($filepath)) {
            $this->components->error('File not exists!');

            return self::FAILURE;
        }

        $name = basename($filepath) . '.txt';

        $file = InputFile::createFromContents(file_get_contents($filepath), $name);

        Telegram::sendDocument([
            'chat_id'  => $this->argument('chat'),
            'document' => $file,
        ]);

        return self::SUCCESS;
    }
}
