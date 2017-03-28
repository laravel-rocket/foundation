<?php

namespace LaravelRocket\Foundation\Services;

interface AuthenticatableServiceInterface extends BaseServiceInterface
{
    /**
     * @param int $id
     *
     * @return \LaravelRocket\Foundation\Models\AuthenticatableBase
     */
    public function signInById($id);

    /**
     * @param array $input
     *
     * @return \LaravelRocket\Foundation\Models\AuthenticatableBase
     */
    public function signIn($input);

    /**
     * @param array $input
     *
     * @return \LaravelRocket\Foundation\Models\AuthenticatableBase
     */
    public function signUp($input);

    /**
     * @param string $email
     *
     * @return bool
     */
    public function sendPasswordReset($email);

    /**
     * @return bool
     */
    public function signOut();

    /**
     * @return bool
     */
    public function resignation();

    /**
     * @param \LaravelRocket\Foundation\Models\AuthenticatableBase $user
     */
    public function setUser($user);

    /**
     * @return \LaravelRocket\Foundation\Models\AuthenticatableBase
     */
    public function getUser();

    /**
     * @param string $email
     */
    public function sendPasswordResetEmail($email);

    /**
     * @param string $token
     *
     * @return null|\LaravelRocket\Foundation\Models\AuthenticatableBase
     */
    public function getUserByPasswordResetToken($token);

    /**
     * @param string $email
     * @param string $password
     * @param string $token
     *
     * @return bool
     */
    public function resetPassword($email, $password, $token);

    /**
     * @return bool
     */
    public function isSignedIn();

    /**
     * @return string
     */
    public function getGuardName();
}
