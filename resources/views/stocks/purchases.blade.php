@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="panel panel-default" style="margin-top:30px;">
                <div class="panel-heading" style="overflow:auto;">
                    <label>Purchase Product</label>
                </div>
                <div class="panel-body" style="text-align:center;">
                    <div class="table-responsive">
                        <form id="add_edit" method="get" action="/productsearchforpurchase">
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
                            <tr>
                                <td>Set Seller Percentage</td>
                                <td><input type="number" id="seller_percentage" class="form-control"/></td>
                            </tr>
                        </table>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed">
                            <thead>
                                <th>Index</th>
                                <th>Brand Name</th>
                                <th>Product Name</th>
                                <th>In Stock</th>
                                <th>Purchase Rate</th>
                                <th>Sell Rate</th>
                                <th>Purchase Amount</th>
                                <th>Unit Price</th>
                                <th>Percent</th>
                                <th>Updated At</th>
                                <th>Submit</th>
                                <th>Advance</th>
                            </thead>

                            <tbody>
                                @foreach($stocks as $key=>$value)
                                <?php
                                $mytime = Carbon\Carbon::now();
                                ?>
                                <form id="purchase" name="purchase[]" class="purchase" method="post" action="/purchases">
                                @csrf
                                @if($mytime->toDateString() == $value->stocks->updated_at->toDateString())
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$value->brand->brand_name}}</td>
                                    <td><b>{{$value->product_name}}</b></td>
                                    <td>{{$value->stocks->stock_amount}}</td>
                                    <td>{{$value->purchase_rate}}</td>
                                    <td>{{$value->sell_rate}}</td>
                                    <td><input type="text" id="amount" name="amount" class="form-control" disabled/></td>
                                    <td><input type="text" id="unit_price" name="unit_price" class="form-control" disabled/></td>
                                    <td><input type="text" id="percent" name="percent" class="form-control percent" readonly/></td>
                                    <td>Updated Today</td>
                                    <td><input type="submit" id="submit" name="submit" class="btn btn-primary" value="Submit" disabled/></td>
                                    <td><input type="button" class="btn btn-danger more" value="More"/>
                                    <br>
                                    <input type="button" data-id="{{$value->id}}" data-old_amount="{{$value->stocks->stock_amount}}" data-toggle="modal" data-target="#resetModal" class="btn btn-danger reset" value="Reset"/></td>
                                    <input type="hidden" id="product_id" name="product_id" value="{{$value->id}}" />
                                </tr>
                                @else
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$value->brand->brand_name}}</td>
                                    <td><b>{{$value->product_name}}</b></td>
                                    <td>{{$value->stocks->stock_amount}}</td>
                                    <td>{{$value->purchase_rate}}</td>
                                    <td>{{$value->sell_rate}}</td>
                                    <td><input type="text" id="amount" name="amount" class="form-control" value="{{ old('amount') }}" required/></td>
                                    <td><input type="text" id="unit_price" name="unit_price" class="form-control" value="{{ old('unit_prices') }}" required/></td>
                                    <td><input type="text" id="percent" name="percent" class="form-control percent"/></td>
                                    <td>{{$value->stocks->updated_at->toDateString()}}</td>
                                    <td><input type="submit" class="btn btn-primary" value="Submit"></td>
                                    <td><input type="button" class="btn btn-danger more" value="More" disabled/>
                                    <br><input type="button" data-id="{{$value->id}}" data-old_amount="{{$value->stocks->stock_amount}}" data-toggle="modal" data-target="#resetModal" class="btn btn-danger reset" value="Reset"/></td>
                                    <input type="hidden" id="product_id" name="product_id" value="{{$value->id}}" />
                                </tr>
                                @endif
                                </form>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="resetModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="resetModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4><label>Edit Product Stock</label></h4>
            </div>
            
            <div class="modal-body" align="center">
                <div class="table table-responsive">
                    <table class="table-condensed table-striped table-bordered">
                        <form id="form_product_reset" method="post" action="/resetProductInfo">
                            @csrf
                            <input type="hidden" id="entry_id" name="entry_id" />
                            <tr>
                                <td>Old Stock</td>
                                <td><input type="text" id="old_stock" name="old_stock" class="form-control" readonly/></td>
                            </tr>
                            <tr>
                                <td>New Stock</td>
                                <td><input type="text" id="new_stock" name="new_stock" class="form-control" /></td>
                            </tr>
                            <tr>
                                <td>New Purchase Rate</td>
                                <td><input type="text" id="new_purchase_rate" name="new_purchase_rate" class="form-control" /></td>
                            </tr>
                            <tr>
                                <td>Percent</td>
                                <td><input type="text" id="new_percent" name="new_percent" class="form-control" value="0.00" /></td>
                            </tr>
                            <tr>
                                <td>New Sell Rate</td>
                                <td><input type="text" id="new_sell_rate" name="new_sell_rate" class="form-control" readonly/></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="submit" class="form-control btn-primary" value="Update"/></td>
                            </tr>
                        </form>
                    </table>
                </div>
            </div>
            
            <div class="modal-footer">
            
            </div>
        </div>
    </div>
</div>

<script>
    $('.more').click(function(){
        $(this).closest('tr').find('#amount').prop('disabled', false);
        $(this).closest('tr').find('#unit_price').prop('disabled', false);
        //$(this).closest('tr').find('#percent').prop('disabled', false);
        $(this).closest('tr').find('#percent').prop('readonly', false);
        $(this).closest('tr').find('#submit').prop('disabled', false);
    });

    $('#seller_percentage').on('keyup', function(){
        $('.percent').val($('#seller_percentage').val());
    });
    
    $('.reset').click(function(){
        var id = $(this).data('id');
        var old_stock = $(this).data('old_amount');
        
        $('#entry_id').val(id);
        $('#old_stock').val(old_stock);
    });
    
    $('#new_purchase_rate').on('keyup', function(event){
        var new_rate = parseFloat($('#new_purchase_rate').val()); 
        var new_percent = parseFloat($('#new_percent').val());
        
        var new_sell_rate = new_rate + (new_rate * (new_percent/100));
        
        $('#new_sell_rate').val(new_sell_rate);
    });
    $('#new_percent').on('keyup', function(event){
        var new_rate = parseFloat($('#new_purchase_rate').val()); 
        var new_percent = parseFloat($('#new_percent').val());
        
        var new_sell_rate = new_rate + (new_rate * (new_percent/100));
        
        $('#new_sell_rate').val(new_sell_rate);
    });
</script>

@endsection
