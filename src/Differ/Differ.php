<?php

declare(strict_types=1);

namespace Differ\Differ;

function genDiff(string $filePath1, string $filePath2, string $format = 'stylish'): string
{
    $parsedData1 = (getFileExtension($filePath1) === "json") ? parseJson($filePath1) : parseYaml($filePath1);
    $parsedData2 = (getFileExtension($filePath2) === "json") ? parseJson($filePath2) : parseYaml($filePath2);

    return formatter($format, buildDiffTree($parsedData1, $parsedData2));
}
