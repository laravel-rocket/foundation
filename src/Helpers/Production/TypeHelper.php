<?php

namespace LaravelRocket\Foundation\Helpers\Production;

use Illuminate\Support\Arr;
use LaravelRocket\Foundation\Helpers\TypeHelperInterface;

class TypeHelper implements TypeHelperInterface
{
    public function getColumnTypeNameByValue(string $type, array $types, $default = ''): string
    {
        foreach ($types as $info) {
            if ($info['value'] === $type) {
                return trans(Arr::get($info, 'name'));
            }
        }

        return $default;
    }

    public function getColumnTypes(string $table, string $column): array
    {
        $ret = [];
        $types = config('data.tables.'.$table.'.columns.'.$column.'.options', []);
        foreach ($types as $key => $name) {
            $ret[$key] = trans($name);
        }

        return $ret;
    }
}
