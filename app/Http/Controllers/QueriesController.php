<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class QueriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // var i, j, n;
        // found = false;
        // n = rate_pairs.length;

        // for (i=0; i<n; i++) {                        
        //     for (j=i+1; j<n; j++)
        //     {              
        //         if (rate_pairs[i].from === rate_pairs[j].from && rate_pairs[i].to === rate_pairs[j].to){
        //             found = true;
        //             from[i].style.borderColor = 'red';
        //             to[i].style.borderColor = 'red';

        //             from[j].style.borderColor = 'red';
        //             to[j].style.borderColor = 'red';
        //         }
        //     }   
        // }

        // $unique_desc = [];
        // $items = \  DB::select("SELECT id, descriptionOfGoods FROM delivery_container_details UNION ( SELECT id, descriptionOfGoods FROM delivery_non_container_details);");
        // return count($items);
        // foreach ($items as $item) {
        //     for($i = 0; $i < ; $i++){
        //         if($unique_desc[$i] != $item->descriptionOfGoods){
        //             array_push($unique_desc, $item->descriptionOfGoods);
        //         }
        //     }
        // }
        // return $unique_desc;

        return view('queries.queries_index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
