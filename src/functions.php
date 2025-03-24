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
    switch ($format) {
        case 'json':
            return formatterToJson($diffTree);
        case 'plain':
            return formatterToPlain($diffTree);
        case 'stylish':
            return formatterToStylish($diffTree);
    }

    return null;
}
