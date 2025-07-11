<?php

namespace App\Http\Controllers;

use App\Models\Balance;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class BalanceController extends Controller
{
    /**
     * Get balance for a specific account.
     */
    public function show(string $accountId): JsonResponse
    {
        $balance = Balance::where('account_id', $accountId)->first();

        if (!$balance) {
            return response()->json([
                'error' => 'Balance not found for account: ' . $accountId
            ], 404);
        }

        return response()->json([
            'account_id' => $balance->account_id,
            'balance' => $balance->balance,
            'updated_at' => $balance->updated_at
        ]);
    }
} 