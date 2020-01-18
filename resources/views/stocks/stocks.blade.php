@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="panel panel-default" style="margin-top:30px;">
                <div class="panel-heading" style="overflow:auto;">
                    <label>Products in Stock</label>
                </div>
                <div class="panel-body" style="text-align:center;">
                    <div class="table-responsive">
                        <form id="add_edit" method="get" action="/productsearchforstock">
                            <table class="table-bordered table-condensed table-striped" style="width:50%;">
                                @include('dropdowns.brands')
                                @include('dropdowns.categories')
                                <tr>
                                    <td></td>
                                    <td><input type="submit" class="btn btn-primary" value="Search" style="width:100%;"></td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed">
                            <thead>
                                <th>Index</th>
                                <th>Brand Name</th>
                                <th>Category Name</th>
                                <th>Product Name</th>
                                <th>In Stock</th>
                                <th>Updated At</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach($stocks as $key=>$value)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$value->brand->brand_name}}</td>
                                    <td>{{$value->category->category_name}}</td>
                                    <td>{{$value->product_name}}</td>
                                    <td>{{$value->stocks->stock_amount}}</td>
                                    <td>{{$value->stocks->updated_at}}</td>
                                    <td>
                                        <a href="/purchasehistory/{{$value->id}}" style="color:green;"
                                        data-id="{{$value->id}}">History</a>
                                        <a href="/purchases/{{$value->brand->id}}" style="color:red;">Purchase</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

