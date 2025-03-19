<?php

function parseJson(string $filePath): mixed
{
    if (!realpath($filePath)) {
        return null;
    }

    $data = file_get_contents(realpath($filePath));

    return json_decode($data, true);
}
