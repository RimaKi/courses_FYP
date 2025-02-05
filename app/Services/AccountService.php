<?php

namespace App\Services;

use App\Models\Account;

class AccountService
{
    public function chargeAccount(array $data){
        $account = Account::query()->firstOrCreate(['user_id' => $data['user_id']], ['balance' => $data['amount']]);
        if (!$account->wasRecentlyCreated) {
            $account->update(['balance' => ($account->balance + $data['amount'])]);
        }
        return $account;
    }

    public function getPayments(){
        $user = auth()->user();
        if ($user->hasRole('student')) {
            $payments = $user->transactions()->with('intendedAccount.user');
        }
        if ($user->hasRole('instructor')) {
            $payments = $user->transactionsForInstructor()->with('account.user');
        }
        return $payments->with('course')->latest()->get();
    }
}
