<?php

namespace App\Http\Controllers\V1\Customer;

use App\Enums\UserRole;
use App\Exceptions\AuthException;
use App\Http\Requests\Customer\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController
{
    public function __construct(protected AuthService $authService)
    {
    }

    /**
     * @throws AuthException
     */
    public function webLogin(LoginRequest $request)
    {
        $this->authService->webLogin(
            $request->input('email'),
            $request->input('password'),
            UserRole::CUSTOMER
        );

        return response()->noContent();
    }

    /**
     * @throws AuthException
     */
    public function tokenLogin(LoginRequest $request): JsonResponse
    {
        $token = $this->authService->tokenLogin(
            $request->input('email'),
            $request->input('password'),
            UserRole::CUSTOMER
        );

        return response()->json(['token' => $token]);
    }
}
