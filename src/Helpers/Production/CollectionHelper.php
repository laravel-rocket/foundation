<?php

namespace LaravelRocket\Foundation\Helpers\Production;

use LaravelRocket\Foundation\Helpers\CollectionHelperInterface;

class CollectionHelper implements CollectionHelperInterface
{
    public function getSelectOptions($collection)
    {
        return $collection->pluck('name', 'id')->toArray();
    }
}
