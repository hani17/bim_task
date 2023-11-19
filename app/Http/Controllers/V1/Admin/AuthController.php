<?php

namespace App\Http\Controllers\V1\Admin;

use App\Enums\UserRole;
use App\Exceptions\AuthException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;

class AuthController extends Controller
{
    public function __construct(protected AuthService $authService)
    {
    }

    /**
     * @throws AuthException
     */
    public function webLogin(LoginRequest $request): RedirectResponse
    {
        $this->authService->webLogin(
            $request->input('email'),
            $request->input('password'),
            UserRole::ADMIN
        );

        return redirect('/');
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
