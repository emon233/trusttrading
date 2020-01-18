<?php

namespace App\Http\Controllers;

use Session;
use DB;
use App\Product;
use App\Category;
use App\Stock;
use Illuminate\Http\Request;

class ProductController extends Controller
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
            $products = Product::with(['brand','category'])->get();
        }
        else
        {
            $products = Product::where('brand_id',$id)->with(['brand','category'])->get();
        }
        

        return view('/setups/products', compact('products'));
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
            'brand_id' => 'required|integer',
            'category_id' => 'required|integer',
            'product_name' => 'required|string|max:50',
        ]);

        $data = $request->all();
        
        DB::beginTransaction();

        try
        {
            $product = Product::create($data);
            $stock_data["product_id"] = $product->id;
            $stock_data["stock_amount"] = 0;
            DB::commit();
            Stock::create($stock_data);
            Session::flash('flash_message', 'Product Created Successfully');
        }
        catch(\Exception $ex)
        {
            DB::rollback();
            Session::flash('error_message', "Something Went Wrong");
        }
        
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        $this->validate($request,[
            'brand_id' => 'required|integer',
            'category_id' => 'required|integer',
            'product_name' => 'required|string|max:50',
        ]);

        $data = $request->all();
        
        try
        {
            $product = Product::findOrFail($data["id"]);
            $product->update($data);

            Session::flash('flash_message', 'Product Updated Successfully');
        }
        catch(\Exception $ex)
        {
            Session::flash('error_message', "Something Went Wrong");
        }
        
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try
        {
            $product = Product::findOrFail($id);

            $product->delete();

            Session::flash('flash_message','Record Deleted Successfully');
        }

        catch(\Exception $ex)
        {
            Session::flash('flash_error','!!!Something Went Wrong!!!');
        }

        return redirect()->back();
    }

    public static function get_products_all()
    {
        $products = Product::all(['id', 'product_name'])->sortBy('product_name');

        return $products;
    }

    public function get_products_by_brand(Request $request)
    {
        $brand_id = $request->input('brand_id');
        $products = Product::where('brand_id',$brand_id)->get();

        return response()->json($products);
    }

    public function product_search(Request $request)
    {
        $brand_id = $request->get('brand_id');
        $category_id = $request->get('category_id');
        $products = "";
        if($brand_id != 0  && $category_id != 0)
        {
            $products = Product::with(['products','brand','category'])->where([['brand_id','=',$brand_id],['category_id','=',$category_id]])->get();
        }
        elseif($brand_id != 0)
        {
            $products = Product::with(['products','brand','category'])->where('brand_id','=',$brand_id)->get();
        }
        elseif($category_id != 0)
        {
            $products = Product::with(['products','brand','category'])->where('category_id','=',$category_id)->get();
        }
        else
        {
            $products = Product::with(['products','brand','category'])->get();
        }
        
        return view('/setups/products', compact('products'));
    }

    public function get_inventory_status_by_product_id(Request $request)
    {
        $stock = Product::find($request->get('product_id'))->stocks;

        return response()->json($stock->stock_amount);
    }
}
