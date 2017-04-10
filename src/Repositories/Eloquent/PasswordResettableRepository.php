<?php
namespace LaravelRocket\Foundation\Repositories\Eloquent;

use Illuminate\Auth\Passwords\DatabaseTokenRepository;
use LaravelRocket\Foundation\Repositories\PasswordResettableRepositoryInterface;

class PasswordResettableRepository extends DatabaseTokenRepository implements PasswordResettableRepositoryInterface
{
    protected $tableName = 'password_resets';

    protected $hashKey = 'random';

    protected $expires = 60;

    public function __construct()
    {
        parent::__construct($this->getDatabaseConnection(), app()['hash'], $this->tableName, $this->hashKey,
            $this->expires);
    }

    protected function getDatabaseConnection()
    {
        return $connection = app()['db']->connection();
    }

    public function findEmailByToken($token)
    {
        $token = $this->getTable()->where('token', $token)->first();
        if (empty($token)) {
            return;
        }
        if ($this->tokenExpired([
            'email' => $token->email,
            'token' => $token->token,
            'created_at' => $token->created_at,
        ])
        ) {
            return;
        }

        return $token->email;
    }
}
