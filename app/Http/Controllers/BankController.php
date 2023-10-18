<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Merchant;
use Illuminate\Http\Request;

class BankController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

        $currentMerchant = Merchant::findOrFail(auth()->user()->merchant_id);

        return view('merchants.banks.index', compact('currentMerchant'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('merchants.banks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        Bank::firstOrCreate(
            ['merchant_id' => auth()->user()->merchant_id],
            [
                'account_name' => $request->account_name,
                'account_number' => $request->account_number,
                'bank_name' => $request->bank_name,
                'branch_name' => $request->branch_name,
            ]
        );

        return back()->with('success', 'Bank Added');
    }

    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Bank $bank)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Bank $bank)
    {
        //

        return view('merchants.banks.edit', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bank $bank)
    {
        //

        $bank->update([
            'bank_name' => $request->bank_name,
            'branch_name' => $request->branch_name,
            'account_name' => $request->account_name,
            'account_number' => $request->account_number,
            'merchant_id' => auth()->user()->merchant_id,

        ]);

        return back()->with('success', 'Bank Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Bank $bank)
    {
        //

    }
}
