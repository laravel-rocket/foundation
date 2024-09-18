<?php

namespace LaravelRocket\Foundation\Repositories\Eloquent;

use LaravelRocket\Foundation\Repositories\RelationModelRepositoryInterface;

class RelationModelRepository extends SingleKeyModelRepository implements RelationModelRepositoryInterface
{
    protected string $parentKey = '';

    protected string $childKey = '';

    public function getRelationKeys(): array
    {
        return [$this->parentKey, $this->childKey];
    }

    public function findByRelationKeys($parentKey, $childKey)
    {
        $query = $this->getBaseQuery();
        $model = $query->where($this->getParentKey(), $parentKey)->where($this->getChildKey(), $childKey)->first();

        return $model;
    }

    public function getParentKey(): string
    {
        return $this->parentKey;
    }

    public function getChildKey(): string
    {
        return $this->childKey;
    }

    public function updateList($parentId, $childIds)
    {
        $currentChildIds = $this->allByParentKey($parentId)->pluck($this->getChildKey())->toArray();
        $deletes = array_diff($currentChildIds, $childIds);
        $adds = array_diff($childIds, $currentChildIds);

        if (count($deletes) > 0) {
            $query = $this->getBaseQuery();
            $query->where($this->getParentKey(), $parentId)->whereIn($this->getChildKey(), $deletes)->delete();
        }

        if (count($adds) > 0) {
            $parentKey = $this->getParentKey();
            $childKey = $this->getChildKey();
            foreach ($adds as $childId) {
                $this->create([
                    $parentKey => $parentId,
                    $childKey => $childId,
                ]);
            }
        }

        return true;
    }

    public function allByParentKey($parentId)
    {
        $query = $this->getBaseQuery();
        $models = $query->where($this->getParentKey(), $parentId)->get();

        return $models;
    }
}
