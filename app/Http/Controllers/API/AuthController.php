<?php

declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\LoginUserRequest;
use App\Models\User;
use App\Traits\APIResponses;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use APIResponses;

    public function login(LoginUserRequest $request): JsonResponse
    {
        if(! Auth::attempt($request->only('email','password'))) {
            return $this->error('Invalid Credentials', 401);
        }

        $user = User::firstWhere('email', $request->email);

        return $this->ok(
            'Authenticated',
            [
                'token' => $user->createToken(
                    'API token for ' . $user->email,
                    ['*'],
                    now()->addMonth()
                )->plainTextToken
            ]
        );
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return $this->ok('UnAuthenticated');
    }

    public function register(): JsonResponse
    {
        return $this->ok('Register');
    }
}