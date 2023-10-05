<?php

namespace App\Traits;

/**
 * @mixin \Illuminate\Console\Command
 */
trait EnvironmentKeyReplacementPattern
{
    protected function keyReplacementPattern(string $envKey, string $configKey) : string
    {
        $escaped = preg_quote('=' . $this->laravel['config'][$configKey], '/');

        return "/^$envKey$escaped/m";
    }

    protected function getEnvironment() : string
    {
        return file_get_contents($this->laravel->environmentFilePath());
    }

    protected function replaceKeyValue(string $envKey, string $configKey, string $value) : bool
    {
        $input = $this->getEnvironment();

        preg_match($this->keyReplacementPattern($envKey, $configKey), $input, $matches);

        if(empty($matches)) {
            $this->error(sprintf('Unable to set %s. No %s variable was found in the .env file.', $configKey, $envKey));

            return false;
        }

        $replaced = preg_replace(
            $this->keyReplacementPattern($envKey, $configKey),
            "$envKey=$value",
            $input,
        );

        file_put_contents($this->laravel->environmentFilePath(), $replaced);

        return true;
    }

    private function replaceKey(string $argumentKey, string $envKey, string $configKey, string $question = null, bool $secret = false) : bool
    {
        $question ??= $argumentKey;

        $value = $this->argument($argumentKey);
        if($value === null) {
            $value = $secret ? $this->secret($question) : $this->components->ask($question, data_get($this->laravel['config'], $configKey));
        }

        return $this->replaceKeyValue($envKey, $configKey, $value);
    }
}
