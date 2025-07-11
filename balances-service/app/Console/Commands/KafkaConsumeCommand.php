<?php

namespace App\Console\Commands;

use App\Models\Balance;
use Illuminate\Console\Command;

class KafkaConsumeCommand extends Command
{
    protected $signature = 'kafka:consume';
    protected $description = 'Consume balance update events from Kafka';

    public function handle()
    {
        $this->info('Starting Kafka consumer...');
        $this->info('Note: This is a placeholder. In a real implementation, you would use a proper Kafka client library.');
        $this->info('For now, we will simulate receiving balance updates...');

        // Simulate receiving balance updates
        $this->simulateBalanceUpdates();

        $this->info('Kafka consumer stopped.');
    }

    private function simulateBalanceUpdates()
    {
        // Simulate some balance updates
        $updates = [
            ['account_id' => 'account-1', 'balance' => 150.00],
            ['account_id' => 'account-2', 'balance' => 250.00],
            ['account_id' => 'e2a9ed94-18fc-41a7-8eb4-d7c5e155576d', 'balance' => 100.00],
            ['account_id' => 'aed5db83-1a6e-465b-bb12-e95361d25d1a', 'balance' => 200.00],
        ];

        foreach ($updates as $update) {
            $this->updateBalance($update['account_id'], $update['balance']);
            sleep(1); // Simulate processing time
        }
    }

    private function updateBalance(string $accountId, float $balance)
    {
        Balance::updateOrCreate(
            ['account_id' => $accountId],
            ['balance' => $balance]
        );

        $this->info("Updated balance for account {$accountId}: {$balance}");
    }
} 