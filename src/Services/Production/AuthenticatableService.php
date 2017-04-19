<?php
namespace LaravelRocket\Foundation\Services\Production;

use LaravelRocket\Foundation\Repositories\AuthenticatableRepositoryInterface;
use LaravelRocket\Foundation\Repositories\PasswordResettableRepositoryInterface;
use LaravelRocket\Foundation\Services\AuthenticatableServiceInterface;
use LaravelRocket\Foundation\Services\MailServiceInterface;

class AuthenticatableService extends BaseService implements AuthenticatableServiceInterface
{
    /** @var \LaravelRocket\Foundation\Repositories\AuthenticatableRepositoryInterface */
    protected $authenticatableRepository;

    /** @var \LaravelRocket\Foundation\Repositories\PasswordResettableRepositoryInterface */
    protected $passwordResettableRepository;

    /** @var string $resetEmailTitle */
    protected $resetEmailTitle = 'Reset Password';

    /** @var string $resetEmailTemplate */
    protected $resetEmailTemplate = '';

    public function __construct(
        AuthenticatableRepositoryInterface $authenticatableRepository,
        PasswordResettableRepositoryInterface $passwordResettableRepository
    ) {
        $this->authenticatableRepository    = $authenticatableRepository;
        $this->passwordResettableRepository = $passwordResettableRepository;
    }

    public function signInById($id)
    {
        /** @var \LaravelRocket\Foundation\Models\AuthenticatableBase $user */
        $user = $this->authenticatableRepository->find($id);
        if (empty($user)) {
            return;
        }
        $guard = $this->getGuard();
        $guard->login($user);

        return $guard->user();
    }

    /**
     * @return \Illuminate\Contracts\Auth\Guard
     */
    protected function getGuard()
    {
        return \Auth::guard($this->getGuardName());
    }

    /**
     * @return string
     */
    public function getGuardName()
    {
        return '';
    }

    public function signIn($input)
    {
        $rememberMe = (bool) array_get($input, 'remember_me', 0);
        $guard      = $this->getGuard();
        if (!$guard->attempt(['email' => $input['email'], 'password' => $input['password']], $rememberMe, true)) {
            return;
        }

        return $guard->user();
    }

    public function signUp($input)
    {
        $existingUser = $this->authenticatableRepository->findByEmail(array_get($input, 'email'));
        if (!empty($existingUser)) {
            return;
        }

        $user = $this->authenticatableRepository->create($input);
        if (empty($user)) {
            return;
        }
        $guard = $this->getGuard();
        $guard->login($user);

        return $guard->user();
    }

    public function sendPasswordReset($email)
    {
        return false;
    }

    public function signOut()
    {
        $user = $this->getUser();
        if (empty($user)) {
            return false;
        }
        $guard = $this->getGuard();
        $guard->logout();
        session()->flush();

        return true;
    }

    public function getUser()
    {
        $guard = $this->getGuard();

        return $guard->user();
    }

    public function resignation()
    {
        $user = $this->getUser();
        if (empty($user)) {
            return false;
        }
        $guard = $this->getGuard();
        $guard->logout();
        session()->flush();
        $this->authenticatableRepository->delete($user);

        return true;
    }

    public function sendPasswordResetEmail($email)
    {
        $user = $this->authenticatableRepository->findByEmail($email);
        if (empty($user)) {
            return;
        }

        $token = $this->passwordResettableRepository->create($user);

        $mailService = app()->make(MailServiceInterface::class);

        $mailService->sendMail($this->resetEmailTitle, config('mail.from'),
            ['name' => '', 'address' => $user->email], $this->resetEmailTemplate, [
                'token' => $token,
            ]);
    }

    public function getUserByPasswordResetToken($token)
    {
        $email = $this->passwordResettableRepository->findEmailByToken($token);
        if (empty($email)) {
            return;
        }

        return $this->authenticatableRepository->findByEmail($email);
    }

    public function resetPassword($email, $password, $token)
    {
        $user = $this->authenticatableRepository->findByEmail($email);
        if (empty($user)) {
            return false;
        }
        if (!$this->passwordResettableRepository->exists($user, $token)) {
            return false;
        }
        $this->authenticatableRepository->update($user, ['password' => $password]);
        $this->passwordResettableRepository->delete($token);
        $this->setUser($user);

        return true;
    }

    public function setUser($user)
    {
        $guard = $this->getGuard();
        $guard->login($user);
    }

    public function isSignedIn()
    {
        $guard = $this->getGuard();

        return $guard->check();
    }
}
