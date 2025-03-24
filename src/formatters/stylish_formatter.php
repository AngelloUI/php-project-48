<?php

declare(strict_types=1);

function formatterToStylish(array $diffTree, int $depth = 1): string
{
    $indent = str_repeat("    ", $depth - 1);

    $result = array_merge(
        ["{"],
        ...array_map(function ($node) use ($depth, $indent) {
            $key = $node['key'];
            $type = $node['type'];

            return match ($type) {
                'added'    => ["$indent  + $key: " . formatValue($node['value'], $depth + 1)],
                'removed'  => ["$indent  - $key: " . formatValue($node['value'], $depth + 1)],
                'updated'  => [
                    "$indent  - $key: " . formatValue($node['oldValue'], $depth + 1),
                    "$indent  + $key: " . formatValue($node['newValue'], $depth + 1),
                ],
                'unchanged' => ["$indent    $key: " . formatValue($node['value'], $depth + 1)],
                'nested'    => ["$indent    $key: " . formatterToStylish($node['nodes'], $depth + 1)],
                default     => [],
            };
        }, $diffTree)
    );

    return implode("\n", $result) . "\n$indent}";
}

function formatValue(mixed $value, int $depth): string
{
    if (is_array($value)) {
        return formatterToStylish(array_map(fn($k, $v) =>
        ['key' => $k, 'value' => $v, 'type' => 'unchanged'], array_keys($value), $value), $depth);
    }

    return match (gettype($value)) {
        'NULL' => 'null',
        'boolean' => $value ? 'true' : 'false',
        'string' => $value,
        default => (string) $value,
    };
}
