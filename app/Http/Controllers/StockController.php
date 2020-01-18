<?php

namespace App\Http\Controllers;

use Session;
use App\Product;
use App\Stock;
use Illuminate\Http\Request;

class StockController extends Controller
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
            $stocks = Product::with(['stocks','brand','category'])->get();
        }
        else
        {
            $stocks = Product::where('brand_id',$id)->with(['stocks','brand','category'])->get();
        }
        
    
        return view('/stocks/stocks', compact('stocks'));
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
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function show(Stock $stock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function edit(Stock $stock)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Stock $stock)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Stock  $stock
     * @return \Illuminate\Http\Response
     */
    public function destroy(Stock $stock)
    {
        //
    }

    public function product_search(Request $request)
    {
        $brand_id = $request->get('brand_id');
        $category_id = $request->get('category_id');

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


        return view('/stocks/stocks', compact('stocks'));
    }
}
