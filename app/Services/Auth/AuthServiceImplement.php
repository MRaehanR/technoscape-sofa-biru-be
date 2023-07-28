<?php

namespace App\Services\Auth;

use App\Exceptions\ResponseException;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AuthServiceImplement implements AuthService
{
    public function register(array $data)
    {
        try {
            $user = User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'phone' => $data['phone'],
                'birth_date' => $data['birth_date'],
            ]);

            $accessToken = $user->createToken('access_token')->plainTextToken;

            return $accessToken;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
