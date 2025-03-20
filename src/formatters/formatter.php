<?php

function formatter(string $format, array $diffTree): ?string
{
    switch ($format) {
        case 'json':
            return formatterToJson($diffTree);
        case 'plain':
            return formatterToPlain($diffTree);
        case 'stylish':
            return formatterToStylish($diffTree);
    }
    return null;
}
