<?php

namespace App\Http\Livewire\Payouts;

use App\Models\Payout as ModelsPayout;
use App\Models\Transaction;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class Initiated extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['payout-initiated'];

    public $selectedTransactions = [];

    public $endDate;

    public $allTransactions = false;

    public $merchants;

    public $status;

    public $allMerchantInitiatedPayouts = [];

    public $allInitiatedPayouts;

    //this function returns all merchants whose payout been intiated
    // public function getInitiatedMerchants(){

    //     return $this->allMerchantInitiatedPayouts;
    // }

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

    //This function is called when user clicks on checkbox for all or a selected initiated payouts.
    //it will pick only the id of the payouts and convert it to array
    public function updatedallInitiatedPayouts($value)
    {

        if ($value) {

            $this->selectedTransactions = ModelsPayout::where('status', 'initiated')->pluck('id')->toArray();

        } else {
            $this->selectedTransactions = [];
        }
    }

    //this function will change all selected payout intiated status to completed
    public function completedPayout()
    {
        $initiatedPayouts = ModelsPayout::whereIn('id', $this->selectedTransactions)->get();

        foreach ($initiatedPayouts as $key => $initiatedPayout) {

            // Transaction::find($transactionValue->);
            $initiatedPayout->update([
                'status' => 'completed',
            ]);
        }
        session()->flash('success', 'Payout Completed Successfully');

        return redirect()->route('payouts.completed', [
            'status' => 'completed',
        ]);
    }

    public function cancelPayout()
    {
        $initiatedPayouts = ModelsPayout::whereIn('id', $this->selectedTransactions)->get();

        foreach ($initiatedPayouts as $key => $initiatedPayout) {

            // Transaction::find($transactionValue->);
            $initiatedPayout->update([
                'business_name' => $initiatedPayout->business_name,
                'total_collected' => $initiatedPayout->total_collected,
                'total_recieved' => $initiatedPayout->total_recieved,
                'status' => 'cancelled',
            ]);
        }
        session()->flash('success', 'Payout Cancelled Successfully');

        return redirect()->route('payouts.cancelled', [
            'status' => 'cancelled',
        ]);
    }

    public function updatedEndDate($value)
    {
        $this->endDate = Carbon::createFromFormat('Y-m-d', $value);
    }

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
        //return all merchants whose payout been intiated
        $this->allMerchantInitiatedPayouts = ModelsPayout::where('status', 'initiated')->latest()->get();

        return view('livewire.payouts.initiated');
    }
}
