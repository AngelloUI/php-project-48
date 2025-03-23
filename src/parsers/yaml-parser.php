<?php

use Symfony\Component\Yaml\Yaml;

function parseYaml(string $filePath): mixed
{
    if (!realpath($filePath)) {
        return null;
    }

    return Yaml::parseFile($filePath, Yaml::PARSE_EXCEPTION_ON_INVALID_TYPE);
}
