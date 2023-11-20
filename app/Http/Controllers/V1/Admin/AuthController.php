<?php

namespace App\Http\Controllers\V1\Admin;

use App\Enums\UserRole;
use App\Exceptions\AuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }

    /**
     * @throws AuthException
     */
    public function webLogin(LoginRequest $request): Response
    {
        $this->authService->webLogin(
            $request->input('email'),
            $request->input('password'),
            UserRole::ADMIN
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
            UserRole::ADMIN
        );

        return response()->json(['token' => $token]);
    }
}
