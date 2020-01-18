@extends('layouts.app')
@section('content')

<input type="hidden" id="comboId" value="{{$sheet_details[0]->id}}">

<div class="container" id="add_div">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="panel panel-default" style="margin-top:30px;">
                <div class="panel-heading">
                    <label>Daily Sheet Details</label>
                </div>
                <div id="printarea" class="panel-body" align="center">
                    <h3>Sheet Details</h3>
                    <table class="table-bordered table-condensed table-striped" style="width:50%; text-align:center;">
                        <tr>
                            <td><label>Date</label></td>
                            <td><label>{{$sheet_details[0]->created_at->toDateString()}}</label></td>
                        </tr>
                        <tr>
                            <td><label>Brand</label></td>
                            <td><label>{{$sheet_details[0]->brand->brand_name}}</label></td>
                        </tr>
                        <tr>
                            <td><label>Zone</label></td>
                            <td><label>{{$sheet_details[0]->zone->zone_name}}</label></td>
                        </tr>
                        <tr>
                            <td><label>Deliveryman</label></td>
                            <td><label>{{$sheet_details[0]->delivery_man->delivery_man_name}}</label></td>
                        </tr>
                    </table>
                    <h3>Product Details</h3>
                    <table class="table-bordered table-condensed table-striped" style="width:100%;">
                        <thead>
                            <th>Index</th>
                            <th>Product</th>
                            <th>Out</th>
                            <th>Return</th>
                            <th>Net Unit Price</th>
                            <th>Net Total Price</th>
                            <th>Unit Price</th>
                            <th>Total Price</th>
                        </thead>
                        <tbody>
                            @foreach($product_details as $key=>$value)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$value->product->product_name}}</td>
                                <td>{{$value->product_out_amount}}</td>
                                <td>{{$value->product_return_amount}}</td>
                                <td>{{$value->net_unit_price}}</td>
                                <td>{{$value->net_total_price}}</td>
                                <td>{{$value->unit_price}}</td>
                                <td>{{$value->total_price}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <h3>Transaction Details</h3>
                    <table class="table-bordered table-condensed table-striped" style="width:50%;">
                        <tr>
                            <td>Net Receivable</td>
                            <td id="net_receivable"></td>
                        </tr>
                        <tr>
                            <td>Total Receivable</td>
                            <td id="total_receivable"></td>
                        </tr>
                        <tr>
                            <td>Total Received</td>
                            <td>{{$sheet_details[0]->total_received}}</td>
                        </tr>
                        <tr>
                            <td>Total Due</td>
                            <td id="total_due"></td>
                        </tr>
                        <tr>
                            <td>Total Damage</td>
                            <td>{{$sheet_details[0]->total_damage}}</td>
                        </tr>
                        <tr>
                            <td>Total Claimable</td>
                            <td id="total_claimable"></td>
                        </tr>
                    </table>
                    <h3>Client Transaction Details</h3>
                    <table class="table-bordered table-condensed table-striped" style="width:70%;">
                        <thead>
                            <th>Index</th>
                            <th>Client</th>
                            <th>Transaction Type</th>
                            <th>Transaction Amount</th>
                        </thead>
                        <tbody>
                            @foreach($dues as $key=>$value)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$value->client->client_name}}</td>
                                <td>{{$value->transaction_type}}</td>
                                <td>{{$value->transaction_amount}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <input type="button" class="form-control btn btn-primary" onclick="printDiv('printarea')" value="Print" />
            </div>
        </div>
    </div>
</div>

<script>
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }

    setTimeout(function(){
        
        calculations();

    }, 5000);

</script>

@endsection