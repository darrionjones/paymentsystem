<?php

namespace Database\Seeders;

use App\Models\Merchant;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Merchant::factory(3)->create()->each(function ($merchant) {

            $numTransactions = random_int(5, 30);

            Transaction::factory()->count($numTransactions)->for($merchant)->create();
        });
    }
}
