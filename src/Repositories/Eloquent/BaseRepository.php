<?php

namespace LaravelRocket\Foundation\Repositories\Eloquent;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use LaravelRocket\Foundation\Models\Base;
use LaravelRocket\Foundation\Repositories\BaseRepositoryInterface;

class BaseRepository implements BaseRepositoryInterface
{
    protected bool $cacheEnabled = false;

    protected string $cachePrefix = 'model';

    protected int $cacheLifeTime = 60; // Minutes

    protected array $querySearchTargets = [];

    public function getEmptyList(): Collection
    {
        return new Collection;
    }

    public function rules(): array
    {
        return [];
    }

    public function messages(): array
    {
        return [];
    }

    public function all($order = null, $direction = null): Collection|\Illuminate\Support\Collection|iterable
    {
        $query = $this->getBaseQuery();
        if (! empty($order)) {
            $direction = empty($direction) ? 'asc' : $direction;
            $query = $query->orderBy($order, $direction);
        }

        $query = $this->queryOptions($query);

        return $query->get();
    }

    public function allByFilterQuery($filter, $order = null, $direction = null): Builder|\Illuminate\Database\Eloquent\Builder
    {
        $query = $this->buildQueryByFilter($this->getBaseQuery(), $filter);

        return $this->buildOrder($query, $filter, $order, $direction);
    }

    public function allByFilter($filter, $order = null, $direction = null): Collection|\Illuminate\Support\Collection|iterable
    {
        $query = $this->allByFilterQuery($filter, $order, $direction);

        return $query->get();
    }

    public function allByFilterWithTrashed($filter, $order = null, $direction = null): Collection|\Illuminate\Support\Collection|iterable
    {
        $query = $this->buildQueryByFilter($this->getBlankModel(), $filter);
        $query = $this->buildOrder($query, $filter, $order, $direction);

        return $query->withTrashed()->get();
    }

    public function getModelClassName(): string
    {
        $model = $this->getBlankModel();

        return get_class($model);
    }

    public function getBlankModel(): Base
    {
        return new Base;
    }

    public function getBaseQuery(): Base
    {
        return $this->getBlankModel();
    }

    public function allEnabled($order = null, $direction = null): Collection|\Traversable|array|\Illuminate\Support\Collection
    {
        $model = $this->getBaseQuery();
        $query = $model->where('is_enabled', '=', true);
        if (! empty($order)) {
            $direction = empty($direction) ? 'asc' : $direction;
            $query = $query->orderBy($order, $direction);
        }

        $query = $this->queryOptions($query);

        return $query->get();
    }

    public function get($order = 'id', $direction = 'asc', $offset = 0, $limit = 20, $before = 0, $after = 0): Collection|\Traversable|array|\Illuminate\Support\Collection
    {
        $query = $this->getBaseQuery();

        $query = $this->setBefore($query, $order, $direction, $before);
        $query = $this->setAfter($query, $order, $direction, $after);
        $query = $this->queryOptions($query);

        return $query->orderBy($order, $direction)->skip($offset)->take($limit)->get();
    }

    public function getByFilter($filter, $order = 'id', $direction = 'asc', $offset = 0, $limit = 20, $before = 0, $after = 0): Collection|\Traversable|array|\Illuminate\Support\Collection
    {
        $query = $this->buildQueryByFilter($this->getBaseQuery(), $filter);
        $query = $this->setBefore($query, $order, $direction, $before);
        $query = $this->setAfter($query, $order, $direction, $after);
        $query = $this->buildOrder($query, $filter, $order, $direction);

        return $query->skip($offset)->take($limit)->get();
    }

    public function getByFilterWithTrashed($filter, $order = 'id', $direction = 'asc', $offset = 0, $limit = 20, $before = 0, $after = 0): Collection|\Traversable|array|\Illuminate\Support\Collection
    {
        $query = $this->buildQueryByFilter($this->getBlankModel(), $filter);
        $query = $this->setBefore($query, $order, $direction, $before);
        $query = $this->setAfter($query, $order, $direction, $after);
        $query = $this->buildOrder($query, $filter, $order, $direction);

        return $query->withTrashed()->skip($offset)->take($limit)->get();
    }

    public function getEnabled($order = 'id', $direction = 'asc', $offset = 0, $limit = 20, $before = 0, $after = 0): array|\Illuminate\Support\Collection
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

