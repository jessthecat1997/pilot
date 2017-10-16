<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ExchangeRate;
use App\Http\Requests\StoreExchangeRate;

class ExchangeRatesController extends Controller
{
    public function index()
    {
       $ers = DB::select("SELECT *, DATEDIFF(dateEffective, CURRENT_DATE()) AS diff FROM exchange_rates ORDER BY CASE WHEN diff < 0 THEN 1 ELSE 0 END, diff");

        
        if(count($ers) == 0)
        {
            $no_current = "true";


        }
        else
        {
            $no_current = "false";

            $current = $ers[count($ers) -1 ];

            \DB::update('UPDATE exchange_rates SET currentRate = 0 WHERE  id != ' . $current->id);
            \DB::update('UPDATE exchange_rates SET currentRate = 1 WHERE  id = ' . $current->id);

            $exchange_rate_current = \DB::table('exchange_rates')
            ->select('rate')
            ->where('currentRate', '=', 1)
            ->get();

            if(count($exchange_rate_current) == 0){
                $exchange_rate_current[0]->rate = 0;
            }
        }

        $exchange_rate = \App\ExchangeRate::all();

        return view('admin/maintenance.exchange_rate_index', compact(['exchange_rate_current', 'exchange_rate', 'no_current']));
    }


    public function store(StoreExchangeRate $request)
    {
        $er = ExchangeRate::create($request->all());
        return $er;
    }

    public function update(StoreExchangeRate $request, $id)
    {
        $exchange_rate = ExchangeRate::findOrFail($id);
        $exchange_rate->description = $request->description;
        $exchange_rate->rate = $request->rate;
        $exchange_rate->dateEffective = $request->dateEffective;
        $exchange_rate->currentRate = $request->currentRate;
        $exchange_rate->save();

        return $exchange_rate;
    }


    public function destroy($id)
    {
        $exchange_rate = ExchangeRate::findOrFail($id);
        $exchange_rate->delete();

    }
    
    public function reactivate(Request $request)
    {
        $exchange_rate = ExchangeRate::withTrashed()
        ->where('id',$request->id)
        ->restore();

    }

    public function er_utilities(){

        return view('admin/utilities.exchange_rate_utility_index');
    }
}
