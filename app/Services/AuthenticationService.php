<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\Authentication\InvalidCredentialsException;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AuthenticationService
{

    /**
     * @throws InvalidCredentialsException
     */
    public function login(array $authData): array
    {
        if(! Auth::attempt($authData)) {
            throw new InvalidCredentialsException();
        }

        $user = User::firstWhere('email', $authData['email']);

        return [
            'token' => $user->createToken(
                'API token for ' . $user->email,
                ['*'],
                now()->addMonth()
            )->plainTextToken
        ];
    }

    public function logout(Request $request): bool
    {
        return $request->user()->currentAccessToken()->delete();
    }

    /**
     * @throws Exception
     */
    public function register(array $data): array
    {
        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);

            DB::commit();

            return [
                'token' => $user->createToken(
                    'API token for ' . $user->email,
                    ['*'],
                    now()->addMonth()
                )->plainTextToken
            ];

        } catch (Exception $e) {
            DB::rollBack();

            throw $e;
        }
    }

}