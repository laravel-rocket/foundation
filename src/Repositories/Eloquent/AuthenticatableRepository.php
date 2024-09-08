<?php
namespace LaravelRocket\Foundation\Repositories\Eloquent;

use LaravelRocket\Foundation\Models\AuthenticatableBase;
use LaravelRocket\Foundation\Repositories\AuthenticatableRepositoryInterface;

class AuthenticatableRepository extends SingleKeyModelRepository implements AuthenticatableRepositoryInterface
{
    public function getBlankModel(): AuthenticatableBase
    {
        return new AuthenticatableBase();
    }

    public function findByEmail($email)
    {
        $className = $this->getModelClassName();

        return $className::whereEmail($email)->first();
    }

    public function findByFacebookId($facebookId)
    {
        $className = $this->getModelClassName();

        return $className::whereFacebookId($facebookId)->first();
    }

    public function updateRawPassword($user, $password)
    {
        if (empty($password)) {
            \DB::update('update '.$this->getBlankModel()->getTable().' set password = \'\' where id = ?', [$user->id]);
        } else {
            \DB::update(
                'update '.$this->getBlankModel()->getTable().' set password = ? where id = ?',
                [$password, $user->id]
            );
        }

        return $this->find($user->id);
    }
}
