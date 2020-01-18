@extends('layouts.app')
@section('content')

<div class="container" id="add_div" hidden>
    <div class="row justify-content-center">
        <div class="col-sm-6 col-md-offset-2">
            <div class="panel  panel-default" style="margin-top:30px;">
                <div class="panel-heading">
                    <label>UPDATE PURCHASE INFO: <span style="color:blue;">{{$histories[0]->product->product_name}}<span></label>
                    <button type="button" id="add_new" name="add_new" class="btn btn-danger" style="float:right;">
                        ADD NEW
                    </button>
                </div>
                <div class="panel-body">
                    <form id="add_edit" method="post" action="/purchases/update">
                        @csrf
                        <table class="table-bordered table-condensed table-striped" style="width:100%">
                            <tr>
                                <td style="width:30%;">Purchase Date</td>
                                <td style="width:70%;">
                                    <input type="text" id="purchase_date" name="purchase_date" class="form-control" style="width:100%;" disabled/>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:30%;">Purchased Unit</td>
                                <td style="width:70%;">
                                    <input type="text" id="amount" name="amount" class="form-control" style="width:100%;"/>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:30%;">Unit Price</td>
                                <td style="width:70%;">
                                    <input type="text" id="unit_price" name="unit_price" class="form-control" style="width:100%;"/>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:30%;">Total Price</td>
                                <td style="width:70%;">
                                    <input type="text" id="total_price" name="total_price" class="form-control" style="width:100%;" readonly/>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="hidden" id="id" name="id" /></td>
                            </tr>
                            <tr>
                                <td style="width:30%;"></td>
                                <td style="width:70%;">
                                    <input type="submit" class="btn btn-primary" value="Submit" style="width:100%;"/>
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="panel  panel-default" style="margin-top:30px;">
                <div class="panel-heading" style="overflow:auto;">
                    <label>Purchase History: <span style="color:blue;">{{$histories[0]->product->product_name}}<span></label>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed">
                            <thead>
                                <th>Index</th>
                                <th>Amount Purchased</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
                                <th>Purchased At</th>
                                <th>Last Updated</th>
                                <th>Actions</th>
                            </thead>
                            <tbody>
                                @foreach($histories as $key=>$value)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$value->amount}}</td>
                                    <td>{{$value->unit_price}}</td>
                                    <td>{{$value->total_price}}</td>
                                    <td>{{$value->created_at->toDateString()}}</td>
                                    <td>
                                        @if($value->created_at != $value->updated_at)
                                        {{$value->updated_at}}
                                        @endif
                                    </td>
                                    <td>
                                        <a href="#" class="edit" data-id="{{$value->id}}"
                                            data-date="{{$value->created_at->toDateString()}}"
                                            data-amount="{{$value->amount}}"
                                            data-unit_price="{{$value->unit_price}}"
                                            data-total_price="{{$value->total_price}}">Edit</a>
                                        <a href="#" style="color:red;">Delete</a>
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



<script>
    $('.edit').click(function(){
        var id = $(this).data("id");
        var date = $(this).data("date");
        var amount = $(this).data("amount");
        var unit_price = $(this).data("unit_price");
        var total_price = $(this).data("total_price");

        $('#id').val(id);
        $('#purchase_date').val(date);
        $('#amount').val(amount);
        $('#unit_price').val(unit_price);
        $('#total_price').val(total_price);
    });

    $('#amount').keyup(function(){
        calculate_total_price();
    });

    $('#unit_price').keyup(function(){
        calculate_total_price();
    });

    function calculate_total_price()
    {
        var unit = $('#amount').val();
        var unit_price = $('#unit_price').val();
        $('#total_price').val(unit*unit_price);
    }
</script>

@endsection

