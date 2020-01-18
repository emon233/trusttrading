<?php

namespace App\Http\Controllers;

use DB;
use Session;

use App\Brand;
use App\AccBrandTotal;
use App\AccBrandTransaction;

use App\Calculation;

use Illuminate\Http\Request;

class AccBrandTransactionController extends Controller
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

    public function pay_index()
    {
        $brands = Brand::all();

        foreach($brands as $key=>$brand)
        {
            Calculation::setTotalDamageAmountForBrand($brand->id);
            Calculation::setTotalClaimAmountForBrand($brand->id);
            Calculation::setTotalMarketDueForBrand($brand->id);
        }

        $brands = AccBrandTotal::with(['brand'])->get();
        
        return view('/accounts/payment', compact('brands'));
    }

    public function pay_history_index($id)
    {
        $histories = AccBrandTransaction::where('brand_id',$id)->with(['brand'])->get();
        $brand = Brand::where('id',$id)->first();
        return view('/histories/paymenthistory', compact('histories','brand'));
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
            'brand_id' => 'required|integer|max:10000',
            'transaction_type' => 'required|string|max:100',
            'transaction_amount' => 'required|numeric|max:1000000'
        ]);

        $data = $request->all();

        DB::beginTransaction();

        try
        {
            AccBrandTransaction::create($data);

            if($data["transaction_type"] == "Pay")
            {
                $total = AccBrandTotal::where('brand_id','=',$data["brand_id"])->first();
                $newTotalPaid = $total["total_paid_amount"] + $data["transaction_amount"];
                $newTotalDue = $total["total_due_amount"] + $data["transaction_amount"];
            
                $total->total_paid_amount = $newTotalPaid;
                $total->total_due_amount = $newTotalDue;
                
                $total->save();
            }
            else
            {
                $total = AccBrandTotal::where('brand_id','=',$data["brand_id"])->first();
                $newTotalDue = $total["total_due_amount"] - $data["transaction_amount"];

                $total->total_due_amount = $newTotalDue;
                $total->save();
            }
            
            DB::commit();
            Session::flash('flash_message',"Data Saved Successfully");
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
     * @param  \App\AccBrandTransaction  $accBrandTransaction
     * @return \Illuminate\Http\Response
     */
    public function show(AccBrandTransaction $accBrandTransaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AccBrandTransaction  $accBrandTransaction
     * @return \Illuminate\Http\Response
     */
    public function edit(AccBrandTransaction $accBrandTransaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AccBrandTransaction  $accBrandTransaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AccBrandTransaction $accBrandTransaction)
    {
        $this->validate($request,[
            'id' => 'required|integer|max:10000000',
            'transaction_amount' => 'required|numeric|max:1000000'
        ]);

        $data = $request->all();

        DB::beginTransaction();

        try
        {
            $newData = AccBrandTransaction::where('id','=',$data["id"])->first();
            
            if($data["transaction_type"] == "Pay")
            {
                $total = AccBrandTotal::where('brand_id','=',$newData["brand_id"])->first();
                
                $newTotalPaid = ($total["total_paid_amount"] - $newData["transaction_amount"]) + $data["transaction_amount"];
                $newTotalDue = ($total["total_due_amount"] - $newData["transaction_amount"]) + $data["transaction_amount"];
                $total->total_paid_amount = $newTotalPaid;
                $total->total_due_amount = $newTotalDue;
                $total->save();
            }
            else
            {
                $total = AccBrandTotal::where('brand_id','=',$newData["brand_id"])->first();
                $newTotalDue = ($total["total_due_amount"] + $newData["transaction_amount"]) - $data["transaction_amount"];

                $total->total_due_amount = $newTotalDue;
                $total->save();
            }
            $newData->transaction_amount = $data["transaction_amount"];
            $newData->update();
            DB::commit();
            Session::flash('flash_message',"Data Saved Successfully");
        }
        catch(\Exception $ex)
        {
            DB::rollback();

            Session::flash('error_message', $ex->getMessage());
        }

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AccBrandTransaction  $accBrandTransaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(AccBrandTransaction $accBrandTransaction)
    {
        //
    }
}
