<?php

namespace PHPUnitHmtlhint\Lint;

class Htmlhint extends BaseLint
{
    protected $command = "/usr/bin/htmlhint";
    protected $commandOptions = "-html";
}
