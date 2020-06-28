<?php

use JakubOnderka\PhpVarDumpCheck;
use PHPUnit\Framework\TestCase;

class DoctrineTest extends TestCase
{
    protected static $uut;


    /**
     * @beforeClass
     */
    public static function initializeCheckerWithSettings()
    {
        $settings = new PhpVarDumpCheck\Settings();
        $settings->functionsToCheck = array_merge($settings->functionsToCheck, [
            PhpVarDumpCheck\Settings::DOCTRINE_DUMP,
            PhpVarDumpCheck\Settings::DOCTRINE_DUMP_2,
        ]);

        self::$uut = new PhpVarDumpCheck\Checker($settings);
    }


    public function testCheck_zendDebugDump()
    {
        $content = <<<PHP
<?php
Doctrine::dump(\$var);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
    }


    public function testCheck_zendDebugDumpReturn()
    {
        $content = <<<PHP
<?php
Doctrine::dump(\$var, null, false);
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
\\Doctrine\\Common\\Util\\Debug::dump(\$form);
PHP;

        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
    }
}
