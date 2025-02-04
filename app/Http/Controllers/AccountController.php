<?php

namespace App\Http\Controllers;

use App\Http\Requests\Account\ChargeRequest;
use App\Models\Account;

class AccountController extends Controller
{
    public function chargeAccount(ChargeRequest $request)
    {
        $data = $request->validated();
        $account = Account::query()->firstOrCreate(['user_id' => $data['user_id']], ['balance' => $data['amount']]);
        if (!$account->wasRecentlyCreated) {
            $account->update(['balance' => ($account->balance + $data['amount'])]);
        }
        return self::success($account);

    }


}
