<?php

use JakubOnderka\PhpVarDumpCheck;
use PHPUnit\Framework\TestCase;

class LadybugTest extends TestCase
{
    protected static $uut;


    /**
     * @beforeClass
     */
    public static function initializeCheckerWithSettings()
    {
        $settings = new PhpVarDumpCheck\Settings();
        $settings->functionsToCheck = array_merge($settings->functionsToCheck, [
            PhpVarDumpCheck\Settings::LADYBUG_DUMP,
            PhpVarDumpCheck\Settings::LADYBUG_DUMP_DIE,
            PhpVarDumpCheck\Settings::LADYBUG_DUMP_SHORTCUT,
            PhpVarDumpCheck\Settings::LADYBUG_DUMP_DIE_SHORTCUT,
        ]);
        self::$uut = new PhpVarDumpCheck\Checker($settings);
    }


    public function testCheck_ladybugDump()
    {
        $content = <<<PHP
<?php
ladybug_dump(\$var);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
    }


    public function testCheck_ladybugDumpDie()
    {
        $content = <<<PHP
<?php
ladybug_dump_die(\$var);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
    }


    public function testCheck_ladybugDumpShortcut()
    {
        $content = <<<PHP
<?php
ld(\$var);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
    }


    public function testCheck_ladybugDumpDieShortcut()
    {
        $content = <<<PHP
<?php
ldd(\$var);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
    }


    public function testCheck_dumpsWithNamespace()
    {
        $content = <<<PHP
<?php
\\ladybug_dump('Ahoj');
\\ladybug_dump_die('Ahoj');
\\ld('Ahoj');
\\ldd('Ahoj');
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(4, $result);
    }
}
