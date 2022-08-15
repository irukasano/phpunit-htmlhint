<?php

namespace PHPUnitHmtlhint\Test\Lint;

use PHPUnitHmtlhint\Lint\Htmlhint;

class HtmlhintTest extends \PHPUnit\Framework\TestCase
{
    protected $app;

    public function setup()
    {
        $this->app = new Htmlhint(null);
    }

    public function testExecute_Valid()
    {
        $this->app->setup();
        $this->app->execute("<!DOCTYPE html><h1>Hello</h1>");

        $this->assertFalse($this->app->hasErrors());
        $this->assertEmpty($this->app->getStdouts());
    }

    public function testExecute_NotValid()
    {
        $this->app->setup();
        $this->app->execute("<!DOCTYPE html><h1>Hello<div></h1>");

        $this->assertTrue($this->app->hasErrors());
        $this->assertNotEmpty($this->app->getStdouts());
        $this->assertContains("Tag must be paired", implode("\n", $this->app->getStdouts()));
    }
}
