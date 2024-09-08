<?php
namespace LaravelRocket\Foundation\Auth;

use Illuminate\Auth\EloquentUserProvider as BaseEloquentUserProvider;

class EloquentUserProvider extends BaseEloquentUserProvider
{
    /**
     * Retrieve a user by their unique identifier and "remember me" token.
     *
     * @param mixed  $identifier
     * @param string $token
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function retrieveByToken($identifier, $token): ?\Illuminate\Contracts\Auth\Authenticatable
    {
        $model = $this->createModel();

        $model = $model->where($model->getAuthIdentifierName(), $identifier)->first();

        if (!$model) {
            return null;
        }

        $rememberToken = $model->getRememberToken();

        return $rememberToken && hash_equals($rememberToken, $token) ? $model : null;
    }
}
