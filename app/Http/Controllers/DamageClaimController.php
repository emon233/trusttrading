<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\AccBrandTotal;
use App\DamageClaim;
use Illuminate\Http\Request;

class DamageClaimController extends Controller
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
            'brand_id_for_damage' => 'required|integer|max:1000',
            'damage_amount' => 'required|numeric',
            'damage_received' => 'required|numeric',
            'remaining_damage' => 'required|numeric',
        ]);

        $data = $request->all();
        $data["brand_id"] = $data["brand_id_for_damage"];

        try
        {
            DamageClaim::create($data);

            $damage = AccBrandTotal::where('brand_id','=',$data['brand_id'])->firstOrFail();
            $damage_data["total_damage_amount"] = $damage["total_damage_amount"] - $data["damage_received"];
            $damage->update($damage_data);

            DB::commit();
            Session::flash('success_message', 'Damage Successfully Claimed');
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
     * @param  \App\DamageClaim  $damageClaim
     * @return \Illuminate\Http\Response
     */
    public function show(DamageClaim $damageClaim)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DamageClaim  $damageClaim
     * @return \Illuminate\Http\Response
     */
    public function edit(DamageClaim $damageClaim)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DamageClaim  $damageClaim
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DamageClaim $damageClaim)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DamageClaim  $damageClaim
     * @return \Illuminate\Http\Response
     */
    public function destroy(DamageClaim $damageClaim)
    {
        //
    }
}
