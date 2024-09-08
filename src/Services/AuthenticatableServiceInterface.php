<?php
namespace LaravelRocket\Foundation\Services;

use LaravelRocket\Foundation\Models\AuthenticatableBase;

interface AuthenticatableServiceInterface extends BaseServiceInterface
{
    public function signInById(int $id): ?AuthenticatableBase;

    public function signIn(array $input): ?AuthenticatableBase;

    public function signUp(array $input): ?AuthenticatableBase;

    public function sendPasswordReset(string $email): bool;

    public function signOut(): bool;

    public function resignation(): bool;

    public function setUser(AuthenticatableBase $user): void;

    public function getUser(): ?AuthenticatableBase;

    public function sendPasswordResetEmail(string $email): void;

    public function resetPassword(string $email, string $password, string $token): bool;

    public function isSignedIn(): bool;

    public function getGuardName(): string;

    public function createWithImageUrl(array $input, string $imageUrl): AuthenticatableBase;
}
