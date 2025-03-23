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
        $expected = "{\n  - follow: false\n    host: hexlet.io\n  - proxy: 123.234.53.22\n  - timeout: 50\n  + timeout: 20\n  + verbose: true\n}";
        $actual = genDiff($filePath1, $filePath2);

        $this->assertEquals($expected, $actual);
    }

    public function testPlainYaml(): void
    {
        $filePath1 = __DIR__ . "/fixtures/yaml/file1.yaml";
        $filePath2 = __DIR__ . "/fixtures/yaml/file2.yaml";
        $expected = "{\n  + eeee: false\n  - setting1: Value 1\n  + setting1: asd\n  - setting2: 200\n  - setting3: true\n    setting6: tree\n}";
        $actual = genDiff($filePath1, $filePath2);

        $this->assertEquals($expected, $actual);
    }

}