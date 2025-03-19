<?php

use Symfony\Component\Yaml\Yaml;

function parseYaml(string $filePath): mixed
{
    if (!realpath($filePath)) {
        return null;
    }

    return get_object_vars(Yaml::parseFile($filePath, Yaml::PARSE_OBJECT_FOR_MAP));
}
