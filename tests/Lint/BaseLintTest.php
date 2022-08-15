<?php

namespace PHPUnitHmtlhint\Test\Lint;

use PHPUnitHmtlhint\Lint\BaseLint;

class BaseLintTest extends \PHPUnit\Framework\TestCase
{
    protected $app;

    public function setup()
    {
        $this->app = new BaseLint(null);
    }

    public function tearDown()
    {
        \putenv("TEMP_DIR=");
        \putenv("TEMP_PREFIX=");
        \putenv("TEST_COMMAND=");
        \putenv("TEST_COMMAND_OPTIONS=");
    }

    public function testOk()
    {
        $this->assertTrue(1==1);
    }

    public function testGetEnv_notDefault()
    {
        $r = \putenv("TEST_KEY=notDefaultValue");
        $this->assertTrue($r);

        $value = $this->app->getenv("TEST_KEY", "defaultValue");
        $this->assertEquals("notDefaultValue", $value);
    }

    public function testGetEnv_default()
    {
        $r = \putenv("TEST_KEY=");
        $this->assertTrue($r);

        $value = $this->app->getenv("TEST_KEY", "defaultValue");
        $this->assertEquals("defaultValue", $value);
    }

    public function testGetEnv_defaultByNotSet()
    {
        $value = $this->app->getenv("TEST_KEY", "defaultValue");
        $this->assertEquals("defaultValue", $value);
    }

    public function testRestoreFromDotenv()
    {
        \putenv("TEMP_DIR=/user/local");
        \putenv("TEMP_PREFIX=temp");
        \putenv("TEST_COMMAND=/some/test/command");
        \putenv("TEST_COMMAND_OPTIONS=-opt1 -opt2");


        $this->app->setEnvPrefix("TEST");
        $this->app->restoreFromDotenv();

        $this->assertEquals("/user/local", $this->app->getTempDirectory());
        $this->assertEquals("temp", $this->app->getTempPrefix());
        $this->assertEquals("/some/test/command", $this->app->getCommand());
        $this->assertEquals("-opt1 -opt2", $this->app->getCommandOptions());
    }

    public function testExistsCommand_NotExists()
    {
        \putenv("TEST_COMMAND=/some/test/command");
        $this->app->setEnvPrefix("TEST");
        $this->app->restoreFromDotenv();

        $this->assertEquals("/some/test/command", $this->app->getCommand());
        $this->expectExceptionMessage("command not found : /some/test/command");

        $this->app->existsCommand();
    }

    public function testExistsCommand_Exists()
    {
        \putenv("TEST_COMMAND=/bin/ls");
        $this->app->setEnvPrefix("TEST");
        $this->app->restoreFromDotenv();

        $this->assertEquals("/bin/ls", $this->app->getCommand());

        $r = $this->app->existsCommand();
        $this->assertTrue($r);
    }

    public function testExplode_NotEmpty()
    {
        $r = $this->app->explode("aaaa\nbbbb");
        $this->assertEquals("aaaa", $r[0]);
        $this->assertEquals("bbbb", $r[1]);
    }

    public function testExplode_NotEmptyWithBlankLine()
    {
        $r = $this->app->explode("aaaa\n\nbbbb");
        $this->assertEquals("aaaa", $r[0]);
        $this->assertEquals("", $r[1]);
        $this->assertEquals("bbbb", $r[2]);
    }

    public function testExplode_Empty()
    {
        $r = $this->app->explode("");
        $this->assertEmpty($r);
    }

    public function testExplode_EmptyWithBlankLines()
    {
        $r = $this->app->explode("\n  \n");
        $this->assertEmpty($r);
    }
}
