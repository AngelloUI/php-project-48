<?php

require_once __DIR__ . '/../vendor/autoload.php';

function getFileExtension(string $filePath): string
{
    [$path, $extension] = explode(".", $filePath);

    return $extension;
}

function printFileData(array $data): void
{
    var_dump($data);
}
