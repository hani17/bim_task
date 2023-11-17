<?php

namespace App\Http\Controllers\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @throws ValidationException
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        if (auth()->attempt($request->validated())) {
            return redirect()->intended('/dashboard');
        }

        throw ValidationException::withMessages([
            'email' => ['Invalid credentials.'],
        ]);
    }
}
