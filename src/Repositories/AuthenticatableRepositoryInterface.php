<?php

namespace LaravelRocket\Foundation\Repositories;

use LaravelRocket\Foundation\Models\AuthenticatableBase;

/**
 *
 * @method \LaravelRocket\Foundation\Models\AuthenticatableBase[] getEmptyList()
 * @method \LaravelRocket\Foundation\Models\AuthenticatableBase[]|\Traversable|array all($order = null, $direction = null)
 * @method \LaravelRocket\Foundation\Models\AuthenticatableBase[]|\Traversable|array get($order, $direction, $offset, $limit)
 * @method \LaravelRocket\Foundation\Models\AuthenticatableBase create($value)
 * @method \LaravelRocket\Foundation\Models\AuthenticatableBase find($id)
 * @method \LaravelRocket\Foundation\Models\AuthenticatableBase[]|\Traversable|array allByIds($ids, $order = null, $direction = null, $reorder = false)
 * @method \LaravelRocket\Foundation\Models\AuthenticatableBase[]|\Traversable|array getByIds($ids, $order = null, $direction = null, $offset = null, $limit = null);
 * @method \LaravelRocket\Foundation\Models\AuthenticatableBase update($model, $input)
 * @method \LaravelRocket\Foundation\Models\AuthenticatableBase save($model);
 */

interface AuthenticatableRepositoryInterface extends SingleKeyModelRepositoryInterface
{
    /**
     * @return \LaravelRocket\Foundation\Models\AuthenticatableBase
     */
    public function getBlankModel();

    /**
     * @param string $email
     *
     * @return AuthenticatableBase|null
     */
    public function findByEmail($email);
}
