<?php
namespace LaravelRocket\Foundation\Helpers\Production;

use Illuminate\Database\Eloquent\Collection;
use LaravelRocket\Foundation\Helpers\CollectionHelperInterface;

class CollectionHelper implements CollectionHelperInterface
{
    public function getSelectOptions(Collection $collection): array
    {
        return $collection->pluck('name', 'id')->toArray();
    }
}
