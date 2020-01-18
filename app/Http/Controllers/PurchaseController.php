<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\Stock;
use App\Product;
use App\Purchase;


use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if($id == 0)
        {
            $stocks = Product::with(['stocks','brand','category'])->orderBy("brand_id")->get();
        }

        else
        {
            $stocks = Product::where('brand_id',$id)->with(['stocks','brand','category'])->orderBy("brand_id")->get();
        }

        return view('/stocks/purchases', compact('stocks'));
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
            'product_id' => 'required|integer|max:1000000',
            'amount' => 'required|integer|max:1000000',
            'unit_price' => 'required|numeric|max:1000000',
            'percent' => 'required|numeric|max:100',
        ]);
        $data = $request->all();

        $data["total_price"] = $data["amount"] * $data["unit_price"];
        
        DB::beginTransaction();
        try
        {
            Purchase::create($data);
            
            $product = Product::find($data["product_id"]);
            $stock = Product::find($data["product_id"])->stocks;

            $total_price = ($stock->stock_amount * $product->purchase_rate) + $data["total_price"];
            $stock_data["stock_amount"] = $stock->stock_amount + $data["amount"];

            $product_data["purchase_rate"] = floatval($total_price/$stock_data["stock_amount"]);
            //$nothing = $product_data["purchase_rate"];
            $profit = floatval($data["percent"]/100);
            
            $profit_per_unit = floatval($product_data["purchase_rate"] * $profit);
            
            $new_sell_rate = floatval($product_data["purchase_rate"] + $profit_per_unit);
            
            $product_data["sell_rate"] = round($new_sell_rate);
            
            $product->update($product_data);

            $stocks = Stock::findOrFail($stock->id);
            $stocks->update($stock_data);
            
            
            DB::commit();
            Session::flash('flash_message', "Profit: ".$product_data["sell_rate"]." ");
        }
        catch(\Exception $ex)
        {
            DB::rollback();
            Session::flash('error_message', $ex->getMessage());
        }
        
        return redirect()->back();
    }

    public function history($id)
    {
        $histories = Purchase::with(['product'])->where('product_id','=',$id)->get();

        return view('/histories/purchasehistory', compact('histories'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Purchase $purchase)
    {
        $this->validate($request, [
            'amount' => 'required|integer|max:1000000',
            'unit_price' => 'required|numeric|max:1000000',
        ]);
        $data = $request->all();

        $data["total_price"] = $data["amount"] * $data["unit_price"];

        DB::beginTransaction();
        try
        {
            $purchase = Purchase::findOrFail($data["id"]);

            $stock = Stock::where('product_id', $purchase->product_id)->firstOrFail();
            $stock_data["stock_amount"] = ($stock->stock_amount - $purchase->amount) + $data["amount"];
            $stock->update($stock_data);

            $purchase->update($data);

            DB::commit();
            Session::flash('flash_message','Data Updated Successfully');
        }
        catch(\Exception $ex)
        {
            DB::rollback();
            Session::flash('error_message',$ex->getMessage());
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        //
    }

    public function product_search_for_purchase(Request $request)
    {
        $brand_id = $request->get('brand_id');
        $category_id = $request->get('category_id');
        $stocks = "";
        if($brand_id != 0  && $category_id != 0)
        {
            $stocks = Product::with(['stocks','brand','category'])->where([['brand_id','=',$brand_id],['category_id','=',$category_id]])->get();
        }
        elseif($brand_id != 0)
        {
            $stocks = Product::with(['stocks','brand','category'])->where('brand_id','=',$brand_id)->get();
        }
        elseif($category_id != 0)
        {
            $stocks = Product::with(['stocks','brand','category'])->where('category_id','=',$category_id)->get();
        }
        else
        {
            $stocks = Product::with(['stocks','brand','category'])->get();
        }
        
        return view('/stocks/purchases', compact('stocks'));
    }
    
    public function resetProductInfo(Request $request)
    {
        $data = $request->all();
        
        DB::beginTransaction();
        try
        {
            $product = Product::where('id','=',$data['entry_id'])->first();
            $product->purchase_rate = $data['new_purchase_rate'];
            $product->sell_rate = $data['new_sell_rate'];
            $product->update();
            
            $stock = Stock::where('product_id','=',$data['entry_id'])->first();
            $stock->stock_amount = $data['new_stock'];
            $stock->update();
            
            DB::commit();
        }
        catch(\Exception $ex)
        {
            DB::rollback();
            return $ex->getMessage();
        }
        return redirect()->back();
    }
}
