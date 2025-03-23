<?php

function formatterToStylish(array $diff, int $depth = 1): string {
    $indent = str_repeat("    ", $depth - 1);
    $result = ["{"];

    foreach ($diff as $item) {
        $key = $item['key'];
        $type = $item['type'];
        
        switch ($type) {
            case 'added':
                $value = formatValue($item['value'], $depth + 1);
                $result[] = "$indent  + $key: $value";
                break;
            case 'removed':
                $value = formatValue($item['value'], $depth + 1);
                $result[] = "$indent  - $key: $value";
                break;
            case 'updated':
                $oldValue = formatValue($item['oldValue'], $depth + 1);
                $newValue = formatValue($item['newValue'], $depth + 1);
                $result[] = "$indent  - $key: $oldValue";
                $result[] = "$indent  + $key: $newValue";
                break;
            case 'unchanged':
                $value = formatValue($item['value'], $depth + 1);
                $result[] = "$indent    $key: $value";
                break;
            case 'nested':
                $nested = formatterToStylish($item['nodes'], $depth + 1);
                $result[] = "$indent    $key: $nested";
                break;
        }
    }

    $filteredResult = array_filter($result, fn($line) => trim($line) !== "");
    return implode("\n", $filteredResult) . "\n$indent}";
}

function formatValue($value, int $depth): string {
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
