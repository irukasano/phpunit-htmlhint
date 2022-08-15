<?php

namespace PHPUnitHmtlhint\Lint;

class BaseLint
{
    protected $envPrefix;
    protected $defaultTempDirectory = "/tmp";
    protected $defaultTempPrefix = "lint";
    protected $defaultCommand;
    protected $defaultCommandOptions;
    protected $tempDirectory;
    protected $tempPrefix;
    protected $command;
    protected $commandOptions;

    protected $resultCode;
    protected $stdouts;

    public function __construct($check = null)
    {
        if (! is_null($check)) {
            $this->setup();
            $this->execute($check);
        }
    }

    public function setup(): void
    {
        $this->restoreFromDotenv();
        $this->existsCommand();
    }

    public function setEnvPrefix(string $prefix): void
    {
        $this->envPrefix = $prefix;
    }

    public function getTempDirectory(): string
    {
        return $this->tempDirectory;
    }

    public function getTempPrefix(): string
    {
        return $this->tempPrefix;
    }

    public function getCommand(): string
    {
        return $this->command;
    }

    public function getCommandOptions(): string
    {
        return $this->commandOptions;
    }

    public function getenv(string $name, ?string $default, bool $localOnly = false): ?string
    {
        $result = \getenv($name, $localOnly);
        if ($result) {
            return $result;
        }

        return $default;
    }

    public function restoreFromDotenv(): void
    {
        // .env から command, commandOptions, tempDirectory をセットする
        if (! $this->envPrefix) {
            return;
        }
        $this->tempDirectory = $this->getenv(
            "TEMP_DIR",
            $this->defaultTempDirectory
        );
        $this->tempPrefix = $this->getenv(
            "TEMP_PREFIX",
            $this->defaultTempPrefix
        );
        $this->command = $this->getenv(
            $this->envPrefix.'_COMMAND',
            $this->defaultCommand
        );
        $this->commandOptions = $this->getenv(
            $this->envPrefix.'_COMMAND_OPTIONS',
            $this->defaultCommandOptions
        );
    }

    public function existsCommand(): bool
    {
        if (! $this->command || ! file_exists($this->command)) {
            throw new \Exception(sprintf('command not found : %s', $this->command));
        }

        return true;
    }

    public function execute($check): void
    {
        // $check の内容を一時ファイルにしてコマンドを実行し、
        // 実行結果を stdouts, stderrs に格納し、一時ファイルを最後に消す
        $tempFilename = tempnam($this->tempDirectory, $this->tempPrefix);
        file_put_contents($tempFilename, $check);

        $command = sprintf(
            "%s %s %s",
            $this->command,
            $this->commandOptions,
            $tempFilename,
        );
        $this->exec($command, $this->stdouts, $this->resultCode);

        unlink($tempFilename);
    }

    //public function exec(string $command, string $cwd, &$stdouts, &$stderrs): void
    public function exec(string $command, &$stdouts, &$resultCode): void
    {
        /*
        $descriptorspec = [
            //0 => ["pipe", "r"],  // stdin
            1 => ["pipe", "w"],  // stdout
            2 => ["pipe", "w"],  // stderr
        ];

        $process = proc_open($command, $descriptorspec, $pipes, $cwd, null);
        $stdouts = $this->explode(stream_get_contents($pipes[1]));
        fclose($pipes[1]);
        $stderrs = $this->explode(stream_get_contents($pipes[2]));
        fclose($pipes[2]);
        proc_close($process);
         */

        exec($command, $stdouts, $resultCode);
    }

    public function explode(string $lines)
    {
        $empty = true;
        $result = [];
        $arr = explode("\n", $lines);
        foreach ($arr as $v) {
            $vv = trim($v);
            $result[] = $vv;
            if ($vv) {
                $empty = false;
            }
        }

        if ($empty) {
            $result = [];
        }

        return $result;
    }

    public function hasErrors(): bool
    {
        return $this->resultCode != 0;
    }

    public function getStdouts()
    {
        return $this->stdouts;
    }
}
