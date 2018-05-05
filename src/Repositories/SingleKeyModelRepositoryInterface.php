<?php
namespace LaravelRocket\Foundation\Repositories;

interface SingleKeyModelRepositoryInterface extends BaseRepositoryInterface
{
    /**
     * @return array
     */
    public function getPrimaryKey();

    /**
     * @param int $id
     *
     * @return \LaravelRocket\Foundation\Models\Base|null
     */
    public function find($id);

    /**
     * @param array       $ids
     * @param string|null $order
     * @param string|null $direction
     * @param bool        $reorder
     *
     * @return \LaravelRocket\Foundation\Models\Base[]|\Illuminate\Database\Eloquent\Collection
     */
    public function allByIds($ids, $order = null, $direction = null, $reorder = false);

    /**
     * @param array $ids
     *
     * @return int
     */
    public function countByIds($ids);

    /**
     * @param array       $ids
     * @param string|null $order
     * @param string|null $direction
     * @param int|null    $offset
     * @param int|null    $limit
     *
     * @return \LaravelRocket\Foundation\Models\Base[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getByIds($ids, $order = null, $direction = null, $offset = null, $limit = null);

    /**
     * @param array $input
     *
     * @return \LaravelRocket\Foundation\Models\Base
     */
    public function create($input);

    /**
     * @param \LaravelRocket\Foundation\Models\Base $model
     * @param array                                 $input
     *
     * @return \LaravelRocket\Foundation\Models\Base
     */
    public function dryUpdate($model, $input);

    /**
     * @param \LaravelRocket\Foundation\Models\Base $model
     * @param array                                 $input
     *
     * @return \LaravelRocket\Foundation\Models\Base
     */
    public function update($model, $input);

    /**
     * @param \LaravelRocket\Foundation\Models\Base $model
     *
     * @return \LaravelRocket\Foundation\Models\Base
     */
    public function save($model);

    /**
     * @param \LaravelRocket\Foundation\Models\Base $model
     *
     * @return bool
     */
    public function delete($model);

    /**
     * @param int    $id
     * @param string $parentColumnName
     * @param string $targetColumnName
     * @param array  $list
     *
     * @return bool
     */
    public function updateMultipleEntries(int $id, string $parentColumnName, string $targetColumnName, array $list);

    /**
     * @param array  $filter
     * @param string $targetColumnName
     * @param array  $list
     *
     * @return bool
     */
    public function updateMultipleEntriesWithFilter(array $filter, string $targetColumnName, array $list);
}
