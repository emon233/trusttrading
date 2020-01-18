<?php

namespace App\Http\Controllers;

use DB;
use Session;
use App\Brand;
use App\AccBrandTotal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::all();
        
        return view('/setups/brands', compact('brands'));
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
            'brand_name' => 'required|string|max:50',
            'brand_contact_detail' => 'required|string|max:199',
            'brand_mobile_no_1' => 'max:20',
            'brand_mobile_no_2' => 'max:20',
            'brand_mobile_no_3' => 'max:20',
            'brand_account_no' => 'max:50'
        ]);

        $data = $request->all();
        
        DB::beginTransaction();
        try
        {
            $brand = Brand::create($data);

            $acc_data["brand_id"] = $brand->id;

            AccBrandTotal::create($acc_data);

            DB::commit();
            Session::flash('flash_message', 'Brand Created Successfully');
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
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'brand_name' => 'required|string|max:50',
            'brand_contact_detail' => 'required|string|max:199',
            'brand_mobile_no_1' => 'max:20',
            'brand_mobile_no_2' => 'max:20',
            'brand_mobile_no_3' => 'max:20',
            'brand_account_no' => 'max:50'
        ]);
        $data = $request->all();
        
        try
        {
            $brand = Brand::findOrFail($data["id"]);
            $brand->update($data);

            Session::flash('flash_message','Data Updated Successfully');
        }
        catch(\Exception $ex)
        {
            Session::flash('error_message','Something Went Wrong');
        }
        

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            $brand = Brand::findOrFail($id);

            $brand->delete();

            Session::flash('flash_message','Record Deleted Successfully');
        }

        catch(\Exception $ex)
        {
            Session::flash('flash_error','!!!Something Went Wrong!!!');
        }

        return redirect()->back();
    }

    public static function get_brands_all()
    {
        $brands = Brand::all(['id','brand_name'])->sortBy('brand_name');

        return $brands;
    }
}
