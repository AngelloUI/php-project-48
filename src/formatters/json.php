<?php
function formatterToJson(array $diffTree): string
{
    return json_encode($diffTree);
}