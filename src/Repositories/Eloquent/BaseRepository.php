<?php
namespace LaravelRocket\Foundation\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Arr;
use LaravelRocket\Foundation\Models\Base;
use LaravelRocket\Foundation\Repositories\BaseRepositoryInterface;

class BaseRepository implements BaseRepositoryInterface
{
    protected $cacheEnabled = false;

    protected $cachePrefix = 'model';

    protected $cacheLifeTime = 60; // Minutes

    protected $querySearchTargets = [];

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
        $query = $this->getBaseQuery();
        if (!empty($order)) {
            $direction = empty($direction) ? 'asc' : $direction;
            $query     = $query->orderBy($order, $direction);
        }

        $query = $this->queryOptions($query);

        return $query->get();
    }

    public function allByFilterQuery($filter, $order = null, $direction = null)
    {
        $query = $this->buildQueryByFilter($this->getBaseQuery(), $filter);

        return $this->buildOrder($query, $filter, $order, $direction);
    }

    public function allByFilter($filter, $order = null, $direction = null)
    {
        $query = $this->allByFilterQuery($filter, $order, $direction);

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

    public function getBaseQuery()
    {
        return $this->getBlankModel();
    }

    public function allEnabled($order = null, $direction = null)
    {
        $model = $this->getBaseQuery();
        $query = $model->where('is_enabled', '=', true);
        if (!empty($order)) {
            $direction = empty($direction) ? 'asc' : $direction;
            $query     = $query->orderBy($order, $direction);
        }

        $query = $this->queryOptions($query);

        return $query->get();
    }

    public function get($order = 'id', $direction = 'asc', $offset = 0, $limit = 20, $before = 0, $after = 0)
    {
        $query = $this->getBaseQuery();

        $query = $this->setBefore($query, $order, $direction, $before);
        $query = $this->setAfter($query, $order, $direction, $after);
        $query = $this->queryOptions($query);

        return $query->orderBy($order, $direction)->skip($offset)->take($limit)->get();
    }

    public function getByFilter($filter, $order = 'id', $direction = 'asc', $offset = 0, $limit = 20, $before = 0, $after = 0)
    {
        $query = $this->buildQueryByFilter($this->getBaseQuery(), $filter);
        $query = $this->setBefore($query, $order, $direction, $before);
        $query = $this->setAfter($query, $order, $direction, $after);
        $query = $this->buildOrder($query, $filter, $order, $direction);

        return $query->skip($offset)->take($limit)->get();
    }

    public function getEnabled($order = 'id', $direction = 'asc', $offset = 0, $limit = 20, $before = 0, $after = 0)
    {
        $query = $this->getBaseQuery();
        $query = $this->setBefore($query, $order, $direction, $before);
        $query = $this->setAfter($query, $order, $direction, $after);
        $query = $this->queryOptions($query);

        return $query->where('is_enabled', '=', true)->orderBy($order, $direction)->skip($offset)->take($limit)->get();
    }

    public function count()
    {
        $model = $this->getBaseQuery();

        return $model->count();
    }

    public function countByFilter($filter)
    {
        $query = $this->buildQueryByFilter($this->getBaseQuery(), $filter);

        return $query->count();
    }

    public function countEnabled()
    {
        $model = $this->getBaseQuery();

        return $model->where('is_enabled', '=', true)->count();
    }

    public function firstByFilter($filter)
    {
        $query = $this->buildQueryByFilter($this->getBaseQuery(), $filter);

        return $query->first();
    }

    public function updateByFilter($filter, $values)
    {
        $query = $this->buildQueryByFilter($this->getBaseQuery(), $filter);
        $count = $query->update($values);

        return $count;
    }

    public function getSQLByFilter($filter)
    {
        $query = $this->buildQueryByFilter($this->getBaseQuery(), $filter);

        return $query->toSql();
    }

    public function deleteByFilter($filter)
    {
        $query = $this->buildQueryByFilter($this->getBaseQuery(), $filter);

        return $query->delete();
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
        $model = $this->getBaseQuery();

        return $model->firstOrNew($attributes, $values);
    }

    public function firstOrCreate($attributes, $values = [])
    {
        $model = $this->getBaseQuery();

        return $model->firstOrCreate($attributes, $values);
    }

    public function updateOrCreate($attributes, $values = [])
    {
        $model = $this->getBaseQuery();

        return $model->updateOrCreate($attributes, $values);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     * @param string                             $order
     * @param string                             $direction
     * @param mixed                              $before
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function setBefore($query, $order, $direction, $before)
    {
        if ($before == 0) {
            return $query;
        }

        return $query->where($order, ($direction === 'desc' ? '>' : '<'), $before);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     * @param string                             $order
     * @param string                             $direction
     * @param mixed                              $after
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function setAfter($query, $order, $direction, $after)
    {
        if ($after == 0) {
            return $query;
        }

        return $query->where($order, ($direction === 'desc' ? '<' : '>'), $after);
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

        $query = $this->buildOrder($query, [], $order, $direction);

        $query = $this->queryOptions($query);

        return $query->offset($offset)->limit($limit)->get();
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     * @param array                              $filter
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function buildQueryByFilter($query, $filter)
    {
        $tableName = $this->getBlankModel()->getTable();

        $query = $this->queryOptions($query);

        if (count($this->querySearchTargets) > 0 && array_key_exists('query', $filter)) {
            $searchWord = Arr::get($filter, 'query');
            if (!empty($searchWord)) {
                $query = $query->where(function($q) use ($searchWord) {
                    foreach ($this->querySearchTargets as $index => $target) {
                        if ($index === 0) {
                            $q = $q->where($target, 'LIKE', '%'.$searchWord.'%');
                        } else {
                            $q = $q->orWhere($target, 'LIKE', '%'.$searchWord.'%');
                        }
                    }
                });
            }
            unset($filter['query']);
        }

        foreach ($filter as $column => $value) {
            if (is_array($value)) {
                $query = $query->whereIn($tableName.'.'.$column, $value);
            } else {
                $query = $query->where($tableName.'.'.$column, $value);
            }
        }

        return $query;
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     * @param array                              $filter
     * @param string                             $order
     * @param string                             $direction
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function buildOrder($query, $filter, $order, $direction)
    {
        if (!empty($order)) {
            $direction = empty($direction) ? 'asc' : $direction;
            $query     = $query->orderBy($order, $direction);
        }

        return $query;
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     *
     * @return \Illuminate\Database\Query\Builder
     */
    protected function queryOptions($query)
    {
        return $query;
    }
}
