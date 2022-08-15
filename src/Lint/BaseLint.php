<?php

namespace PHPUnitHmtlhint\Lint;

class BaseLint
{
    protected $command;
    protected $commandOptions;
    protected $tempDirectory = "/tmp";

    protected $hasErrors = false;
    protected $stdouts = [];
    protected $stderrs = [];

    public function __construct($check = null)
    {
        $this->setup();
        if (!is_null($check)) {
            $this->execute($check);
        }
    }

    public function setup(): void
    {
        $this->restoreFromDotenv();
    }

    public function restoreFromDotenv(): void
    {
        // .env から command, commandOptions, tempDirectory をセットする
    }

    public function execute($check): void
    {
        // $check の内容を一時ファイルにしてコマンドを実行し、
        // 実行結果を stdouts, stderrs に格納し、一時ファイルを最後に消す
    }

    public function hasErrors(): bool
    {
        return $this->hasErrors;
    }

    public function getErrors()
    {
        return [];
    }
}
