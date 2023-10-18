<?php

namespace App\Http\Livewire;

use App\Models\Account;
use App\Models\Bank as ModelsBank;
use App\Models\Branch;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Livewire\Component;

class Bank extends Component
{
    public $banks;

    public $getMerchantBank;

    public $getMerchantbankbranches;

    public $accountName;

    public $accountNumber;

    public $bankId;

    public $branchName;

    public ModelsBank $bank;

    public function updatedGetMerchantBank()
    {
        $this->getMerchantbankbranches = ModelsBank::with('branches')->where('id', $this->getMerchantBank)->get();

        return $this->getMerchantbankbranches;
    }

    protected $rules = [
        'accountName' => 'required',
        'accountNumber' => 'required',
        'bankId' => 'required',
        'branchName' => 'required',
    ];

    public function submit(Request $request)
    {

        $this->validate();

        $bank = ModelsBank::find($this->bankId);

        $merchant = Merchant::findOrFail(auth()->user()->merchant_id);

        $account = new Account();
        $account->account_name = $this->accountName;
        $account->account_number = $this->accountNumber;
        $account->merchant_id = $merchant->id;

        $bank->accounts()->save($account);

        $bank->merchants()->bank_id = $this->bankId;

        $bank->merchants()->save($merchant);

        $branch = new Branch();
        $branch->branch_name = $this->branchName;

        $bank->branches()->save($branch);

        session()->flash('message', 'Bank Added Successfully');

        return redirect()->route('bank.create');

    }

    public function render()
    {
        $this->banks = ModelsBank::all();

        return view('livewire.bank');
    }
}
