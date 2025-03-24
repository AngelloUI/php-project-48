<?php

declare(strict_types=1);

use Symfony\Component\Yaml\Yaml;

function parseYaml(string $filePath): mixed
{
    $realPath = realpath($filePath);
    if ($realPath === false) {
        return null;
    }

    return Yaml::parseFile($realPath, Yaml::PARSE_EXCEPTION_ON_INVALID_TYPE);
}
