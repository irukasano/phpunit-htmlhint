<?php

namespace PHPUnitHmtlhint\Test;

use PHPUnitHmtlhint\LintTestTrait;
use PHPUnit\Framework\AssertionFailedError;

class LintTestTraitTest extends \PHPUnit\Framework\TestCase
{
    use LintTestTrait;

    public function testAssertHtmlhintOk_Ok()
    {
        $this->assertHtmlhintOk("<!DOCTYPE html><form></form>");
    }

    public function testAssertHtmlhintOk_Ng()
    {
        $this->expectException(AssertionFailedError::class);
        $this->expectExceptionMessageRegExp("/.+ must be in double quotes.+/");
        $this->assertHtmlhintOk("<!DOCTYPE html><form><input type=hidden></form>");
    }
}
