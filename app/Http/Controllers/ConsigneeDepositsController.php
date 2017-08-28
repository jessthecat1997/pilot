<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConsigneeDepositsController extends Controller
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
        $new_deposit = new \App\ConsigneeDeposit;
        $new_deposit->amount = $request->amount;
        $new_deposit->currentBalance = $request->amount;
        $new_deposit->description = $request->description;
        $new_deposit->consignees_id = $request->consignees_id;

        $new_deposit->save();

        return $new_deposit;

    }
    public function getConsigneeDeposits(Request $request)
    {
        $deposits = \DB::table('consignee_deposits')
        ->select(
            'id',
            'created_at',
            \DB::raw('CONCAT("Php ", amount) as amount') ,
            \DB::raw('CONCAT("Php ", currentBalance) as currentBalance'),
            'description'
            )
        ->where('consignees_id', '=', $request->id)
        ->get();

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
