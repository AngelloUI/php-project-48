<?php

declare(strict_types=1);

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

function buildDiffTree(array $parsedData1, array $parsedData2): array
{
    $keys = array_unique(array_merge(array_keys($parsedData1), array_keys($parsedData2)));
    $sortedKeys = mSort(array_values($keys));
    return array_map(function ($key) use ($parsedData1, $parsedData2) {
        $value1 = $parsedData1[$key] ?? null;
        $value2 = $parsedData2[$key] ?? null;

        if (!array_key_exists($key, $parsedData1)) {
            return mkAddedElementNode($key, $value2);
        }

        if (!array_key_exists($key, $parsedData2)) {
            return mkRemovedElementNode($key, $value1);
        }

        if (is_array($value1) && is_array($value2)) {
            return mkNestedElementNode($key, buildDiffTree($value1, $value2));
        }

        if ($value1 === $value2) {
            return mkUnchangedElementNode($key, $value1);
        }

        return mkUpdatedElementNode($key, $value1, $value2);
    }, $sortedKeys);
}
