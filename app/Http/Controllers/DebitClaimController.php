<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\AccBrandTotal;
use App\DebitClaim;
use Illuminate\Http\Request;

class DebitClaimController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $this->validate($request,[
            'brand_id_for_debit' => 'required|integer|max:1000',
            'claimable_amount' => 'required|numeric',
            'debit_received' => 'required|numeric',
            'remaining_claim' => 'required|numeric',
        ]);

        $data = $request->all();
        $data["brand_id"] = $data["brand_id_for_debit"];

        try
        {
            DebitClaim::create($data);

            $damage = AccBrandTotal::where('brand_id','=',$data['brand_id'])->firstOrFail();
            $damage_data["total_claim_amount"] = $damage["total_claim_amount"] - $data["debit_received"];
            $damage->update($damage_data);

            DB::commit();
            Session::flash('success_message', 'Debit Successfully Claimed');
        }
        catch(\Exception $ex)
        {
            DB::rollback();
            Session::flash('error_message', $ex->getMessage());
        }

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DebitClaim  $debitClaim
     * @return \Illuminate\Http\Response
     */
    public function show(DebitClaim $debitClaim)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DebitClaim  $debitClaim
     * @return \Illuminate\Http\Response
     */
    public function edit(DebitClaim $debitClaim)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DebitClaim  $debitClaim
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DebitClaim $debitClaim)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DebitClaim  $debitClaim
     * @return \Illuminate\Http\Response
     */
    public function destroy(DebitClaim $debitClaim)
    {
        //
    }
}
