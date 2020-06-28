<?php

use JakubOnderka\PhpVarDumpCheck;
use PHPUnit\Framework\TestCase;

class ZendTest extends TestCase
{
    protected static $uut;


    public static function setUpBeforeClass()
    {
        $settings = new PhpVarDumpCheck\Settings();
        $settings->functionsToCheck = array_merge($settings->functionsToCheck, [
            PhpVarDumpCheck\Settings::ZEND_DEBUG_DUMP,
            PhpVarDumpCheck\Settings::ZEND_DEBUG_DUMP_2,
        ]);

        self::$uut = new PhpVarDumpCheck\Checker($settings);
    }


    public function testCheck_zendDebugDump()
    {
        $content = <<<PHP
<?php
Zend_Debug::dump(\$var);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
    }


    public function testCheck_zendDebugDumpReturn()
    {
        $content = <<<PHP
<?php
Zend_Debug::dump(\$var, null, false);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
    }


    /**
     * Namespaces
     */
    public function testCheck_zendNamespaceDump()
    {
        $content = <<<PHP
<?php
\\Zend\\Debug\\Debug::dump(\$form);
PHP;

        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
    }
}
