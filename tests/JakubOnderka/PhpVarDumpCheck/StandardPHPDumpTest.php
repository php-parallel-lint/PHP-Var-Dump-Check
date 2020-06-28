<?php

use JakubOnderka\PhpVarDumpCheck;
use PHPUnit\Framework\TestCase;

class StandardPHPDumpTest extends TestCase
{
    protected static $uut;


    public static function setUpBeforeClass()
    {
        $settings = new PhpVarDumpCheck\Settings();
        self::$uut = new PhpVarDumpCheck\Checker($settings);
    }


    public function testCheck_singlePrintRWithReturnTrue_dump()
    {
        $content = <<<PHP
<?php
print_r('Ahoj', true);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(0, $result);
    }


    public function testCheck_singlePrintRWithCapitalizedReturnTrue_dump()
    {
        $content = <<<PHP
<?php
print_r('Ahoj', TRUE);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(0, $result);
    }


    public function testCheck_singlePrintRWithReturnIntOne_dump()
    {
        $content = <<<PHP
<?php
print_r('Ahoj', 1);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(0, $result);
    }


    public function testCheck_singlePrintRWithReturnFloatOne_dump()
    {
        $content = <<<PHP
<?php
print_r('Ahoj', 1.1);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(0, $result);
    }


    public function testCheck_singlePrintRWithReturnTrueVariableAssign_dum()
    {
        $content = <<<PHP
<?php
print_r('Ahoj', \$var = true);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(0, $result);
    }


    public function testCheck_singlePrintRWithReturnTrueMultipleVariableAssign_dum()
    {
        $content = <<<PHP
<?php
print_r('Ahoj', \$var = \$var2 =  true);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(0, $result);
    }


    public function testCheck_singleVarExportWithReturnTrue_dump()
    {
        $content = <<<PHP
<?php
var_export('Ahoj', true);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(0, $result);
    }


    public function testCheck_dumpsWithNamespace()
    {
        $content = <<<PHP
<?php
\\print_r('Ahoj');
\\var_dump('Ahoj');
\\var_export('Ahoj');
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(3, $result);
    }
}
