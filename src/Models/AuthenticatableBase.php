<?php

namespace LaravelRocket\Foundation\Models;

/*
 * App\Models\AuthenticatableBase
 *
 * @property string $password
 * @property int $profile_image_id
 * @property string $api_access_token
 */

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Foundation\Auth\Access\Authorizable;
use LaravelRocket\Foundation\Models\Traits\LocaleStorable;

class AuthenticatableBase extends Base implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, LocaleStorable;

    public function setPasswordAttribute(string $password): void
    {
        if (empty($password)) {
            $this->attributes['password'] = '';
        } else {
            $this->attributes['password'] = app('hash')->make($password);
        }
    }
}
