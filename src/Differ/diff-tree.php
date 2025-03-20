<?php

function mkAddedElementNode(string $key, mixed $value): array
{
    return [
        "key" => $key,
        "value" => $value,
        "type" => "added",
    ];
}

function mkRemovedElementNode(string $key, mixed $value): array
{
    return [
        "key" => $key,
        "value" => $value,
        "type" => "removed"
    ];
}

function mkUpdatedElementNode(string $key, mixed $oldValue, mixed $newValue): array
{
    return [
        "key" => $key,
        "oldValue" => $oldValue,
        "newValue" => $newValue,
        "type" => "updated"
    ];
}

function mkUnchangedElementNode(string $key, mixed $value): array
{
    return [
        "key" => $key,
        "value" => $value,
        "type" => "unchanged"
    ];
}

function mkNestedElementNode(string $key, array $nodes): array
{
    return [
        "key" => $key,
        "nodes" => $nodes,
        "type" => "nested"
    ];
}