<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

function parseJson(string $filePath): mixed
{
    if (!realpath($filePath)) {
        return null;
    }

    $data = file_get_contents(realpath($filePath));
    return json_decode($data, true);
}

function parseYaml(string $filePath): mixed
{
    if (!realpath($filePath)) {
        return null;
    }

    return get_object_vars(Yaml::parseFile($filePath, Yaml::PARSE_OBJECT_FOR_MAP));
}

function getFileExtension(string $filePath): string
{
    [$path, $extension] = explode(".", $filePath);

    return $extension;
}

function printFileData(array $data): void
{
    var_dump($data);
}
