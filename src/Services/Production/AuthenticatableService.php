<?php
namespace LaravelRocket\Foundation\Services\Production;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use LaravelRocket\Foundation\Models\AuthenticatableBase;
use LaravelRocket\Foundation\Repositories\AuthenticatableRepositoryInterface;
use LaravelRocket\Foundation\Repositories\PasswordResettableRepositoryInterface;
use LaravelRocket\Foundation\Services\AuthenticatableServiceInterface;
use LaravelRocket\Foundation\Services\MailServiceInterface;

class AuthenticatableService extends BaseService implements AuthenticatableServiceInterface
{
    protected AuthenticatableRepositoryInterface $authenticatableRepository;

    protected PasswordResettableRepositoryInterface $passwordResettableRepository;

    protected string $resetEmailTitle = 'Reset Password';

    protected string $resetEmailTemplate = '';

    public function __construct(
        AuthenticatableRepositoryInterface $authenticatableRepository,
        PasswordResettableRepositoryInterface $passwordResettableRepository
    ) {
        $this->authenticatableRepository    = $authenticatableRepository;
        $this->passwordResettableRepository = $passwordResettableRepository;
    }

    public function signInById(int $id): ?AuthenticatableBase
    {
        /** @var AuthenticatableBase $user */
        $user = $this->authenticatableRepository->find($id);
        if (empty($user)) {
            return null;
        }
        $guard = $this->getGuard();
        $guard->login($user);

        return $guard->user();
    }

    /**
     * @return Guard
     */
    protected function getGuard()
    {
        return Auth::guard($this->getGuardName());
    }

    /**
     * @return string
     */
    public function getGuardName(): string
    {
        return '';
    }

    public function signIn(array $input): ?AuthenticatableBase
    {
        $rememberMe = (bool) Arr::get($input, 'remember_me', 0);
        $guard      = $this->getGuard();
        if (!$guard->attempt(['email' => $input['email'], 'password' => $input['password']], $rememberMe, true)) {
            return null;
        }

        return $guard->user();
    }

    public function signUp(array $input): ?AuthenticatableBase
    {
        $existingUser = $this->authenticatableRepository->findByEmail(Arr::get($input, 'email'));
        if (!empty($existingUser)) {
            return null;
        }

        $user = $this->authenticatableRepository->create($input);
        if (empty($user)) {
            return null;
        }
        $guard = $this->getGuard();
        $guard->login($user);

        return $guard->user();
    }

    public function sendPasswordReset(string $email): bool
    {
        return false;
    }

    public function signOut(): bool
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

    public function getUser(): ?AuthenticatableBase
    {
        $guard = $this->getGuard();

        return $guard->user();
    }

    public function resignation(): bool
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

    public function sendPasswordResetEmail(string $email): void
    {
        $user = $this->authenticatableRepository->findByEmail($email);
        if (empty($user)) {
            return;
        }

        $token = $this->passwordResettableRepository->create($user);

        $mailService = app()->make(MailServiceInterface::class);

        $mailService->sendMail(
            $this->resetEmailTitle,
            config('mail.from'),
            ['name' => '', 'address' => $user->email],
            $this->resetEmailTemplate,
            [
                'token' => $token,
                'user'  => $user,
            ]
        );
    }

    public function resetPassword(string $email, string $password, string $token): bool
    {
        $user = $this->authenticatableRepository->findByEmail($email);
        if (empty($user)) {
            return false;
        }
        if (!$this->passwordResettableRepository->exists($user, $token)) {
            return false;
        }
        $this->authenticatableRepository->update($user, ['password' => $password]);
        $this->passwordResettableRepository->delete($user);
        $this->setUser($user);

        return true;
    }

    public function setUser(AuthenticatableBase $user): void
    {
        $guard = $this->getGuard();
        $guard->login($user);
    }

    public function isSignedIn(): bool
    {
        $guard = $this->getGuard();

        return $guard->check();
    }

    public function createWithImageUrl(array $input, string $imageUrl): AuthenticatableBase
    {
        return $this->authenticatableRepository->create($input);
    }
}
