<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DepositPaymentsController extends Controller
{
    public function index()
    {
        //
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $deposit_payment = new \App\DepositPayment;
        $deposit_payment->description = $request->description;
        $deposit_payment->deposits_id = $request->deposit_id;
        $deposit_payment->bi_head_id = $request->bi_head_id;
        $deposit_payment->amount = $request->amount;

        $deposit_payment->save();

        $deposit = \App\ConsigneeDeposit::findOrFail($request->deposit_id);
        $deposit->currentBalance = ($deposit->currentBalance - $request->amount);
        $deposit->save();

        return $deposit_payment;
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
