<?php

namespace LaravelRocket\Foundation\Repositories;

interface BaseRepositoryInterface
{
    /**
     * Get Empty Array or Traversable Object.
     *
     * @return \LaravelRocket\Foundation\Models\Base[]|\Traversable|array|\Illuminate\Database\Eloquent\Collection
     */
    public function getEmptyList();

    /**
     * Get All Model's query.
     *
     * @param  array  $filter
     * @param  string  $order
     * @param  string  $direction
     * @return \Illuminate\Database\Query\Builder
     */
    public function allByFilterQuery($filter, $order = null, $direction = null);

    /**
     * Get All Models.
     *
     * @param  string  $order
     * @param  string  $direction
     * @return \LaravelRocket\Foundation\Models\Base[]|\Traversable|array|\Illuminate\Database\Eloquent\Collection
     */
    public function all($order = null, $direction = null);

    /**
     * Get All Enabled Models.
     *
     * @param  string  $order
     * @param  string  $direction
     * @return \LaravelRocket\Foundation\Models\Base[]|\Traversable|array|\Illuminate\Database\Eloquent\Collection
     */
    public function allEnabled($order = null, $direction = null);

    /**
     * Get All Models with filter conditions.
     *
     * @param  array  $filter
     * @param  string  $order
     * @param  string  $direction
     * @return \LaravelRocket\Foundation\Models\Base[]|\Traversable|array|\Illuminate\Database\Eloquent\Collection
     */
    public function allByFilter($filter, $order = null, $direction = null);

    /**
     * Get All Models including Trashed with filter conditions.
     *
     * @param array  $filter
     * @param string $order
     * @param string $direction
     *
     * @return \LaravelRocket\Foundation\Models\Base[]|\Traversable|array|\Illuminate\Database\Eloquent\Collection
     */
    public function allByFilterWithTrashed($filter, $order = null, $direction = null);

    /**
     * Get Models with Order.
     *
     * @param  string  $order
     * @param  string  $direction
     * @param  int  $offset
     * @param  int  $limit
     * @param  mixed  $before
     * @param  mixed  $after
     * @return \LaravelRocket\Foundation\Models\Base[]|\Traversable|array|\Illuminate\Database\Eloquent\Collection
     */
    public function get($order, $direction, $offset, $limit, $before = 0, $after = 0);

    /**
     * Get Models with Order.
     *
     * @param  array  $filter
     * @param  string  $order
     * @param  string  $direction
     * @param  int  $offset
     * @param  int  $limit
     * @param  mixed  $before
     * @param  mixed  $after
     * @return \LaravelRocket\Foundation\Models\Base[]|\Traversable|array|\Illuminate\Database\Eloquent\Collection
     */
    public function getByFilter($filter, $order, $direction, $offset, $limit, $before = 0, $after = 0);

    /**
     * Get Models including Trashed with Order.
     *
     * @param array  $filter
     * @param string $order
     * @param string $direction
     * @param int    $offset
     * @param int    $limit
     * @param mixed  $before
     * @param mixed  $after
     *
     * @return \LaravelRocket\Foundation\Models\Base[]|\Traversable|array
     */
    public function getByFilterWithTrashed($filter, $order, $direction, $offset, $limit, $before = 0, $after = 0);

    /**
     * Get Models with Order.
     *
     * @param  string  $order
     * @param  string  $direction
     * @param  int  $offset
     * @param  int  $limit
     * @param  mixed  $before
     * @param  mixed  $after
     * @return \LaravelRocket\Foundation\Models\Base[]||\Illuminate\Database\Eloquent\Collection|\Traversable|array
     */
    public function getEnabled($order, $direction, $offset, $limit, $before = 0, $after = 0);

    /**
     * @return int
     */
    public function count();

    /**
     * @param  array  $filter
     * @return int
     */
    public function countByFilter($filter);

    /**
     * @return int
     */
    public function countEnabled();

    /**
     * @param  array  $filter
     * @return \LaravelRocket\Foundation\Models\Base|null
     */
    public function firstByFilter($filter);

    /**
     * @param array $filter
     *
     * @return \LaravelRocket\Foundation\Models\Base|null
     */
    public function firstByFilterWithTrashed($filter);

    /**
     * @param array $filter
     * @param array $values
     *
     * @return int
     */
    public function updateByFilter($filter, $values);

    /**
     * @param  array  $filter
     * @return string
     */
    public function getSQLByFilter($filter);

    /**
     * @param  array  $filter
     **/
    public function deleteByFilter($filter);

    /**
     * @return string
     */
    public function getModelClassName();

    /**
     * Get Empty Array or Traversable Object.
     *
     * @return \LaravelRocket\Foundation\Models\Base|\Illuminate\Database\Query\Builder
     */
    public function getBlankModel();

    /**
     * Get base query for fetching data.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function getBaseQuery();

    /**
     * @param  array  $attributes
     * @param  array  $values
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function firstOrNew($attributes, $values = []);

    /**
     * @param  array  $attributes
     * @param  array  $values
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function firstOrCreate($attributes, $values = []);

    /**
     * @param  array  $attributes
     * @param  array  $values
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateOrCreate($attributes, $values = []);

    /**
     * Get a rule for Validator.
     *
     * @return array
     */
    public function rules();

    /**
     * Get a messages for Validator.
     *
     * @return array
     */
    public function messages();

    /**
     * @param  \Illuminate\Support\Collection  $collection
     * @param  string  $value
     * @param  string|null  $key
     * @return \Illuminate\Support\Collection
     */
    public function pluck($collection, $value, $key = null);
}
