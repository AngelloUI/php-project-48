<?php

function formatterToStylish(array $diff, int $depth = 1): string
{
    $indent = str_repeat("    ", $depth - 1);
    
    $result = array_merge(
        ["{"],
        ...array_map(function ($item) use ($depth, $indent) {
            $key = $item['key'];
            $type = $item['type'];

            return match ($type) {
                'added'    => ["$indent  + $key: " . formatValue($item['value'], $depth + 1)],
                'removed'  => ["$indent  - $key: " . formatValue($item['value'], $depth + 1)],
                'updated'  => [
                    "$indent  - $key: " . formatValue($item['oldValue'], $depth + 1),
                    "$indent  + $key: " . formatValue($item['newValue'], $depth + 1),
                ],
                'unchanged' => ["$indent    $key: " . formatValue($item['value'], $depth + 1)],
                'nested'    => ["$indent    $key: " . formatterToStylish($item['nodes'], $depth + 1)],
                default     => [],
            };
        }, $diff)
    );

    return implode("\n", $result) . "\n$indent}";
}


function formatValue($value, int $depth): string
{
    if (is_array($value)) {
        return formatterToStylish(array_map(fn($k, $v) => ['key' => $k, 'value' => $v, 'type' => 'unchanged'], array_keys($value), $value), $depth);
    }
    return match (gettype($value)) {
        'NULL' => 'null',
        'boolean' => $value ? 'true' : 'false',
        'string' => $value,
        default => (string) $value,
    };
}
