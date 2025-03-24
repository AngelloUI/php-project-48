<?php

declare(strict_types=1);

namespace Test\Differ;

use PHPUnit\Framework\TestCase;

use function Differ\Differ\genDiff;

class GenerateDifferenceTreeTest extends TestCase
{
    private string $filePath1 = __DIR__ . "/fixtures/json/file1.json";
    private string $filePath2 = __DIR__ . "/fixtures/json/file2.json";
    private string $filePath3 = __DIR__ . "/fixtures/yaml/file1.yaml";
    private string $filePath4 = __DIR__ . "/fixtures/yaml/file2.yaml";

    public function testPlainJson(): void
    {
        $expected = "{\n  - follow: false\n    host: hexlet.io\n  - proxy: 123.234.53.22\n  - timeout: 50\n  + timeout: 20\n  + verbose: true\n}";
        $actual = genDiff($this->filePath1, $this->filePath2);

        $this->assertEquals($expected, $actual);
    }

    public function testPlainYaml(): void
    {
        $expected = "{\n  + eeee: false\n  - setting1: Value 1\n  + setting1: asd\n  - setting2: 200\n  - setting3: true\n    setting6: tree\n}";
        $actual = genDiff($this->filePath3, $this->filePath4);

        $this->assertEquals($expected, $actual);
    }
}
