<?php

namespace App\Repositories\Technoscape;

use App\Exceptions\ResponseException;
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
            'Content' => 'application/json'
        ])->post($url, $body);

        $response = json_decode($response->body());

        if (!$response->success) {
            throw new ResponseException($response->errMsg, 400);
        }

        return $response;
    }
}
