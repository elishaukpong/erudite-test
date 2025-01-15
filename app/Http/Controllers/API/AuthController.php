<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Exceptions\Authentication\InvalidCredentialsException;
use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginUserRequest;
use App\Http\Requests\API\RegisterUserRequest;
use App\Services\AuthenticationService;
use App\Traits\APIResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class AuthController extends Controller
{
    use APIResponses;


    public function __construct(protected AuthenticationService $authenticationService)
    {}

    public function login(LoginUserRequest $request): JsonResponse
    {
        try {
            $tokenData = $this->authenticationService->login($request->only('email','password'));

            return $this->ok(
                __('Authenticated'),
                $tokenData
            );

        } catch (InvalidCredentialsException | Throwable $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $this->authenticationService->logout($request);

            return $this->ok(__('Unauthenticated'));
        } catch (Throwable $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function register(RegisterUserRequest $request): JsonResponse
    {
        try {
            $tokenData = $this->authenticationService->register($request->all());

            return $this->ok(
                __('User Registered'),
                $tokenData
            );
        } catch (Throwable $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}