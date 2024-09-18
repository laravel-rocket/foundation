<?php

namespace LaravelRocket\Foundation\Presenters;

class BasePresenter
{
    protected \LaravelRocket\Foundation\Models\Base $entity;

    protected string $toStringColumn = '';

    /**
     * @var string[]
     */
    protected array $multilingualFields = [];

    public function __construct(\LaravelRocket\Foundation\Models\Base $entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return mixed
     */
    public function __get(string $property)
    {
        if (method_exists($this, $property)) {
            return $this->$property();
        }

        if (in_array($property, $this->multilingualFields)) {
            return $this->entity->getLocalizedColumn($property);
        }

        return $this->entity->$property;
    }

    public function toString(): mixed
    {
        $column = $this->toStringColumn;

        $value = $this->entity->$column;
        if (! empty($value)) {
            return $value;
        }

        return $this->entity->name;
    }
}
