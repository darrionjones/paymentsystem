<?php

namespace App\Http\Livewire;

use App\Models\Payout as ModelsPayout;
use App\Models\Transaction;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Payout extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $selectedTransactions = [];

    public $endDate;

    public $allTransactions = false;

    public $merchants;

    public $status;

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
        session()->flash('message', 'Payout successfully Initiated');
    }

    public function updatedallTransactions($value)
    {
        if ($value) {

            $selectedTransactionsCollection = collect($this->getMerchantTransactions());

            $this->selectedTransactions = $selectedTransactionsCollection->pluck('id')->toArray();
        } else {
            $this->selectedTransactions = [];
        }
    }

    // public function updatedEndDate($value)
    // {
    //     $this->endDate = Carbon::createFromFormat('Y-m-d', $value);
    // }

    public function getMerchantTransactions()
    {

        $merchantTransactions = \App\Models\Merchant::with('transactions')->withSum('transactions', 'amount')
            ->whereHas('transactions', function ($query) {
                return $query->where('payout_id', null)
                    ->where('created_at', '<=', Carbon::createFromFormat('Y-m-d', $this->endDate));
            })->get();

        return $merchantTransactions;
    }

    public function intiatedPayouts($filter)
    {
        return $filter;
    }

    public function render()
    {
        //

        $this->merchants = $this->endDate ? $this->getMerchantTransactions() : '';

        return view('livewire.payout', ['merchants' => $this->merchants]);
    }
}
