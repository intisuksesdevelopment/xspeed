<?php

namespace App\Console\Commands;

use App\Models\Sale;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class GenerateUuidsForSales extends Command
{
    protected $signature = 'sales:generate-uuids';
    protected $description = 'Generate UUIDs for existing sales';

    public function handle()
    {
        $sales = Sale::whereNull('uuid')->get();
        $count = 0;

        foreach ($sales as $sale) {
            $sale->uuid = (string) Str::uuid();
            $sale->save();
            $count++;
        }

        $this->info("Generated UUIDs for {$count} sales.");
    }
}
