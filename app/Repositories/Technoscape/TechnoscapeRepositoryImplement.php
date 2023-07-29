<?php

namespace App\Repositories\Technoscape;

use App\Exceptions\ResponseException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class TechnoscapeRepositoryImplement implements TechnoscapeRepository
{
    public function createUser(array $data)
    {
        $url = config('const.technoscape_url') . '/user/auth/create';
        $gender = $data['gender'];
        $body = [
            'ktpId' => $data['nik'],
            'username' => $data['username'],
            'loginPassword' => $data['password'],
            'phoneNumber' => $data['phone'],
            'birthDate' => $data['birth_date'],
            'gender' => config("const.gender.$gender"),
            'email' => $data['email']
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post($url, $body);

        $response = json_decode($response->body());

        if (!$response->success) {
            throw new ResponseException($response->errMsg, 400);
        }

        return $response->data;
    }

    public function createAccessToken(string $username, string $password)
    {
        $url = config('const.technoscape_url') . '/user/auth/token';
        $body = [
            'username' => $username,
            'loginPassword' => $password
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json'
        ])->post($url, $body);

        $response = json_decode($response->body());

        if (!$response->success) {
            throw new ResponseException($response->errMsg, 400);
        }

        return $response->data;
    }

    public function createBankAccount(string $accessToken, int $balance)
    {
        $url = config('const.technoscape_url') . '/bankAccount/create';
        $body = [
            'balance' => $balance
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer $accessToken"
        ])->post($url, $body);

        $response = json_decode($response->body());

        if (!$response->success) {
            throw new ResponseException($response->errMsg, 400);
        }

        return $response->data;
    }

    public function addBalance(string $accessToken, int $amount, int $receiverAccountNumber)
    {
        $url = config('const.technoscape_url') . '/bankAccount/addBalance';
        $body = [
            'receiverAccountNo' => $receiverAccountNumber,
            'amount' => $amount
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer $accessToken"
        ])->post($url, $body);

        $response = json_decode($response->body());

        if (!$response->success) {
            throw new ResponseException($response->errMsg, 400);
        }

        return $response->data;
    }

    public function createTransaction(string $senderAccountNumber, string $receiverAccountNumber, int $amount, string $accessToken)
    {
        $url = config('const.technoscape_url') . '/bankAccount/transaction/create';
        $body = [
            'senderAccountNo' => $senderAccountNumber,
            'receiverAccountNo' => $receiverAccountNumber,
            'amount' => $amount
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => "Bearer $accessToken"
        ])->post($url, $body);

        $response = json_decode($response->body());

        if (!$response->success) {
            throw new ResponseException($response->errMsg, 400);
        }

        return $response->data;
    }
}
