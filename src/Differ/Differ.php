<?php

declare(strict_types=1);

namespace Differ\Differ;

function genDiff(string $filePath1, string $filePath2, string $format = 'stylish'): string
{
    $parsedData1 = parse($filePath1);
    $parsedData2 = parse($filePath2);

    return formatter($format, buildDiffTree($parsedData1, $parsedData2));
}
