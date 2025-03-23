<?php

function getFileExtension(string $filePath): string
{
    [$path, $extension] = explode(".", $filePath);

    return $extension;
}
