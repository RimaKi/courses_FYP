<?php

namespace App\Http\Controllers;

use App\Http\Requests\Account\ChargeRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Services\AccountService;

class AccountController extends Controller
{
    protected $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function chargeAccount(ChargeRequest $request)
    {
        $account = $this->accountService->chargeAccount($request->validated());
        return self::success($account);
    }

    public function getPayments()
    {
        $payments = $this->accountService->getPayments();
        return self::success(TransactionResource::collection($payments));
    }

    public function allPayment()
    {
        $transactions = Transaction::with(['course', 'account', 'intendedAccount'])->get();
        return self::success(TransactionResource::collection($transactions));
    }

}
