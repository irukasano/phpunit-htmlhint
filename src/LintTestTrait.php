<?php

namespace PHPUnitHmtlhint;

use PHPUnitHmtlhint\Constraint\Htmlhint;
use PHPUnitHmtlhint\Lint\Htmlhint as LintHtmlhint;

trait LintTestTrait
{
    public function assertHtmlhintOk($html, $message=null)
    {
        $lint = new LintHtmlhint($html);
        $this->assertThat($lint, new Htmlhint(), $message);
    }
}
