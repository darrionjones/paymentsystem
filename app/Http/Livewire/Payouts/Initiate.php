<?php

namespace App\Http\Livewire\Payouts;

use App\Models\Payout as ModelsPayout;
use App\Models\Transaction;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

//this is the the working intiate payment wire class
class Initiate extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $selectedTransactions = [];

    public $endDate;

    public $allTransactions = false;

    public $merchantsToIntiatePayouts;

    public $status;

    //this method is excuuted when initiate payment button is clicked to initiate payout for select merchants
    public function initiatePayment()
    {
        $initiatePaymentResult = $this->getMerchantTransactions()->whereIn('id', $this->selectedTransactions);

        foreach ($initiatePaymentResult as $key => $merchant) {

            // Transaction::find($transactionValue->);
            $payout = ModelsPayout::create([
                'business_name' => $merchant->business_name,
                'total_collected' => $merchant->transactions_sum_amount,
                'total_recieved' => $merchant->transactions_sum_amount,
                'status' => 'initiated',
                'merchant_id' => $merchant->id,
            ]);

            foreach ($merchant->transactions as $transaction) {

                $transaction->payout_id = $payout->id;

                $transaction->save();
            }
        }
        session()->flash('success', 'Payout successfully Initiated');

        return redirect()->route('payouts.inititated', [
            'status' => 'initiated',
        ]);

        $this->dispatch('payout-initiated');
    }

    //This method is called whenever the check button to select all merchants or a selected merchant to be processed is clicked
    public function updatedallTransactions($value)
    {

        if ($value) {

            $selectedTransactionsCollection = collect($this->getMerchantTransactions());

            $this->selectedTransactions = $selectedTransactionsCollection->pluck('id')->toArray();
        } else {
            $this->selectedTransactions = [];
        }
    }

    public function updatedEndDate($value)
    {
        $this->endDate = Carbon::createFromFormat('Y-m-d', $value);
    }

    // public function cancelPayout()
    // {
    //     $initiatePaymentResult = $this->getMerchantTransactions()->whereIn('id', $this->selectedTransactions);

    //     foreach ($initiatePaymentResult as $key => $merchant) {

    //         // Transaction::find($transactionValue->);
    //         $payout = ModelsPayout::create([
    //             'business_name' => $merchant->business_name,
    //             'total_collected' => $merchant->transactions_sum_amount,
    //             'total_recieved' => $merchant->transactions_sum_amount,
    //             'status' => 'cancelled',
    //             'merchant_id' => $merchant->id
    //         ]);

    //         foreach ($merchant->transactions as $transaction) {

    //             $transaction->payout_id = $payout->id;

    //             $transaction->save();
    //         }
    //     }
    //     session()->flash('message', 'Payout Cancelled');

    // }

    public function getMerchantTransactions()
    {

        try {
            $merchantTransactions = \App\Models\Merchant::with('transactions')->withSum('transactions', 'amount')
                ->whereHas('transactions', function ($query) {
                    return $query->where('payout_id', null)
                        ->where('created_at', '<=', $this->endDate);
                })->get();

            return $merchantTransactions;
        } catch (\Throwable $th) {
        }
    }

    public function intiatedPayouts($filter)
    {
        return $filter;
    }

    public function render()
    {
        if ($this->endDate) {

            $this->merchantsToIntiatePayouts = $this->getMerchantTransactions();
        }

        return view('livewire.payouts.initiate');
    }
}
