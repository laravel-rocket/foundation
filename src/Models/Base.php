<?php
namespace LaravelRocket\Foundation\Models;

use Illuminate\Database\Eloquent\Model;
use LaravelRocket\Foundation\Presenters\BasePresenter;

class Base extends Model
{
    protected $presenterInstance;

    protected $presenter = BasePresenter::class;

    /**
     * @return string
     */
    public static function getTableName()
    {
        return with(new static())->getTable();
    }

    /**
     * @return string[]
     */
    public static function getFillableColumns()
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
    public function getEditableColumns()
    {
        return $this->fillable;
    }

    /**
     * @return string
     */
    public function getPrimaryKey()
    {
        return $this->primaryKey;
    }

    /**
     * @param string $key
     * @param string $locale
     *
     * @return string
     */
    public function getLocalizedColumn($key, $locale = 'en')
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
    public function toFillableArray()
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
    public function getDateColumns()
    {
        return $this->dates;
    }
}
