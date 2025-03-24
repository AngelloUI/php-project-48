<?php

declare(strict_types=1);

function formatterToJson(array $diffTree): string
{
    return json_encode($diffTree, JSON_PRETTY_PRINT);
}
