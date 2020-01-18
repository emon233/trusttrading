<?php

namespace App\Http\Controllers;

use App\DailyZoneDeliverymanCombo;
use Illuminate\Http\Request;
use DB;
use Session;
use Carbon\Carbon;
use App\Http\Controllers\DailySheetController;
use App\AccDailyBrandTransaction;
use App\AccBrandTotal;

class DailyZoneDeliverymanComboController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $combos = DailyZoneDeliverymanCombo::whereDate('created_at',Carbon::today())->with(['zone','delivery_man','brand'])->get();
        
        return view('/stocks/dailyoutmorning', compact('combos'));
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
            'zone_id' => 'required|integer|max:100000',
            'delivery_man_id' => 'required|integer|max:100000',
            'brand_id' => 'required|integer|max:1000000'
        ]);

        $data = $request->all();

        try
        {
            $combo = DailyZoneDeliverymanCombo::create($data);

            Session::flash('flash_message','Successfully Assigned Delivery Man To Zone');
            Session::flash('daily_zone_deliverman_combo_id', $combo->id);
        }
        catch(\Exception $ex)
        {
            Session::flash('error_message',$ex->getMessage());

            return redirect()->back();
        }

        return redirect()->route('morningoutproducts',[$combo->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DailyZoneDeliverymanCombo  $dailyZoneDeliverymanCombo
     * @return \Illuminate\Http\Response
     */
    public function show(DailyZoneDeliverymanCombo $dailyZoneDeliverymanCombo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DailyZoneDeliverymanCombo  $dailyZoneDeliverymanCombo
     * @return \Illuminate\Http\Response
     */
    public function edit(DailyZoneDeliverymanCombo $dailyZoneDeliverymanCombo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DailyZoneDeliverymanCombo  $dailyZoneDeliverymanCombo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'total_receivable' => 'required|numeric',
            'total_received' => 'required|numeric',
            'total_due' => 'required|numeric',
            'total_claimable' => 'required|numeric',
        ]);
        $data = $request->all();

        DB::beginTransaction();
        try
        {
            $combo = DailyZoneDeliverymanCombo::find($data["id"]);
            
            $date = $combo->created_at->toDateString();
            
            
            $acc_daily_brand_transaction = AccDailyBrandTransaction::where("brand_id",'=',$combo->brand_id)->whereDate('date','=',$date)->first();
            
            if($acc_daily_brand_transaction === null)
            {
                $brand_data["brand_id"] = $combo->brand_id;
                $brand_data["date"] = $date;

                $daily_brand_transaction = AccDailyBrandTransaction::create($brand_data);

                $new_data["net_product_sell"] = $data["net_receivable"];
                $new_data["product_sell"] = $data["total_receivable"];
                $new_data["collection"] = $data["total_received"];
                $new_data["market_due"] = $data["total_due"];
                $new_data["debit_claim"] = $data["total_claimable"] + $data["total_company_claim"];
                $daily_brand_transaction->update($new_data);
            }

            else
            {
                $new_data["net_product_sell"] = $data["net_receivable"] + ($acc_daily_brand_transaction["net_product_sell"] - $combo->net_receivable);
                $new_data["product_sell"] = $data["total_receivable"] + ($acc_daily_brand_transaction["product_sell"] - $combo->total_receivable);
                $new_data["collection"] = $data["total_received"] + ($acc_daily_brand_transaction["collection"] - $combo->total_received);
                $new_data["market_due"] = $data["total_due"] + ($acc_daily_brand_transaction["market_due"] - $combo->total_due);
                $new_data["debit_claim"] = $data["total_claimable"] + $data["total_company_claim"] + ($acc_daily_brand_transaction["debit_claim"] - ($combo->total_claimable + $combo->total_company_claim));

                $acc_daily_brand_transaction->update($new_data);
            }
            
            $acc_brand = AccBrandTotal::where("brand_id",$combo->brand_id)->firstOrFail();

            $update_total["total_cash_amount"] = ($acc_brand->total_cash_amount - $combo->total_received) + $data["total_received"];
            $update_total["total_market_due_amount"] = ($acc_brand->total_market_due_amount - $combo->total_due) + $data["total_due"];
            $update_total["total_claim_amount"] = ($acc_brand->total_claim_amount - ($combo->total_claimable + $combo->total_company_claim)) + $data["total_claimable"] + $data["total_company_claim"];

            $acc_brand->update($update_total);
            $combo->update($data);
            DB::commit();
            
            $msg = "Success";
        }
        catch(\Exception $ex)
        {
            DB::rollback();
            $msg = $ex->getMessage();
        }

        return response()->json($msg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\DailyZoneDeliverymanCombo  $dailyZoneDeliverymanCombo
     * @return \Illuminate\Http\Response
     */
    public function destroy(DailyZoneDeliverymanCombo $dailyZoneDeliverymanCombo)
    {
        //
    }

    public function search_dailysheet_by_date(Request $request)
    {
        $combos = DailyZoneDeliverymanCombo::whereDate('created_at',$request->get('date'))->with(['zone','delivery_man','brand'])->get();

        return view('/stocks/dailyoutmorning', compact('combos'));
    }

    public function store_damage(Request $request)
    {
        $this->validate($request,[
            'total_damage' => 'required|numeric',
        ]);

        $data = $request->all();

        DB::beginTransaction();

        try
        {
            $combo = DailyZoneDeliverymanCombo::find($data["id"]);
            $date = $combo->created_at->toDateString();
            

            $acc_daily_brand_transaction = AccDailyBrandTransaction::where([["brand_id",'=',$combo->brand_id],['date','=',$date]])->first();
            
            if($acc_daily_brand_transaction === null)
            {
                $brand_data["brand_id"] = $combo->brand_id;
                $brand_data["date"] = $date;
                $brand_data["damage"] = $data["total_damage"];
                
                $daily_brand_transaction = AccDailyBrandTransaction::create($brand_data);
            }

            else
            {
                $new_data["damage"] = $data["total_damage"] + ($acc_daily_brand_transaction["damage"] - $combo->total_damage);
                $acc_daily_brand_transaction->update($new_data);
            }
            
            $acc_brand = AccBrandTotal::where("brand_id",$combo->brand_id)->firstOrFail();
            $update_total["total_damage_amount"] = ($acc_brand->total_damage_amount - $combo->total_damage) + $data["total_damage"];
            $acc_brand->update($update_total);

            $combo->update($data);
            
            DB::commit();
            $msg = "Success";
        }
        catch(\Exception $ex)
        {
            DB::rollback();
            $msg = $ex->getMessage();
        }
        return response()->json($msg);
    }
}
