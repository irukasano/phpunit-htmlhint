<?php

namespace PHPUnitHmtlhint\Lint;

class Htmlhint extends BaseLint
{
    protected $envPrefix = "HTMLHINT";
    protected $defaultTempPrefix = "htmlhint";
    protected $defaultCommand = "/usr/bin/htmlhint";
    protected $defaultCommandOptions = "";

    public function execute($check): void
    {
        parent::execute($check);

        // stdout を整形 resultCode = 0 なら空にする
        if ($this->resultCode == 0) {
            $this->stdouts = [];
        }
    }

    public function getStdouts()
    {
        $wStdouts = $this->stdouts;

        // resultCode != 0 なら２行目を空にする
        // エラー時の２行目はファイル名
        if ($this->resultCode != 0) {
            unset($wStdouts[1]);
        }

        return $wStdouts;
    }
}
