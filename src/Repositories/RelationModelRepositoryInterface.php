<?php

namespace LaravelRocket\Foundation\Repositories;

interface RelationModelRepositoryInterface extends SingleKeyModelRepositoryInterface
{
    /**
     * @return array
     */
    public function getRelationKeys();

    /**
     * @return string
     */
    public function getParentKey();

    /**
     * @return string
     */
    public function getChildKey();

    /**
     * @param  int  $parentKey
     * @param  int  $childKey
     * @return \LaravelRocket\Foundation\Models\Base|null
     */
    public function findByRelationKeys($parentKey, $childKey);

    /**
     * @param  int  $parentKey
     * @return \LaravelRocket\Foundation\Models\Base[]|\Illuminate\Database\Eloquent\Collection
     */
    public function allByParentKey($parentKey);

    /**
     * @param  int  $parentKey
     * @param  array  $childKeys
     * @return bool
     */
    public function updateList($parentKey, $childKeys);
}
