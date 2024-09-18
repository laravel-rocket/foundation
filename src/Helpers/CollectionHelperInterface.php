<?php

namespace LaravelRocket\Foundation\Helpers;

interface CollectionHelperInterface
{
    /**
     * Set Locale.
     */
    public function getSelectOptions(\Illuminate\Database\Eloquent\Collection $collection): array;
}
