<?php
namespace LaravelRocket\Foundation\Presenters;

class BasePresenter
{
    /**
     * @var \LaravelRocket\Foundation\Models\Base
     */
    protected $entity;

    /** @var string */
    protected $toStringColumn = '';

    /**
     * @var string[]
     */
    protected $multilingualFields = [];

    /**
     * @param \LaravelRocket\Foundation\Models\Base $entity
     */
    public function __construct($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @param string $property
     *
     * @return mixed
     */
    public function __get($property)
    {
        if (method_exists($this, $property)) {
            return $this->$property();
        }

        if (in_array($property, $this->multilingualFields)) {
            return $this->entity->getLocalizedColumn($property);
        }

        return $this->entity->$property;
    }

    /**
     * @return mixed
     */
    public function toString()
    {
        $column = $this->toStringColumn;

        $value = $this->entity->$column;
        if (!empty($value)) {
            return $value;
        }

        return $this->entity->name;
    }
}
