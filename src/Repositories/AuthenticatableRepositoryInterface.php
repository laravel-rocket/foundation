<?php

namespace LaravelRocket\Foundation\Repositories;

use LaravelRocket\Foundation\Models\AuthenticatableBase;

interface AuthenticatableRepositoryInterface extends SingleKeyModelRepositoryInterface
{
    /**
     * @param  string  $email
     * @return AuthenticatableBase|null
     */
    public function findByEmail($email);

    /**
     * @param  AuthenticatableBase  $user
     * @param  string  $password
     * @return AuthenticatableBase
     */
    public function updateRawPassword($user, $password);
}
