<?php

use JakubOnderka\PhpVarDumpCheck;
use PHPUnit\Framework\TestCase;

class CheckTest extends TestCase
{
    protected static $uut;


    /**
     * @beforeClass
     */
    public static function initializeCheckerWithSettings()
    {
        $settings = new PhpVarDumpCheck\Settings();
        self::$uut = new PhpVarDumpCheck\Checker($settings);
    }


    public function testCheck_emptyFile_noDump()
    {
        $content = <<<PHP
<?php

PHP;
        $result = self::$uut->check($content);
        $this->assertCount(0, $result);
    }


    public function testCheck_singleVarDump_dump()
    {
        $content = <<<PHP
<?php
var_dump('Ahoj');
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
        $this->assertEquals('var_dump', $result[0]->getType());
        $this->assertTrue($result[0]->isSure());
        $this->assertEquals(2, $result[0]->getLineNumber());
    }


    public function testCheck_singlePrintR_dump()
    {
        $content = <<<PHP
<?php
print_r('Ahoj');
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
        $this->assertEquals('print_r', $result[0]->getType());
        $this->assertTrue($result[0]->isSure());
        $this->assertEquals(2, $result[0]->getLineNumber());
    }


    public function testCheck_singleVarExport_dump()
    {
        $content = <<<PHP
<?php
var_export('Ahoj');
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
        $this->assertEquals('var_export', $result[0]->getType());
        $this->assertTrue($result[0]->isSure());
        $this->assertEquals(2, $result[0]->getLineNumber());
    }


    /**
     * Function parsing
     */
    public function testCheck_templateSingleVarExport_dump()
    {
        $content = <<<PHP
var_export('Ahoj');
<?php
var_export('Ahoj');
?>
var_export('Ahoj');
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
        $this->assertEquals('var_export', $result[0]->getType());
        $this->assertTrue($result[0]->isSure());
        $this->assertEquals(3, $result[0]->getLineNumber());
    }


    public function testCheck_singleVarExportWhitespaces_dump()
    {
        $content = <<<PHP
<?php
var_export (  'Ahoj'
 ) ;
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
        $this->assertEquals('var_export', $result[0]->getType());
        $this->assertTrue($result[0]->isSure());
        $this->assertEquals(2, $result[0]->getLineNumber());
    }


    public function testCheck_singleVarExportWhitespaces_comments()
    {
        $content = <<<PHP
<?php
var_export /* v */ ( /* v */ 'Ahoj'/* v */
 ) ;
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
        $this->assertEquals('var_export', $result[0]->getType());
        $this->assertTrue($result[0]->isSure());
        $this->assertEquals(2, $result[0]->getLineNumber());
    }


    /**
     * Second parameters test
     */
    public function testCheck_singlePrintRWithReturnFalse_dump()
    {
        $content = <<<PHP
<?php
print_r('Ahoj', false);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
        $this->assertEquals('print_r', $result[0]->getType());
        $this->assertTrue($result[0]->isSure());
        $this->assertEquals(2, $result[0]->getLineNumber());
    }


    public function testCheck_singlePrintRWithReturnFalseComments_dump()
    {
        $content = <<<PHP
<?php
print_r('Ahoj'/**/,/**/false/**/);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
        $this->assertEquals('print_r', $result[0]->getType());
        $this->assertTrue($result[0]->isSure());
        $this->assertEquals(2, $result[0]->getLineNumber());
    }


    public function testCheck_singlePrintRWithReturnNull_dump()
    {
        $content = <<<PHP
<?php
print_r('Ahoj', null);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
        $this->assertEquals('print_r', $result[0]->getType());
        $this->assertTrue($result[0]->isSure());
        $this->assertEquals(2, $result[0]->getLineNumber());
    }


    public function testCheck_singlePrintRWithReturnIntZero_dump()
    {
        $content = <<<PHP
<?php
print_r('Ahoj', 0);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
        $this->assertEquals('print_r', $result[0]->getType());
        $this->assertTrue($result[0]->isSure());
        $this->assertEquals(2, $result[0]->getLineNumber());
    }


    public function testCheck_singlePrintRWithReturnFloatZero_dump()
    {
        $content = <<<PHP
<?php
print_r('Ahoj', 0.0);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
        $this->assertEquals('print_r', $result[0]->getType());
        $this->assertTrue($result[0]->isSure());
        $this->assertEquals(2, $result[0]->getLineNumber());
    }


    public function testCheck_singlePrintRWithReturnFalseVariableAssign_dump()
    {
        $content = <<<PHP
<?php
print_r('Ahoj', \$var = false);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
        $this->assertEquals('print_r', $result[0]->getType());
        $this->assertTrue($result[0]->isSure());
        $this->assertEquals(2, $result[0]->getLineNumber());
    }


    public function testCheck_staticMethodInOtherClass_ignore()
    {
        $content = <<<PHP
<?php
OtherClass::print_r('Ahoj');
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(0, $result);
    }


    public function testCheck_objectMethod_ignore()
    {
        $content = <<<PHP
<?php
\$object = new stdClass();
\$object->print_r('Ahoj');
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(0, $result);
    }


    public function testCheck_classMethod_ignore()
    {
        $content = <<<PHP
<?php
class print_r {
    public function print_r()
    {
        print_r('ahoj');
    }
}
\$object = new print_r();
\$object->print_r();
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
        $this->assertEquals('print_r', $result[0]->getType());
        $this->assertTrue($result[0]->isSure());
        $this->assertEquals(5, $result[0]->getLineNumber());
    }


    public function testCheck_debugRightAfterStart_dump()
    {
        $content = <<<PHP
<?php print_r('ahoj');
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
    }
}
