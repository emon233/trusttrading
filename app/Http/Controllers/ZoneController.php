<?php

namespace App\Http\Controllers;

use Session;
use App\Zone;
use Illuminate\Http\Request;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $zones = Zone::all();
        
        return view('/setups/zones', compact('zones'));
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
            'zone_name' => 'required|string|max:50'
        ]);

        $data = $request->all();
        
        try
        {
            Zone::create($data);

            Session::flash('flash_message', 'Zone Created Successfully');
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
     * @param  \App\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function show(Zone $zone)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function edit(Zone $zone)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Zone $zone)
    {
        $this->validate($request,[
            'zone_name' => 'required|string|max:50'
        ]);
        $data = $request->all();
        
        try
        {
            $zone = Zone::findOrFail($data["id"]);
            $zone->update($data);

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
     * @param  \App\Zone  $zone
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            $zone = Zone::findOrFail($id);

            $zone->delete();

            Session::flash('flash_message','Record Deleted Successfully');
        }

        catch(\Exception $ex)
        {
            Session::flash('flash_error','!!!Something Went Wrong!!!');
        }

        return redirect()->back();
    }

    public static function get_zones_all()
    {
        $zones = Zone::all(['id','zone_name'])->sortBy('zone_name');

        return $zones;
    }
}
