<?php

declare(strict_types=1);

function formatterToPlain(array $diffTree, string $parentPath = ''): string
{
    $lines = array_map(function ($node) use ($parentPath) {
        $propertyPath = $parentPath === '' ? $node['key'] : "{$parentPath}.{$node['key']}";

        switch ($node['type']) {
            case 'added':
                $value = valueToPlainFormat($node['value']);
                return "Property '{$propertyPath}' was added with value: {$value}";
            case 'removed':
                return "Property '{$propertyPath}' was removed";
            case 'updated':
                $oldValue = valueToPlainFormat($node['oldValue']);
                $newValue = valueToPlainFormat($node['newValue']);
                return "Property '{$propertyPath}' was updated. From {$oldValue} to {$newValue}";
            case 'nested':
                return formatterToPlain($node['nodes'], $propertyPath);
            case 'unchanged':
                return null;
        }

        return '';
    }, $diffTree);

    return implode("\n", array_filter($lines));
}

function valueToPlainFormat(mixed $value): string
{
    if (is_array($value)) {
        return "[complex value]";
    }

    if (is_bool($value)) {
        return $value ? 'true' : 'false';
    }

    if ($value === null) {
        return 'null';
    }

    if (is_string($value)) {
        return "'{$value}'";
    }

    return (string) $value;
}
