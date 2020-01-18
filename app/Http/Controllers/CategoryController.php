<?php

namespace App\Http\Controllers;

use Session;
use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();

        return view('/setups/categories', compact('categories'));
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
            'category_name' => 'required|string|max:50'
        ]);
        $data = $request->all();

        try
        {
            Category::create($data);

            Session::flash('flash_message', 'Brand Created Successfully');
        }
        catch(\Exception $ex)
        {
            Session::flash('error_message', 'Something Went Wrong');
        }
        
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'category_name' => 'required|string|max:50',
        ]);
        $data = $request->all();
        
        try
        {
            $category = Category::findOrFail($data["id"]);
            $category->update($data);

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
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try
        {
            $category = Category::findOrFail($id);

            $category->delete();

            Session::flash('flash_message','Record Deleted Successfully');
        }

        catch(\Exception $ex)
        {
            Session::flash('flash_error','!!!Something Went Wrong!!!');
        }

        return redirect()->back();
    }

    public static function get_categories_all()
    {
        $categories = Category::all(['id','category_name'])->sortBy('category_name');

        return $categories;
    }
}
