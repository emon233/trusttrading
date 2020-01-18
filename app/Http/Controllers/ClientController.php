<?php

namespace App\Http\Controllers;

use App\Client;
use Illuminate\Http\Request;
use Session;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();
        
        return view('/setups/clients', compact('clients'));
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
            'client_name' => 'required|string|max:50',
            'mobile' => 'string|max:15',
            'address' => 'string|max:200'
        ]);

        $data = $request->all();
        
        try
        {
            Client::create($data);

            Session::flash('flash_message', 'Client Created Successfully');
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
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Client $client)
    {
        $this->validate($request,[
            'client_name' => 'required|string|max:50',
            'mobile' => 'string|max:15',
            'address' => 'string|max:200'
        ]);
        $data = $request->all();
        
        try
        {
            $client = Client::findOrFail($data["id"]);
            $client->update($data);

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
     * @param  \App\Client  $client
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            $client = Client::findOrFail($id);

            $client->delete();

            Session::flash('flash_message','Record Deleted Successfully');
        }

        catch(\Exception $ex)
        {
            Session::flash('flash_error','!!!Something Went Wrong!!!');
        }

        return redirect()->back();
    }

    public static function get_clients_all()
    {
        $clients = Client::all(['id','client_name'])->sortBy('client_name');

        return $clients;
    }
}