    public function countByFilter($filter): int
    {
        $query = $this->buildQueryByFilter($this->getBaseQuery(), $filter);

        return $query->count();
    }

    public function countEnabled()
    {
        $model = $this->getBaseQuery();

        return $model->where('is_enabled', '=', true)->count();
    }

    public function firstByFilter($filter): \Illuminate\Database\Eloquent\Model|array|Base|Builder|\Illuminate\Database\Eloquent\Builder|null
    {
        $query = $this->buildQueryByFilter($this->getBaseQuery(), $filter);

        return $query->first();
    }

    public function firstByFilterWithTrashed($filter): \Illuminate\Database\Eloquent\Model|array|Base|Builder|\Illuminate\Database\Eloquent\Builder|null
    {
        $query = $this->buildQueryByFilter($this->getBlankModel(), $filter);

        return $query->withTrashed()->first();
    }

    public function updateByFilter($filter, $values): int
    {
        $query = $this->buildQueryByFilter($this->getBaseQuery(), $filter);
        $count = $query->update($values);

        return $count;
    }

    public function getSQLByFilter($filter): string
    {
        $query = $this->buildQueryByFilter($this->getBaseQuery(), $filter);

        return $query->toSql();
    }

    public function deleteByFilter($filter): int
    {
        $query = $this->buildQueryByFilter($this->getBaseQuery(), $filter);

        return $query->delete();
    }

    public function pluck($collection, $value, $key = null): Collection|\Illuminate\Support\Collection
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

    protected function setBefore(
        Builder|\Illuminate\Database\Eloquent\Builder|Base $query,
        string $order,
        string $direction,
        mixed $before): Builder|\Illuminate\Database\Eloquent\Builder|Base
    {
        if ($before == 0) {
            return $query;
        }

        return $query->where($order, ($direction === 'desc' ? '>' : '<'), $before);
    }

    protected function setAfter(
        Builder|\Illuminate\Database\Eloquent\Builder|Base $query,
        string $order,
        string $direction,
        mixed $after): Builder|\Illuminate\Database\Eloquent\Builder|Base
    {
        if ($after == 0) {
            return $query;
        }

        return $query->where($order, ($direction === 'desc' ? '<' : '>'), $after);
    }

    /**
     * @param  int[]  $ids
     */
    protected function getCacheKey(array $ids): string
    {
        $key = $this->cachePrefix;
        foreach ($ids as $id) {
            $key .= '-'.$id;
        }

        return $key;
    }

    /**
     * @param  Builder  $query
     * @param  string[]  $orderCandidates
     */
    protected function getWithQueryBuilder(
        Builder|Base $query,
        array $orderCandidates,
        string $orderDefault,
        string $order,
        string $direction,
        int $offset,
        int $limit
    ): \Illuminate\Support\Collection {
        $order = strtolower($order);
        $direction = strtolower($direction);
        $offset = intval($offset);
        $limit = intval($limit);
        if (empty($orderCandidates)) {
            $orderCandidates = [];
        }
        if (empty($orderDefault)) {
            $orderDefault = 'id';
        }
        $order = in_array($order, $orderCandidates) ? $order : strtolower($orderDefault);
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

    protected function buildQueryByFilter(Builder|\Illuminate\Database\Eloquent\Builder|Base $query, array $filter): Builder|\Illuminate\Database\Eloquent\Builder|Base
    {
        $tableName = $this->getBlankModel()->getTable();

        $query = $this->queryOptions($query);

        if (count($this->querySearchTargets) > 0 && array_key_exists('query', $filter)) {
            $searchWord = Arr::get($filter, 'query');
            if (! empty($searchWord)) {
                $query = $query->where(function ($q) use ($searchWord) {
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

    protected function buildOrder(
        Builder|\Illuminate\Database\Eloquent\Builder|Base $query,
        array $filter = [],
        ?string $order = null,
        ?string $direction = null
    ): Builder|\Illuminate\Database\Eloquent\Builder|Base {
        if (! empty($order)) {
            $direction = empty($direction) ? 'asc' : $direction;
            $query = $query->orderBy($order, $direction);
        }

        return $query;
    }

    protected function queryOptions(Builder|\Illuminate\Database\Eloquent\Builder|Base $query): Builder|\Illuminate\Database\Eloquent\Builder|Base
    {
        return $query;
    }
}
