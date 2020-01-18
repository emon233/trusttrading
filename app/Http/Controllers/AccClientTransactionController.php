<?php

namespace App\Http\Controllers;

use DB;
use App\AccBrandTotal;
use App\DailyZoneDeliverymanCombo;
use App\AccDailyBrandTransaction;
use App\AccClientTransaction;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AccClientTransactionController extends Controller
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

        $this->validate($request, [
            'client_id' => 'required|integer|max:10000000',
            'daily_zone_deliveryman_id' => 'required|integer',
            'transaction_type' => 'required|string|max:10',
            'transaction_amount' => 'required|numeric|max:10000000'
        ]);

        $data = $request->all();
        $msg = "";

        DB::beginTransaction();

        try {
            $combo = DailyZoneDeliverymanCombo::find($data['daily_zone_deliveryman_id']);
            $data['brand_id'] = $combo->brand_id;
            AccClientTransaction::create($data);

            $brand_id = DailyZoneDeliverymanCombo::where('id', '=', $data["daily_zone_deliveryman_id"])->firstOrFail()->brand_id;

            if ($data["transaction_type"] == "Paid") {
                $brand_total = AccBrandTotal::where('brand_id', '=', $brand_id)->firstOrFail();
                $update_brand_total["total_market_due_amount"] = $brand_total["total_market_due_amount"] - $data["transaction_amount"];
                $update_brand_total["total_cash_amount"] = $brand_total["total_cash_amount"] + $data["transaction_amount"];
                $brand_total->update($update_brand_total);

                $brand_daily = AccDailyBrandTransaction::where([['brand_id', '=', $brand_id], ['date', '=', Carbon::today()]])->first();

                if ($brand_daily === null) {
                    $brand_data["brand_id"] = $brand_id;
                    $brand_data["date"] = Carbon::today();

                    $brand_daily = AccDailyBrandTransaction::create($brand_data);
                }
                $brand_daily = AccDailyBrandTransaction::where([['brand_id', '=', $brand_id], ['date', '=', Carbon::today()]])->first();
                $update_brand_daily["due_collection"] = $brand_daily["due_collection"] + $data["transaction_amount"];
                $brand_daily->update($update_brand_daily);
            }

            DB::commit();
            $msg = "Success";
        } catch (\Exception $ex) {
            DB::rollback();
            $msg = $ex->getMessage();
        }

        return response()->json($msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AccClientTransaction  $accClientTransaction
     * @return \Illuminate\Http\Response
     */
    public function show(AccClientTransaction $accClientTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AccClientTransaction  $accClientTransaction
     * @return \Illuminate\Http\Response
     */
    public function edit(AccClientTransaction $accClientTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AccClientTransaction  $accClientTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccClientTransaction $accClientTransaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AccClientTransaction  $accClientTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccClientTransaction $accClientTransaction)
    {
        //
    }
}
