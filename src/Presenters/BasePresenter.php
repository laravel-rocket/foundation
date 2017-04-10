<?php
namespace LaravelRocket\Foundation\Presenters;

class BasePresenter
{
    /**
     * @var \LaravelRocket\Foundation\Models\Base
     */
    protected $entity;

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
        $app = app();

        if (method_exists($this, $property)) {
            return $this->$property();
        }

        if (in_array($property, $this->multilingualFields)) {
            return $this->entity->getLocalizedColumn($property);
        }

        return $this->entity->$property;
    }
}
