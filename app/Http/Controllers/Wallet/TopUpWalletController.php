<?php

namespace App\Http\Controllers\Wallet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Wallet\TopUpWalletRequest;
use App\Services\Wallet\WalletService;
use Illuminate\Http\Response;

class TopUpWalletController extends Controller
{
    private $walletService;

    public function __construct(WalletService $walletService)
    {
        $this->walletService = $walletService;
    }

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(TopUpWalletRequest $request)
    {
        $result = $this->walletService->topUpWallet($request->all());

        return response()->success('Success Top Up Wallet', Response::HTTP_CREATED, $result);
    }
}
