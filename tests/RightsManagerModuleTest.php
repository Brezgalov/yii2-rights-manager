<?php

use PHPUnit\Framework\TestCase;

class RightsManagerModuleTest extends TestCase
{
    public function testPushAndPop()
    {
        $app = \Yii::$app;
        $stack = [];
        $this->assertNotEmpty($stack);
    }
}