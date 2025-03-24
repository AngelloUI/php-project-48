<?php

declare(strict_types=1);

namespace Test\Differ;

use PHPUnit\Framework\TestCase;

class DifferenceTreeFunctionsTest extends TestCase
{
    private array $diffTree;
    private string $filePath1;
    private string $filePath2;

    public function setUp(): void
    {
        $this->diffTree = [];
        $this->filePath1 = __DIR__ . "/fixtures/json/file1.json";
        $this->filePath2 = __DIR__ . "/fixtures/json/file2.json";
    }

    public function testMkAddedElementNode(): void
    {
        $expected = [
            'key' => 'name',
            'value' => 'Dmitry',
            'type' => 'added',
        ];

        $result = mkAddedElementNode('name', 'Dmitry');
        $this->assertSame($expected, $result);
    }

    public function testMkRemovedElementNode(): void
    {
        $expected = [
            'key' => 'age',
            'value' => 21,
            'type' => 'removed',
        ];

        $result = mkRemovedElementNode('age', 21);
        $this->assertSame($expected, $result);
    }

    public function testMkUpdatedElementNode(): void
    {
        $expected = [
            'key' => 'email',
            'oldValue' => 'dmitry01@gmail.com',
            'newValue' => 'elki@gmail.com',
            'type' => 'updated',
        ];

        $result = mkUpdatedElementNode('email', 'dmitry01@gmail.com', 'elki@gmail.com');
        $this->assertSame($expected, $result);
    }

    public function testMkUnchangedElementNode(): void
    {
        $expected = [
            'key' => 'address',
            'value' => 'asfklsa',
            'type' => 'unchanged',
        ];

        $result = mkUnchangedElementNode('address', 'asfklsa');
        $this->assertSame($expected, $result);
    }

    public function testMkNestedElementNode()
    {
        $nodes = [
            mkAddedElementNode('course', '4'),
            mkRemovedElementNode('depart', 'ii'),
        ];
        $expected = [
            'key' => 'university',
            'nodes' => $nodes,
            'type' => 'nested',
        ];

        $result = mkNestedElementNode('university', $nodes);
        $this->assertSame($expected, $result);
    }

    public function testBuildDiffTreeNoChanges()
    {
        $parsedData1 = parse($this->filePath1);
        $parsedData2 = parse($this->filePath2);
        $expected = [
            [
                'key' => 'follow',
                'value' => false,
                'type' => 'removed',
            ],
            [
                'key' => 'host',
                'value' => 'hexlet.io',
                'type' => 'unchanged',
            ],
            [
                'key' => 'proxy',
                'value' => '123.234.53.22',
                'type' => 'removed',
            ],
            [
                'key' => 'timeout',
                'oldValue' => 50,
                'newValue' => 20,
                'type' => 'updated',
            ],
            [
                'key' => 'verbose',
                'value' => true,
                'type' => 'added',
            ],
        ];

        $result = buildDiffTree($parsedData1, $parsedData2);
        $this->assertSame($expected, $result);
    }
}
