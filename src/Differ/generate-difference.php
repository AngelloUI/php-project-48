<?php

declare(strict_types=1);

namespace Differ\Differ;

function genDiff(string $filePath1, string $filePath2, string $format = 'stylish'): string
{
    $parsedData1 = (getFileExtension($filePath1) === "json") ? parseJson($filePath1) : parseYaml($filePath1);
    $parsedData2 = (getFileExtension($filePath2) === "json") ? parseJson($filePath2) : parseYaml($filePath2);

    return formatter($format, buildDiffTree($parsedData1, $parsedData2));
}

function buildDiffTree(array $parsedData1, array $parsedData2): array
{
    $keys = array_unique(array_merge(array_keys($parsedData1), array_keys($parsedData2)));
    /*
    $sortedKeys = array_values($keys);
    usort($sortedKeys, fn($a, $b) => $a <=> $b);
    */
    $sortedKeys = MSort(array_values($keys));
    return array_map(function ($key) use ($parsedData1, $parsedData2) {
        $value1 = $parsedData1[$key] ?? null;
        $value2 = $parsedData2[$key] ?? null;

        if (!array_key_exists($key, $parsedData1)) {
            return mkAddedElementNode($key, $value2);
        }

        if (!array_key_exists($key, $parsedData2)) {
            return mkRemovedElementNode($key, $value1);
        }

        if (is_array($value1) && is_array($value2)) {
            return mkNestedElementNode($key, buildDiffTree($value1, $value2));
        }

        if ($value1 === $value2) {
            return mkUnchangedElementNode($key, $value1);
        }

        return mkUpdatedElementNode($key, $value1, $value2);
    }, $sortedKeys);
}
