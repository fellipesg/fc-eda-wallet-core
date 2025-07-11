<?php

namespace Database\Seeders;

use App\Models\Balance;
use Illuminate\Database\Seeder;

class BalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $balances = [
            ['account_id' => 'e2a9ed94-18fc-41a7-8eb4-d7c5e155576d', 'balance' => 100.00],
            ['account_id' => 'aed5db83-1a6e-465b-bb12-e95361d25d1a', 'balance' => 200.00],
        ];

        foreach ($balances as $balance) {
            Balance::updateOrCreate(
                ['account_id' => $balance['account_id']],
                ['balance' => $balance['balance']]
            );
        }
    }
} 