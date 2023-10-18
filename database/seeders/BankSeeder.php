<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $banks = [
            'Absa Bank Ghana Limited',
            'Access Bank Ghana PLC',
            'Agricultural Development Bank of Ghana',
            'Bank of Africa Ghana',
            'CalBank Limited',
            'Consolidated Bank Ghana Limited',
            'Eco Bank Ghana Limited',
            'FBN Bank Ghana Limited',
            'Fidelity Bank Ghana Limited',
            'First Atlantic Bank Limited',
            'First National Bank Ghana',
            'GCB Bank Limited',
            'Guaranty Trust Bank Ghana Limited',
            'National Investment Bank Limited',
            'Zenith Bank Ghana Limited',
            'OmniBSIC Bank Ghana Limited',
            'Prudential Bank Limited',
            'Republic Bank Ghana Limited',
            'Societe Generale Ghana Limited',
            'Stanbic Bank Ghana Limited',
            'Standard Chartered Bank Ghana Limited',
            'United Bank of Africa Ghana limited',
            'Universal Merchant Bank',
        ];

        foreach ($banks as $key => $bank) {

            Bank::create([
                'bank_name' => $bank,
            ]);
        }

    }
}
