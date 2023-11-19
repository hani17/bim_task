<?php

namespace App\Services;

use App\Enums\UserRole;
use App\Exceptions\AuthException;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

class AuthService
{
    /**
     * @throws AuthException
     */
    public function webLogin(string $email, string $password, UserRole $role): ?Authenticatable
    {
        if (Auth::attempt(['email' => $email, 'password' => $password , 'role' => $role])) {
            return Auth::user();
        }

        throw AuthException::invalidCredentials();
    }

    /**
     * @throws AuthException
     */
    public function tokenLogin(string $email, string $password, UserRole $role): string
    {
        $user = User::whereRole($role)->whereEmail($email)->first();

        if (!$user || !password_verify($password, $user->password)) {
            throw AuthException::invalidCredentials();
        }

        return $user->createToken(
            $role == UserRole::ADMIN ? 'adminAuthToken' : 'customerAuthToken'
        )->plainTextToken;
    }
}
