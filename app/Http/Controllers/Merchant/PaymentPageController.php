<?php

namespace App\Http\Controllers\Merchant;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Models\PaymentPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Image;

class PaymentPageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $merchant = Auth::user();
        $paymentPages = PaymentPage::where('merchant_id', $merchant->merchant_id)->paginate(10);

        return view('merchants.payment-pages.index', compact('paymentPages'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $merchant = Auth::user();

        return view('merchants.payment-pages.create', compact('merchant'));
    }

    /**
     * Generate checkout url for merchant
     */
    public function store(Request $request)
    {

        //validate request
        $validatedData = $request->validate([
            'page_name' => 'required|string',
            'payment_type' => 'required|string',
            'ussd_payment' => 'string',
            'page_description' => 'string',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        //get merchant id of the logged in user
        $merchant = Auth::user();

        // Generate new UUID for the payment page
        $uuid = Str::uuid()->toString();

        //if the ussd payment type is selected, create a new ussd extension
        if ($request->input('ussd_payment') == 'yes') {
            $lastExtension = PaymentPage::orderByDesc('ussd_extension')->first()->ussd_extension;
            $ussd_extension = $lastExtension ? $lastExtension + 1 : 1000;
        }

        // Create a new payment page
        $paymentPage = new PaymentPage();
        $paymentPage->id = $uuid;
        $paymentPage->page_name = $request->input('page_name');
        $paymentPage->page_description = $request->input('page_description');
        $paymentPage->payment_type = 'one_time'; // For now, only one-time payments are supported
        $paymentPage->merchant_id = $merchant->merchant_id;
        $paymentPage->ussd_extension = $ussd_extension ?? null;
        $paymentPage->save();

        // Generate URL for the payment page
        $checkoutUrl = route('merchants.payment.checkout', $uuid);

        // Handle image upload
        if ($request->hasFile('image')) {

            $image = $request->file('image');
            $name_gen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();  // 3434343443.jpg

            $request->image->move(public_path('images/payment-pages/'), $name_gen);

            $paymentPage->update([
                'image' => $name_gen,
            ]);
        }

        return redirect()->route('merchants.payment-page.index')->with('success', 'Payment page created successfully. Checkout URL: '.$checkoutUrl);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $paymentPage = PaymentPage::findOrFail($id);

        return view('merchants.payment-pages.show', compact('paymentPage'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $paymentPage = PaymentPage::findOrFail($id);

        return view('merchants.payment-pages.edit', compact('paymentPage'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $uuid = Str::uuid()->toString();
        $paymentPage = PaymentPage::findOrFail($id);
        $paymentPage->page_name = $request->input('page_name');
        $paymentPage->payment_type = $request->input('payment_type');
        $paymentPage->page_description = $request->input('page_description');

        //if the ussd payment type is selected, create a new ussd extension
        if ($request->input('ussd_payment') == 'yes') {
            $lastExtension = PaymentPage::orderByDesc('ussd_extension')->first()->ussd_extension;
            $ussd_extension = $lastExtension ? $lastExtension + 1 : 1000;
        }

        $paymentPage->save();

        return redirect()->route('merchants.payment-page.index')->with('success', 'Payment page updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $paymentPage = PaymentPage::findOrFail($id);
        $paymentPage->delete();

        return redirect()->route('merchants.payment-page.index')->with('success', 'Payment page deleted successfully');
    }
}
