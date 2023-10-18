<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMerchantRequest;
use App\Http\Requests\UpdateMerchantRequest;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MerchantController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //perform search and pagination here
        $searchTerm = $request->input('search');
        $merchants = Merchant::when($searchTerm, function ($query) use ($searchTerm) {
            return $query->where('business_name', 'like', '%'.$searchTerm.'%');
        })->paginate(20);

        return view('merchants.index', compact('merchants', 'searchTerm'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('merchants.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMerchantRequest $request)
    {

        $validatedData = $request->validated();

        $validatedData['client_id'] = Str::random(40);
        $validatedData['client_secret'] = Str::random(60);

        Merchant::create($validatedData);

        return redirect(route('merchants.index'))->with('success', 'Merchant created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Merchant $merchant)
    {
        return view('merchants.show', compact('merchant'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Merchant $merchant)
    {

        return view('merchants.edit', compact('merchant'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMerchantRequest $request, Merchant $merchant)
    {

        $merchant->update($request->validated());

        return redirect(route('merchants.index'))->with('success', 'Merchant updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Merchant $merchant)
    {
        $merchant->delete();

        return redirect(route('merchants.index'))->with('success', 'Merchant deleted successfully.');
    }
}
