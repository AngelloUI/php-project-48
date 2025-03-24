<?php

declare(strict_types=1);

function parseJson(string $filePath): mixed
{
    $realPath = realpath($filePath);
    if ($realPath === false) {
        return null;
    }

    $data = file_get_contents($realPath);
    if ($data === false) {
        return null;
    }

    return json_decode($data, true);
}
