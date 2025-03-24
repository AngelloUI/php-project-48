<?php

declare(strict_types=1);

function getFileExtension(string $filePath): string
{
    [$path, $extension] = explode(".", $filePath);

    return $extension;
}

function mSort(array $array): array
{
    return array_reduce($array, function ($sorted, $item) {
        return array_merge(
            array_filter($sorted, fn($x) => $x < $item),
            [$item],
            array_filter($sorted, fn($x) => $x >= $item)
        );
    }, []);
}

function formatter(string $format, array $diffTree): ?string
{
    return match ($format) {
        'json' => formatterToJson($diffTree),
        'plain' => formatterToPlain($diffTree),
        'stylish' => formatterToStylish($diffTree),
        default => null,
    };
}

function parse(string $filePath): mixed
{
    return match (getFileExtension($filePath)) {
        'json' => parseJson($filePath),
        'yaml' => parseYaml($filePath),
        default => null,
    };
}
