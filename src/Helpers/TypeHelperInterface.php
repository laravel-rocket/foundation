<?php namespace LaravelRocket\Foundation\Helpers;

interface TypeHelperInterface
{
    /**
     * @param  string $type
     * @param  array  $list
     * @return string
     */
    public function getTypeName($type, $list);

    /**
     * @param  string $table
     * @param  string $key
     * @return array
     */
    public function getTypeList($table, $key);

}
