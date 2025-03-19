<?php

namespace Test\GenDiffer;

use PHPUnit\Framework\TestCase;
use function Differ\Differ\genDiff;

class GeneratorDifferenceTest extends TestCase
{
    public function testPlainJson(): void
    {
        $filePath1 = "file1.json";
        $filePath2 = "file2.json";
        $expected = '{"- follow":false,"  host":"hexlet.io","- proxy":"123.234.53.22","- timeout":50,"+ timeout":20,"+ verbose":true}';
        $actual = genDiff($filePath1, $filePath2);

        $this->assertEquals($expected, $actual);
    }


}