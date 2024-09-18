<?php

namespace LaravelRocket\Foundation\Helpers;

interface TypeHelperInterface
{
    public function getColumnTypeNameByValue(string $type, array $types, string $default = ''): string;

    public function getColumnTypes(string $table, string $column): array;
}
