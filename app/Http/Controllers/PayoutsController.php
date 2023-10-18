<?php

namespace App\Http\Controllers;

class PayoutsController extends Controller
{
    //

    public function intiate()
    {
        return view('payouts.initiate');
    }

    public function initiated()
    {
        return view('payouts.initiated');
    }

    public function completed()
    {
        return view('payouts.completed');
    }

    public function cancelled()
    {
        return view('payouts.cancelled');
    }

    public function index()
    {

        return view('payouts.index');
    }
}
