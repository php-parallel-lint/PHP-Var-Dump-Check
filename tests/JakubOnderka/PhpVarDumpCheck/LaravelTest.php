<?php

use JakubOnderka\PhpVarDumpCheck;
use PHPUnit\Framework\TestCase;

class LaravelTest extends TestCase
{
    protected static $uut;


    public static function setUpBeforeClass()
    {
        $settings = new PhpVarDumpCheck\Settings();
        $settings->functionsToCheck = array_merge($settings->functionsToCheck, [
            PhpVarDumpCheck\Settings::LARAVEL_DUMP_DD,
            PhpVarDumpCheck\Settings::LARAVEL_DUMP,
        ]);
        self::$uut = new PhpVarDumpCheck\Checker($settings);
    }


    public function testCheck_laravelDumpDd()
    {
        $content = <<<PHP
<?php
dd(\$var);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
    }

    public function testCheck_laravelDump()
    {
        $content = <<<PHP
<?php
dump(\$var);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
    }
}
