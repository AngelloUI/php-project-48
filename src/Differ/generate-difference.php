<?php

declare(strict_types=1);

namespace Differ\Differ;

function genDiff(string $filePath1, string $filePath2, string $format = 'stylish'): string
{
    $parsedData1 = (getFileExtension($filePath1) === "json") ? parseJson($filePath1) : parseYaml($filePath1);
    $parsedData2 = (getFileExtension($filePath2) === "json") ? parseJson($filePath2) : parseYaml($filePath2);

    return buildDiffTree($parsedData1, $parsedData2);
}

function buildDiffTree(array $parsedData1, array $parsedData2): string
{
    $diffTree = [];
    $keys = array_unique(array_merge(array_keys($parsedData1), array_keys($parsedData2)));
    sort($keys);

    $diffTree = array_reduce($keys, function ($diffTree, $key) use ($parsedData1, $parsedData2) {

        if (array_key_exists($key, $parsedData1) && array_key_exists($key, $parsedData2)) {
            if ($parsedData1[$key] === $parsedData2[$key]) {
                $diffTree["  $key"] = $parsedData1[$key];
            } else {
                $diffTree["- $key"] = $parsedData1[$key];
                $diffTree["+ $key"] = $parsedData2[$key];
            }
        } else {
            array_key_exists($key, $parsedData1) ?  $diffTree["- $key"] = $parsedData1[$key] : $diffTree["+ $key"] = $parsedData2[$key];
        }

        return $diffTree;
    }, []);

    return json_encode($diffTree);
}
