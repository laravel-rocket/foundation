<?php
namespace LaravelRocket\Foundation\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Collection;
use LaravelRocket\Foundation\Models\Base;
use LaravelRocket\Foundation\Repositories\BaseRepositoryInterface;

class BaseRepository implements BaseRepositoryInterface
{
    protected $cacheEnabled  = false;

    protected $cachePrefix   = 'model';

    protected $cacheLifeTime = 60; // Minutes

    public function getEmptyList()
    {
        return new Collection();
    }

    public function rules()
    {
        return [];
    }

    public function messages()
    {
        return [];
    }

    public function all($order = null, $direction = null)
    {
        $model = $this->getBlankModel();
        if (!empty($order)) {
            $direction = empty($direction) ? 'asc' : $direction;
            $model     = $model->orderBy($order, $direction);
        }

        return $model->get();
    }

    public function allByFilter($filter, $order = null, $direction = null)
    {
        $query = $this->buildQueryByFilter($this->getBlankModel(), $filter);
        if (!empty($order)) {
            $direction = empty($direction) ? 'asc' : $direction;
            $query     = $query->orderBy($order, $direction);
        }

        return $query->get();
    }

    public function getModelClassName()
    {
        $model = $this->getBlankModel();

        return get_class($model);
    }

    public function getBlankModel()
    {
        return new Base();
    }

    public function allEnabled($order = null, $direction = null)
    {
        $model = $this->getBlankModel();
        $query = $model->where('is_enabled', '=', true);
        if (!empty($order)) {
            $direction = empty($direction) ? 'asc' : $direction;
            $query     = $query->orderBy($order, $direction);
        }

        return $query->get();
    }

    public function get($order = 'id', $direction = 'asc', $offset = 0, $limit = 20)
    {
        $model = $this->getBlankModel();

        return $model->orderBy($order, $direction)->skip($offset)->take($limit)->get();
    }

    public function getByFilter($filter, $order = 'id', $direction = 'asc', $offset = 0, $limit = 20)
    {
        $query = $this->buildQueryByFilter($this->getBlankModel(), $filter);

        return $query->orderBy($order, $direction)->skip($offset)->take($limit)->get();
    }

    public function getEnabled($order = 'id', $direction = 'asc', $offset = 0, $limit = 20)
    {
        $model = $this->getBlankModel();

        return $model->where('is_enabled', '=', true)->orderBy($order, $direction)->skip($offset)->take($limit)->get();
    }

    public function count()
    {
        $model = $this->getBlankModel();

        return $model->count();
    }

    public function countByFilter($filter)
    {
        $query = $this->buildQueryByFilter($this->getBlankModel(), $filter);

        return $query->count();
    }

    public function countEnabled()
    {
        $model = $this->getBlankModel();

        return $model->where('is_enabled', '=', true)->count();
    }

    public function pluck($collection, $value, $key = null)
    {
        $items = [];
        foreach ($collection as $model) {
            if (empty($key)) {
                $items[] = $model->$value;
            } else {
                $items[$model->$key] = $model->$value;
            }
        }

        return Collection::make($items);
    }

    public function firstOrNew($attributes, $values = [])
    {
        $model = $this->getBlankModel();

        return $model->firstOrNew($attributes, $values);
    }

    public function firstOrCreate($attributes, $values = [])
    {
        $model = $this->getBlankModel();

        return $model->firstOrCreate($attributes, $values);
    }

    public function updateOrCreate($attributes, $values = [])
    {
        $model = $this->getBlankModel();

        return $model->updateOrCreate($attributes, $values);
    }

    /**
     * @param int[] $ids
     *
     * @return string
     */
    protected function getCacheKey($ids)
    {
        $key = $this->cachePrefix;
        foreach ($ids as $id) {
            $key .= '-'.$id;
        }

        return $key;
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     * @param string[]                           $orderCandidates
     * @param string                             $orderDefault
     * @param string                             $order
     * @param string                             $direction
     * @param int                                $offset
     * @param int                                $limit
     *
     * @return \Illuminate\Support\Collection
     */
    protected function getWithQueryBuilder(
        $query,
        $orderCandidates = [],
        $orderDefault = 'id',
        $order,
        $direction,
        $offset,
        $limit
    ) {
        $order     = strtolower($order);
        $direction = strtolower($direction);
        $offset    = intval($offset);
        $limit     = intval($limit);
        $order     = in_array($order, $orderCandidates) ? $order : strtolower($orderDefault);
        $direction = in_array($direction, ['asc', 'desc']) ? $direction : 'asc';

        if ($limit <= 0) {
            $limit = 10;
        }
        if ($offset < 0) {
            $offset = 0;
        }

        return $query->orderBy($order, $direction)->offset($offset)->limit($limit)->get();
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     * @param array                              $filter
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function buildQueryByFilter($query, $filter)
    {
        foreach ($filter as $column => $value) {
            if (is_array($value)) {
                $query = $query->whereIn($column, $value);
            } else {
                $query = $query->where($column, $value);
            }
        }

        return $query;
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     * @param string                             $order
     * @param string                             $direction
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function buildOrder($query, $order, $direction)
    {
        return $query->orderBy($order, $direction);
    }
}
