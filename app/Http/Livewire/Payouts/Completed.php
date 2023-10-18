<?php

namespace App\Http\Livewire\Payouts;

use App\Models\Payout;
use Livewire\Component;

class Completed extends Component
{
    public $completedPayouts;

    public function mount()
    {
        $this->completedPayouts = Payout::where('status', 'completed')->get();

        return $this->completedPayouts;
    }

    public function render()
    {
        return view('livewire.payouts.completed');
    }
}
