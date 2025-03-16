<?php
function parse(string $filePath): mixed
{
    if (!realpath($filePath)) {
        return null;
    }
    
    $data = file_get_contents(realpath($filePath));
    return json_decode($data, true);
}

function printFileData(array $data): void
{
    var_dump($data);
}