<?php

use JakubOnderka\PhpVarDumpCheck;
use PHPUnit\Framework\TestCase;

class TracyTest extends TestCase
{
    protected static $uut;


    public static function setUpBeforeClass()
    {
        $settings = new PhpVarDumpCheck\Settings();
        $settings->functionsToCheck = array_merge($settings->functionsToCheck, [
            PhpVarDumpCheck\Settings::DEBUGGER_DUMP,
            PhpVarDumpCheck\Settings::DEBUGGER_DUMP_SHORTCUT,
            PhpVarDumpCheck\Settings::DEBUGGER_BARDUMP,
            PhpVarDumpCheck\Settings::DEBUGGER_BARDUMP_SHORTCUT,
        ]);
        self::$uut = new PhpVarDumpCheck\Checker($settings);
    }


    public function testCheck_tracyDebugDump()
    {
        $content = <<<PHP
<?php
Debugger::dump(\$var);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
    }


    public function testCheck_tracyDebugBarDump()
    {
        $content = <<<PHP
<?php
Debugger::barDump(\$var);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
    }


    public function testCheck_tracyDebugShortcutDump()
    {
        $content = <<<PHP
<?php
dump(\$var);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
    }


    public function testCheck_tracyDebugShortcutBarDump()
    {
        $content = <<<PHP
<?php
bdump(\$var);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
    }


    public function testCheck_dumpsWithNamespace()
    {
        $content = <<<PHP
<?php
\\dump(\$var);
\\bdump(\$var);
\\Debugger::dump(\$var);
\\Debugger::barDump(\$var);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(4, $result);
    }
}
