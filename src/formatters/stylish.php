<?php

function formatterToStylish(array $diffTree, int $depth = 1): string
{
    $indentSize = 4;
    $currentIndent = str_repeat(' ', max(0, $indentSize * ($depth - 1)));
    $lines = array_map(function ($node) use ($depth, $currentIndent) {
        $key = $node['key'];

        switch ($node['type']) {
            case 'added':
                return "{$currentIndent}+ {$key}: " . valueToStylishFotmat($node['value'], $depth);
            case 'removed':
                return "{$currentIndent}- {$key}: " . valueToStylishFotmat($node['value'], $depth);
            case 'unchanged':
                return "{$currentIndent}  {$key}: " . valueToStylishFotmat($node['value'], $depth);
            case 'updated':
                $oldValue = valueToStylishFotmat($node['oldValue'], $depth);
                $newValue = valueToStylishFotmat($node['newValue'], $depth);
                return "{$currentIndent}- {$key}: {$oldValue}\n{$currentIndent}+ {$key}: {$newValue}";
            case 'nested':
                $children = formatterToStylish($node['nodes'], $depth + 1);
                return "{$currentIndent}  {$key}: {\n{$children}\n{$currentIndent}  }";
        }

        return '';
    }, $diffTree);

    return implode("\n", $lines);
}

function valueToStylishFotmat($value, int $depth): string
{
    if (is_array($value)) {
        $indentSize = 4;
        $currentIndent = str_repeat(' ', $indentSize * $depth);
        $bracketIndent = str_repeat(' ', $indentSize * ($depth - 1));
        $lines = array_map(
            fn($key, $val) => "{$currentIndent}{$key}: " . valueToStylishFotmat($val, $depth + 1),
            array_keys($value),
            $value
        );

        return "{\n" . implode("\n", $lines) . "\n{$bracketIndent}}";
    }

    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    if ($value === null) {
        return 'null';
    }

    return (string) $value;
}
