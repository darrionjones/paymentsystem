<?php

namespace App\Http\Livewire;

use App\Models\Payout;
use Livewire\Component;

class CompletePayouts extends Component
{
    public $allPayouts = false;

    public $requestFilter;

    public $selectedPayouts = [];

    public function mount()
    {

        $this->requestFilter = request('filter');
    }

    public function updatedallPayouts($value)
    {

        if ($value) {
            $payouts = collect($this->getAllPayouts());
            $this->selectedPayouts = $payouts->pluck('id')->toArray();
        } else {
            $this->selectedPayouts = [];
        }
    }

    public function cancelPayout()
    {
        $completePayouts = $this->getAllPayouts('initiated')->whereIn('id', $this->selectedPayouts);

        foreach ($completePayouts as $key => $payout) {

            $payout->status = 'completed';

            $payout->save();
        }

        session()->flash('message', 'Payout Cancelled');

    }

    public function getAllPayouts($status)
    {
        return Payout::where('status', $status)->get();
    }

    public function completePayment()
    {
        $completePayouts = $this->getAllPayouts('initiated')->whereIn('id', $this->selectedPayouts);

        foreach ($completePayouts as $key => $payout) {

            $payout->status = 'completed';

            $payout->save();
        }

        session()->flash('message', 'Payout successfully Completed');
    }

    public function render()
    {

        $payoutStatus = $this->getAllPayouts('initiated');

        return view('livewire.complete-payouts', [
            'payoutStatus' => $payoutStatus,
            // 'requestFilter' => $this->requestFilter
        ]);
    }
}
