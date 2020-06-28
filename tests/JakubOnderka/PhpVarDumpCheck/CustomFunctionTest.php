<?php

use JakubOnderka\PhpVarDumpCheck;
use PHPUnit\Framework\TestCase;

class CustomFunctionTest extends TestCase
{

    public function testCheck_noDebugFunction()
    {
        $settings = new PhpVarDumpCheck\Settings();

        $settings->functionsToCheck = array_merge($settings->functionsToCheck, array(
            'functionName1'
        ));

        $uut     = new PhpVarDumpCheck\Checker($settings);
        $content = <<<PHP
<?php
nonDebugFunction1(\$var);
\$i++;
nonDebugFunction2(\$i);
PHP;
        $result = $uut->check($content);
        $this->assertCount(0, $result);
    }

    public function testCheck_singleFunction()
    {
        $settings = new PhpVarDumpCheck\Settings();

        $settings->functionsToCheck = array_merge($settings->functionsToCheck, array(
            'functionName1'
        ));

        $uut     = new PhpVarDumpCheck\Checker($settings);
        $content = <<<PHP
<?php
functionName1(\$var);
PHP;
        $result = $uut->check($content);
        $this->assertCount(1, $result);
    }


    public function testCheck_multipleFunction()
    {
        $settings = new PhpVarDumpCheck\Settings();

        $settings->functionsToCheck = array_merge($settings->functionsToCheck, array(
            'functionName1',
            'functionName2'
        ));

        $uut     = new PhpVarDumpCheck\Checker($settings);

        $content1 = <<<PHP
<?php
functionName1(\$var);
PHP;
        $content2 = <<<PHP
<?php
functionName2(\$var);
PHP;
        $content3 = <<<PHP
<?php
functionName1(\$var);
sleep(4);
functionName2(\$var);
PHP;
        $result = $uut->check($content1);
        $this->assertCount(1, $result);

        $result = $uut->check($content2);
        $this->assertCount(1, $result);

        $result = $uut->check($content3);
        $this->assertCount(2, $result);
    }
}
