<?php
namespace LaravelRocket\Foundation\Helpers;

interface TypeHelperInterface
{
    /**
     * @param string $type
     * @param array  $types
     * @param string $default
     *
     * @return string
     */
    public function getColumnTypeNameByValue(string $type, array $types, string $default = ''): string;

    /**
     * @param string $table
     * @param string $column
     *
     * @return array
     */
    public function getColumnTypes(string $table, string $column): array;
}
