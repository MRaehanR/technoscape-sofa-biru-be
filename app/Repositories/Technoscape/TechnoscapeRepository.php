<?php

namespace App\Repositories\Technoscape;

interface TechnoscapeRepository
{
    public function createUser(array $data);
    public function createBankAccount(string $accessToken, int $balance);
    public function createAccessToken(string $username, string $password);
    public function addBalance(string $accessToken, int $amount, int $receiverAccountNumber);
}
