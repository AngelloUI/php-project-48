<?php

namespace Test\GenDiffer;

use PHPUnit\Framework\TestCase;
use function Differ\Differ\genDiff;

class GeneratorDifferenceTest extends TestCase
{
    public function testPlainJson(): void
    {
        $filePath1 = __DIR__ . "/fixtures/json/file1.json";
        $filePath2 = __DIR__ . "/fixtures/json/file2.json";
        $expected = '{"- follow":false,"  host":"hexlet.io","- proxy":"123.234.53.22","- timeout":50,"+ timeout":20,"+ verbose":true}';
        $actual = genDiff($filePath1, $filePath2);

        $this->assertEquals($expected, $actual);
    }

    public function testPlainYaml(): void
    {
        $filePath1 = __DIR__ . "/fixtures/yaml/file1.yaml";
        $filePath2 = __DIR__ . "/fixtures/yaml/file2.yaml";
        $expected = '{"+ eeee":false,"- setting1":"Value 1","+ setting1":"asd","- setting2":200,"- setting3":true,"  setting6":"tree"}';
        $actual = genDiff($filePath1, $filePath2);

        $this->assertEquals($expected, $actual);
    }

}