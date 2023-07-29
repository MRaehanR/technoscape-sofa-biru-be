<?php

namespace App\Services\Wallet;

use App\Exceptions\ResponseException;
use App\Models\User;
use App\Repositories\Technoscape\TechnoscapeRepository;

class WalletServiceImplement implements WalletService
{
    private $technoscapeRepository;

    public function __construct(TechnoscapeRepository $technoscapeRepository)
    {
        $this->technoscapeRepository = $technoscapeRepository;
    }

    public function topUpWallet(array $data)
    {
        $user = User::where('id', Auth()->user()->id)->first();

        if (!$user) {
            throw new ResponseException("User Not Found", 404);
        }

        $technoscapeAccessToken = $this->technoscapeRepository->createAccessToken($user->username, $user->password)->accessToken;
        $topupWallet = $this->technoscapeRepository->addBalance($technoscapeAccessToken, $data['amount'], $user->account_number);

        $formattedAmount = number_format($topupWallet->amount, 0, null, '.');
        $topupWallet->amount = 'Rp ' . $formattedAmount;
        return ['topup' => $topupWallet];
    }
}
