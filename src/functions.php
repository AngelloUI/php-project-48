<?php

function getFileExtension(string $filePath): string
{
    [$path, $extension] = explode(".", $filePath);

    return $extension;
}

function MSort(array $array): array
{
    return array_reduce($array, function ($sorted, $item) {
        return array_merge(
            array_filter($sorted, fn($x) => $x < $item),
            [$item],
            array_filter($sorted, fn($x) => $x >= $item)
        );
    }, []);
}
