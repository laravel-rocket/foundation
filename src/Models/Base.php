<?php
namespace LaravelRocket\Foundation\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelRocket\Foundation\Presenters\BasePresenter;

class Base extends Model
{
    protected ?BasePresenter $presenterInstance;

    protected string $presenter = BasePresenter::class;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->presenterInstance = null;
    }

    /**
     * @return string
     */
    public static function getTableName(): string
    {
        return with(new static())->getTable();
    }

    /**
     * @return string[]
     */
    public static function getFillableColumns(): array
    {
        return with(new static())->getFillable();
    }

    public function present()
    {
        if (!$this->presenterInstance) {
            $this->presenterInstance = new $this->presenter($this);
        }

        return $this->presenterInstance;
    }

    /**
     * @return string[]
     */
    public function getEditableColumns(): array
    {
        return $this->fillable;
    }

    /**
     * @return string
     */
    public function getPrimaryKey(): string
    {
        return $this->primaryKey;
    }

    /**
     * @param string $key
     * @param string $locale
     *
     * @return string
     */
    public function getLocalizedColumn(string $key, string $locale = 'en'): string
    {
        if (empty($locale)) {
            $locale = 'en';
        }
        $localizedKey = $key.'_'.strtolower($locale);
        $value        = $this->$localizedKey;
        if (empty($value)) {
            $localizedKey = $key.'_en';
            $value        = $this->$localizedKey;
        }

        return $value;
    }

    /**
     * @return array
     */
    public function toFillableArray(): array
    {
        $ret = [];
        foreach ($this->fillable as $key) {
            $ret[$key] = $this->$key;
        }

        return $ret;
    }

    /**
     * @return string[]
     */
    public function getDateColumns(): array
    {
        return $this->dates;
    }
}
