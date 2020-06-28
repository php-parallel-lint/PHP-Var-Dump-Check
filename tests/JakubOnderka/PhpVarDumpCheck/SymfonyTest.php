<?php

use JakubOnderka\PhpVarDumpCheck;
use PHPUnit\Framework\TestCase;

class SymfonyTest extends TestCase
{
    protected static $uut;


    public static function setUpBeforeClass()
    {
        $settings = new PhpVarDumpCheck\Settings();
        $settings->functionsToCheck = array_merge($settings->functionsToCheck, [
            PhpVarDumpCheck\Settings::SYMFONY_VARDUMPER_HANDLER,
            PhpVarDumpCheck\Settings::SYMFONY_VARDUMPER_DUMP,
            PhpVarDumpCheck\Settings::SYMFONY_VARDUMPER_DUMP_SHORTCUT,
            PhpVarDumpCheck\Settings::SYMFONY_VARDUMPER_DD,
            PhpVarDumpCheck\Settings::SYMFONY_VARDUMPER_DD_SHORTCUT,
        ]);
        self::$uut = new PhpVarDumpCheck\Checker($settings);
    }


    public function testCheck_symfonyDebugDump()
    {
        $content = <<<PHP
<?php
VarDumper::dump(\$var);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
    }

    public function testCheck_symfonyDD()
    {
        $content = <<<PHP
<?php
VarDumper::dd(\$var);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
    }


    public function testCheck_symfonyDebugSetHandler()
    {
        $content = <<<PHP
<?php
VarDumper::setHandler(\$var);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
    }

    public function testCheck_symfonyDebugSetHandlerFunction()
    {
        $content = <<<PHP
<?php
VarDumper::setHandler(function(\\Exception \$e){

});
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
    }


    public function testCheck_symfonyDebugShortcutDump()
    {
        $content = <<<PHP
<?php
dump(\$var);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
    }


    public function testCheck_symfonyDDShortcut()
    {
        $content = <<<PHP
<?php
dd(\$var);
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(1, $result);
    }


    public function testCheck_symfonyDumpsWithNamespace()
    {
        $content = <<<PHP
<?php
\\dump(\$var);
\\Symfony\\Component\\VarDumper\\VarDumper::dump(\$var);
\\dd(\$var);
\\Symfony\\Component\\VarDumper\\VarDumper::dd(\$var);
\\Symfony\\Component\\VarDumper\\VarDumper::setHandler(\$var);
\\Symfony\\Component\\VarDumper\\VarDumper::setHandler(function(){

});
PHP;
        $result = self::$uut->check($content);
        $this->assertCount(6, $result);
    }
}
