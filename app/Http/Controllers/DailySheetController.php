<?php

namespace App\Http\Controllers;


use DB;
use Session;
use App\Stock;
use App\DailySheet;
use App\AccClientTransaction;
use App\AccDailyBrandTransaction;
use App\DailyZoneDeliverymanCombo;
use Illuminate\Http\Request;


class DailySheetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $id = $id;

        $products = DailySheet::where('daily_zone_delivery_man_combo_id',$id)->with(['product'])->get();
        $zone_deliveryman = DailyZoneDeliverymanCombo::where('id',$id)->with(['zone','delivery_man'])->get();
        
        return view('/stocks/dailyoutmorningproduct', compact('id','products','zone_deliveryman'));
    }

    public function evening_index($id)
    {
        $id = $id;

        $products = DailySheet::where('daily_zone_delivery_man_combo_id',$id)->with(['product'])->get();
        $zone_deliveryman = DailyZoneDeliverymanCombo::where('id',$id)->with(['zone','delivery_man'])->get();
        $due_transactions = AccClientTransaction::where('daily_zone_deliveryman_id',$id)->with(['client'])->get();
        
        return view('/stocks/dailyoutevening', compact('id','products','zone_deliveryman','due_transactions'));
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
            'product_id' => 'required|integer|max:100000000',
            'daily_zone_delivery_man_combo_id' => 'required|integer|max:1000000000000',
            'product_out_amount' => 'required|integer|max:100000'
        ]);

        $data = $request->all();
        $msg = "";
        DB::beginTransaction();
        
        try
        {
            DailySheet::create($data);

            $stock = Stock::where('product_id', $data["product_id"])->firstOrFail();
            $stock_data["stock_amount"] = $stock->stock_amount - $data["product_out_amount"];
            $stock->update($stock_data);

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
     * Display the specified resource.
     *
     * @param  \App\DailySheet  $dailySheet
     * @return \Illuminate\Http\Response
     */
    public function show(DailySheet $dailySheet)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DailySheet  $dailySheet
     * @return \Illuminate\Http\Response
     */
    public function edit(DailySheet $dailySheet)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DailySheet  $dailySheet
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'product_out_amount' => 'required|integer|max:100000',
            'product_return_amount' => 'required|integer|max:10000',
            'unit_price' => 'required|numeric|max:1000000',
            'total_price' => 'required|numeric|max:10000000',
            'id' => 'required|integer',
        ]);

        $data = $request->all();
        $msg = "";
        DB::beginTransaction();
        
        try
        {
            $dailyData = DailySheet::find($data["id"]);
            $stock = Stock::where('product_id', $dailyData->product_id)->firstOrFail();
            $dailyZoneDeliveryman = DailyZoneDeliverymanCombo::find($dailyData["daily_zone_delivery_man_combo_id"]);

            $stock_data["stock_amount"] = $stock->stock_amount + $data["product_return_amount"];
            $stock->update($stock_data);

            $dailyZoneDeliveryman_data["total_receivable"] = $dailyZoneDeliveryman->total_receivable + $data["total_price"];
            $dailyZoneDeliveryman_data["net_receivable"] = $dailyZoneDeliveryman->net_receivable + $data["net_total_price"];
            $dailyZoneDeliveryman->update($dailyZoneDeliveryman_data);

            $dailyData->update($data);
            
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
     * @param  \App\DailySheet  $dailySheet
     * @return \Illuminate\Http\Response
     */
    public function destroy(DailySheet $dailySheet)
    {
        //
    }

    public function dailysheetupdate(Request $request)
    {
        $id = $request->get('id');

        $data = DailySheet::find($id);
        return response()->json($data);
    }

    public function updateProductSellInfo(Request $request)
    {
        $data = $request->all();

        DB::beginTransaction();
        
        try
        {
            $entry = DailySheet::find($data["entry_id"]);
            
            $entry_data['product_return_amount'] = $data['return'];
            $entry_data['net_total_price'] = ($data['out'] - $data['return']) * $data['net_price'];
            $entry_data['unit_price'] = $data['sell_price'];
            $entry_data['total_price'] = ($data['out'] - $data['return']) * $data['sell_price'];
    
            $stock = Stock::where('product_id','=',$entry->product_id)->firstOrFail();
            $stock_data['stock_amount'] = ($stock->stock_amount - $entry->product_return_amount) + $entry_data['product_return_amount'];
            $stock->update($stock_data);
    
            $combo = DailyZoneDeliverymanCombo::find($entry["daily_zone_delivery_man_combo_id"]);
            $combo_data["net_receivable"] = ($combo->net_receivable - $entry["net_total_price"]) + $entry_data['net_total_price'];
            $combo_data["total_receivable"] = ($combo->total_receivable - $entry["total_price"]) + $entry_data['total_price'];
            
            $combo_data["total_due"] = $combo_data["total_receivable"] - $combo["total_received"];
            
            if($combo_data["net_receivable"] > $combo_data["total_receivable"])
            {
                $combo_data['total_claimable'] = $combo_data["net_receivable"] - $combo_data["total_receivable"];
            }
            else
            {
                $combo_data['total_claimable'] = 0.00;
            }
    
            $combo->update($combo_data);
            $entry->update($entry_data);

            DB::commit();
            Session::flash('flash_message',"Update Successful");
        }

        catch(\Exception $ex)
        {
            DB::rollback();
            Session::flash('error_message',$ex->getMessage());
        }

        return redirect()->back();
    }
}
