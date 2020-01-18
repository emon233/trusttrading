<?php

namespace App\Http\Controllers;

use Session;
use App\DeliveryMan;
use Illuminate\Http\Request;

class DeliveryManController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $deliverymen = DeliveryMan::all();
        
        return view('/setups/deliverymen', compact('deliverymen'));
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
            'delivery_man_name' => 'required|string|max:50',
            'mobile' => 'string|max:15',
            'address' => 'string|max:200'
        ]);

        $data = $request->all();
        
        try
        {
            DeliveryMan::create($data);

            Session::flash('flash_message', 'Delivery Man Created Successfully');
        }
        catch(\Exception $ex)
        {
            Session::flash('error_message', $ex->getMessage());
        }
        
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\DeliveryMan  $deliveryMan
     * @return \Illuminate\Http\Response
     */
    public function show(DeliveryMan $deliveryMan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\DeliveryMan  $deliveryMan
     * @return \Illuminate\Http\Response
     */
    public function edit(DeliveryMan $deliveryMan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\DeliveryMan  $deliveryMan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, DeliveryMan $deliveryMan)
    {
        $this->validate($request,[
            'delivery_man_name' => 'required|string|max:50',
            'mobile' => 'string|max:15',
            'address' => 'string|max:200'
        ]);
        $data = $request->all();
        
        try
        {
            $deliveryman = DeliveryMan::findOrFail($data["id"]);
            $deliveryman->update($data);

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
     * @param  \App\DeliveryMan  $deliveryMan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            $deliveryman = DeliveryMan::findOrFail($id);

            $deliveryman->delete();

            Session::flash('flash_message','Record Deleted Successfully');
        }

        catch(\Exception $ex)
        {
            Session::flash('flash_error','!!!Something Went Wrong!!!');
        }

        return redirect()->back();
    }

    public static function get_deliverymen_all()
    {
        $delivery_men = DeliveryMan::all(['id','delivery_man_name'])->sortBy('delivery_man_name');

        return $delivery_men;
    }
}
