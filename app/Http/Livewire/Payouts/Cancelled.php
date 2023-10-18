<?php

namespace App\Http\Livewire\Payouts;

use App\Models\Payout;
use Livewire\Component;

class Cancelled extends Component
{
    public $cancelledPayouts;

    public function mount()
    {
        $this->cancelledPayouts = Payout::where('status', 'cancelled')->get();

        return $this->cancelledPayouts;
    }

    public function render()
    {
        return view('livewire.payouts.cancelled');
    }
}
