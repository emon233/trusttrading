@extends('layouts.app')
@section('content')

<input type="hidden" id="comboId" value="{{$zone_deliveryman[0]->id}}">

<div class="container" id="add_div">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="panel panel-default" style="margin-top:30px;">
                <div class="panel-heading">
                    <label>DAILY EVENING</label>
                </div>

                <div class="panel-body">
                    <table class="table-bordered table-condensed table-striped" style="width:100%">
                        <tr>
                            <td>Date</td>
                            <td><label>{{$zone_deliveryman[0]->created_at->toDateString()}}</label></td>
                        </tr>
                        <tr>
                            <td>Zone</td>
                            <td><label>{{$zone_deliveryman[0]->zone->zone_name}}</label></td>
                        </tr>
                        <tr>
                            <td>Delivery Man</td>
                            <td><label>{{$zone_deliveryman[0]->delivery_man->delivery_man_name}}</label></td>
                        </tr>
                        <tr>
                            <td>Brand</td>
                            <td><label>{{$zone_deliveryman[0]->brand->brand_name}}</label></td>
                        </tr>
                    </table>
                </div>

                <div class="panel-body">
                    <table class="table-bordered table-condensed table-striped" style="width:100%">
                        <thead>
                            <th>Index</th>
                            <th>Product Name</th>
                            <th>Outgoing Amount</th>
                            <th>Return Amount</th>
                            <th>Net Unit Price</th>
                            <th>Sell Unit Price</th>
                            <th>Net Total</th>
                            <th>Sell Total</th>
                            <th>Action</th>
                            <th>Report</th>
                        </thead>

                        <tbody id="table_outproducts">
                            @foreach($products as $key=>$value)
                            <tr>
                                <form id="eveningout" name="eveningout" class="eveningout">
                                    @csrf
                                    <td>{{$key+1}}</td>
                                    <td>{{$value->product->product_name}}</td>
                                    <td><input type="text" id="product_out_amount" name="product_out_amount" class="form-control product_out_amount" value="{{$value->product_out_amount}}" readonly></td>
                                    @if($value->unit_price > 0)
                                    <td><input type="text" id="product_return_amount" name="product_return_amount" class="form-control product_return_amount" value="{{$value->product_return_amount}}" readonly/></td>
                                    <td><input type="text" id="net_unit_price" name="net_unit_price" class="form-control net_unit_price" value="{{$value->net_unit_price}}" readonly/></td>
                                    <td><input type="text" id="unit_price" name="unit_price" class="form-control unit_price" value="{{$value->unit_price}}" readonly/></td>
                                    <td><input type="text" id="net_total_price" name="net_total_price" class="form-control net_total_price" value="{{$value->net_total_price}}" readonly/></td>
                                    <td><input type="text" id="total_price" name="total_price" class="form-control total_price" value="{{$value->total_price}}" readonly/></td>
                                    <td>
                                        <input type="hidden" id="id" name="id" class="form-control id" value="{{$value->id}}"/>
                                        <input type="submit" class="btn btn-primary" value="Submit" disabled/>
                                    </td>
                                    <td>
                                        <input type="button" class="btn btn-danger editProduct" data-id="{{$value->id}}" data-toggle="modal" data-target="#editModal" value="Edit"/>
                                    </td>
                                    @else
                                    <td><input type="text" id="product_return_amount" name="product_return_amount" class="form-control product_return_amount" value="0"/></td>
                                    <td><input type="text" id="net_unit_price" name="net_unit_price" class="form-control net_unit_price" value="{{$value->product->sell_rate}}" readonly/></td>
                                    <td><input type="text" id="unit_price" name="unit_price" class="form-control unit_price"/></td>
                                    <td><input type="text" id="net_total_price" name="net_total_price" class="form-control net_total_price" readonly/></td>
                                    <td><input type="text" id="total_price" name="total_price" class="form-control total_price" readonly/></td> 
                                    <td>
                                        <input type="hidden" id="id" name="id" class="form-control id" value="{{$value->id}}"/>
                                        <input type="submit" id="btn_submit" class="btn btn-primary" value="Submit"/>
                                    </td>
                                    <td>
                                        <label id="label_report"></label>
                                    </td>
                                    @endif
                                    
                                </form>
                            </tr>
                            @endforeach
                        </tbody>
                    </table> 
                </div>
                
                <div class="container" id="add_div">
                    <div class="row justify-content-right">
                        <div class="col-md-8">
                            <div class="panel panel-default" style="margin-top:30px;">
                                <div class="panel-heading">
                                    <label>Damage Section</label>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-8">
                                        <form id="form_damage" name="form_damage">
                                            @csrf
                                            <table class="table-bordered table-condensed table-striped table_client" style="width:100%;">
                                                <tr>
                                                    <label id="label_msg_2"></label>
                                                </tr>
                                                <tr>
                                                    <td>Damage Amount</td>
                                                    <td>
                                                        <input type="text" id="total_damage" name="total_damage" class="form-control" value="{{$zone_deliveryman[0]->total_damage}}"/>
                                                    </td>
                                                </tr>
                                                <input type="hidden" id="id" name="id" value="{{$zone_deliveryman[0]->id}}">
                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        <input type="submit" id="submit_damage" class="btn btn-primary" style="width:100%;" value="Submit"/>
                                                    </td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="panel-body" align="right">
                    <div>
                        <label id="msg_label"></label>
                    </div>
                    <table class="table-bordered table-condensed table-striped" style="width:50%;">
                        <form id="eveningout_balance">
                            @csrf
                            <tr>
                                <td>Net Amount</td>
                                <td><input type="text" id="net_receivable" name="net_receivable" class="form-control" value="--Loading--" readonly/></td>
                            </tr>
                            <tr>
                                <td>Total Amount</td>
                                <td><input type="text" id="total_receivable" name="total_receivable" class="form-control" value="--Loading--" readonly/></td>
                            </tr>
                            <tr>
                                <td>Amount Received</td>
                                <td><input type="text" id="total_received" name="total_received" class="form-control" value="{{$zone_deliveryman[0]->total_received}}"/></td>
                            </tr>
                            <tr>
                                <td>Due Amount</td>
                                <td><input type="text" id="total_due" name="total_due" class="form-control" value="--Loading--" readonly/></td>
                            </tr>
                            <tr>
                                <td>Company Claim</td>
                                <td><input type="text" id="total_company_claim" name="total_company_claim" class="form-control" value="{{$zone_deliveryman[0]->total_company_claim}}"/></td>
                            </tr>
                            <tr>
                                <td>Amount Claimable</td>
                                <td><input type="text" id="total_claimable" name="total_claimable" class="form-control" value="--Loading--" readonly/></td>
                            </tr>
                            <tr>
                                <td><input type="hidden" id="id" name="id" value="{{$zone_deliveryman[0]->id}}"></td>
                                <td><input type="submit" id="form_account" class="btn btn-primary" style="width:100%;" value="Submit"/></td>
                            </tr>
                            
                        </form>
                    </table>
                </div>

                <div class="container" id="add_div">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="panel panel-default" style="margin-top:30px;">
                                <div class="panel-heading">
                                    <label>Transaction Section</label>
                                </div>
                                <div class="panel-body">
                                    <div class="col-md-12">
                                        <form id="form_due" name="form_due">
                                            @csrf
                                            <table id="table_client" class="table-bordered table-condensed table-striped table_client" style="width:100%;">
                                                <tr>
                                                    <td>Transaction Type</td>
                                                    <td>
                                                        <select id="transaction_type" name="transaction_type" class="form-control">
                                                            <option>Due</option>
                                                            <option>Paid</option>
                                                        </select>
                                                    </td>
                                                </tr>
                                                @include('dropdowns.clients')
                                                <tr>
                                                    <td>Due Amount</td>
                                                    <td><input type="text" id="transaction_amount" name="transaction_amount" class="form-control"/></td>
                                                </tr>
                                                <input type="hidden" id="brand_name" name="brand_name" class="form-control" value="{{$zone_deliveryman[0]->brand->brand_name}}"/>
                                                <input type="hidden" id="daily_zone_deliveryman_id" name="daily_zone_deliveryman_id" class="form-control" value="{{$zone_deliveryman[0]->id}}"/>
                                                <tr>
                                                    <td></td>
                                                    <td><input type="submit" id="form_due_submit" name="form_due_submit" class="form-control btn btn-primary" value="Submit"/></td>
                                                </tr>
                                            </table>
                                        </form>
                                    </div>
                                </div>
                                <div class="panel-body">
                                    <table class="table-bordered table-condensed table-striped" style="width:100%;">
                                        <thead>
                                            <th>#</th>
                                            <th>Client</th>
                                            <th>Brand</th>
                                            <th>Transaction Type</th>
                                            <th>Transaction Amount</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody id="table_due_entry">
                                            @foreach($due_transactions as $key=>$value)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$value->client->client_name}}</td>
                                                <td>{{$zone_deliveryman[0]->brand->brand_name}}</td>
                                                <td>{{$value->transaction_type}}</td>
                                                <td>{{$value->transaction_amount}}</td>
                                                <td>
                                                    <a href="#" style="color:green;">Edit</a>
                                                    <br>
                                                    <a href="#" style="color:red;">Delete</a>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="panel-body">
                                    <table class="table-bordered table-condensed table-striped" style="width:100%;">
                                        <tr>
                                            <th style="width:50%;">Due Today</th>
                                            <td id="due-today" style="width:50%;">--Loading--</td>
                                        </tr>
                                        <tr>
                                            <th>Due Collection Today</th>
                                            <td id="due-collection-today">--Loading--</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div id="editModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4><label>Edit Sell Info</label></h4>
            </div>
            
            <div class="modal-body" align="center">
                <div class="table table-responsive">
                    <table class="table-condensed table-striped table-bordered">
                        <form id="form_product_edit" method="post" action="/updateProductSellInfo">
                            @csrf
                            <input type="hidden" id="entry_id" name="entry_id" />
                            <tr>
                                <td>Product Out Amount</td>
                                <td><input type="text" id="out" name="out" class="form-control" readonly/></td>
                            </tr>
                            <tr>
                                <td>Product Return Amount</td>
                                <td><input type="text" id="return" name="return" class="form-control" /></td>
                            </tr>
                            <tr>
                                <td>Net Unit Price</td>
                                <td><input type="text" id="net_price" name="net_price" class="form-control" /></td>
                            </tr>
                            <tr>
                                <td>Sell Unit Price</td>
                                <td><input type="text" id="sell_price" name="sell_price" class="form-control" /></td>
                            </tr>
                            <tr>
                                <td>Total Sell Price</td>
                                <td><input type="text" id="total_sell" name="total_sell" class="form-control" readonly/></td>
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

    setTimeout(function(){
        
        calculations();
        transactions();

    }, 5000);

    $('.editProduct').on('click', function(event){
        var id = $(this).data('id');
        var url = "/editDailySellProductInfo";
        $.ajax({
            url:url,
            method:'get',
            data:{id},
            dataType:'json',
            success:function(data)
            {
                $('#entry_id').val(data.id);
                $('#out').val(data.product_out_amount);
                $('#return').val(data.product_return_amount);
                $('#net_price').val(data.net_unit_price);
                $('#sell_price').val(data.unit_price);
                $('#total_sell').val(data.total_price);
            },
            error:function(data)
            {
                console.log(data);
            }
        });
    });

    $('#form_damage').on('submit', function(event){
        event.preventDefault();
        var form_data = $(this).serialize();
        var url = "/storeDailyDamageData";

        $.ajax({
            url:url,
            method:'post',
            data:form_data,
            dataType:'json',
            success:function(data)
            {
                if(data == "Success")
                {
                    $('#label_msg_2').append('<span style="color:green;">Saved</span>');
                    $('#total_damage').prop("readonly", true);
                    calculations();
                }
                else
                {
                    $('#label_msg_2').append('<span style="color:red;">Something Went Wrong</span>');
                    calculations();
                    console.log(data);
                }
            },
            error:function(data)
            {
                console.log(data);
            }
        });
    });

    $('#form_due').on('submit', function(event){
        event.preventDefault();
        var form_data = $(this).serialize();
        var url = "/storeClientPaymentData";
        
        $.ajax({
            url:url,
            method:"post",
            data:form_data,
            dataType:'json',
            success:function(data)
            {
                transactions();
                if(data=="Success")
                {
                    $('#table_due_entry').append(
                        '<tr>'+
                        '<td>#</td>'+
                        '<td>'+$("#client_id option:selected").text()+'</td>'+
                        '<td>'+$('#brand_name').val()+'</td>'+
                        '<td>'+$('#transaction_type option:selected').text()+'</td>'+
                        '<td>'+$('#transaction_amount').val()+'</td>'+
                        '<td>'+
                            '<a href="#" style="color:green;">Edit</a>'+
                            '<br>'+
                            '<a href="#" style="color:red;">Delete</a>'+
                        '</td>'+
                        '</tr>'
                    );

                    $('#transaction_amount').val("");
                }
                else
                {
                    console.log(data);
                }
            },
            error:function(data)
            {
                console.log(data);
            }
        });
    });

    $('.eveningout').on('submit', function(event){
        event.preventDefault();
        var form_data = $(this).serialize();
        var success_msg = $(this).closest('tr').find('#label_report');
        success_msg.append('<span style="color:green;">Loading</span>');
        var product_return_amount = $(this).closest('tr').find('#product_return_amount');
        var total_price = $(this).closest('tr').find('#total_price');
        var unit_price = $(this).closest('tr').find('#unit_price');
        var net_total_price = $(this).closest('tr').find('#net_total_price');
        var submit = $(this).closest('tr').find('#btn_submit');
        submit.prop('disabled', true);
        var url = "/updateDailyOutData";

        $.ajax({
            url:url,
            method:'post',
            data:form_data,
            dataType:'json',
            success:function(data)
            {
                success_msg.empty();
                if(data == "Success")
                {
                    success_msg.append('<span style="color:green">Success</span>');
                    product_return_amount.prop('disabled', true);
                    unit_price.prop('disabled', true);
                    total_price.prop('disabled', true);

                    submit.prop('disabled', true);

                    calculations();
                }
                else
                {
                    success_msg.append('<span style="color:red">Error</span>');
                    console.log(data);
                }
            },
            error:function(data)
            {
                console.log(data);
            }
        });
    });

    $('#eveningout_balance').on('submit', function(event){
        event.preventDefault();
        $('#msg_label').empty();
        $('#msg_label').append('--Loading--');
        var form_data = $(this).serialize();
        var url = "/updateDailyZoneDeliverymanCombo";

        $.ajax({
            url:url,
            method:"post",
            data:form_data,
            dataType:'json',
            success:function(data)
            {
                if(data == "Success")
                {
                    $('#msg_label').empty();
                    $('#msg_label').append('<span style="color:green;">Saved</span>');
                    $('#total_received').prop('disabled',true);
                    $('#total_company_claim').prop('disabled',true);
                    $('#form_account').prop('disabled', true);
                    calculations();
                }
                else
                {
                    $('#msg_label').empty();
                    $('#msg_label').append('<span style="color:red;">Something Went Wrong</span>');
                }
            },
            error:function(data)
            {
                console.log(data);
                $('#msg_label').empty();
                $('#msg_label').append('<span style="color:red;">Something Went Wrong</span>');
            }
        });

    });

    $('.unit_price').on('keyup', function(event){
        var unit_price = $(this).val();
        
        var net_unit_price = $(this).closest('tr').find('#net_unit_price');
        var product_out_amount = $(this).closest('tr').find('#product_out_amount');
        var product_return_amount = $(this).closest('tr').find('#product_return_amount');
        var total_price = $(this).closest('tr').find('#total_price');
        var net_total_price = $(this).closest('tr').find('#net_total_price');

        var sub_total = (product_out_amount.val()-product_return_amount.val())*unit_price;
        total_price.prop('value',sub_total);

        var net_sub_total = (product_out_amount.val()-product_return_amount.val())*net_unit_price.val();
        net_total_price.prop('value', net_sub_total);
    });

    $('.product_return_amount').on('keyup', function(event){
        var product_return_amount = $(this).val();
        var product_out_amount = $(this).closest('tr').find('#product_out_amount');
        var unit_price = $(this).closest('tr').find('#unit_price');
        var total_price = $(this).closest('tr').find('#total_price');

        var net_unit_price = $(this).closest('tr').find('#net_unit_price');
        var net_total_price = $(this).closest('tr').find('#net_total_price');

        var sub_total = (product_out_amount.val()-product_return_amount)*unit_price.val();
        total_price.prop('value',sub_total);

        var net_sub_total = (product_out_amount.val()-product_return_amount)*net_unit_price.val();
        net_total_price.prop('value', net_sub_total);
    });

    $('#total_received').on('keyup', function(event){
        var total_receivable = parseFloat($('#total_receivable').val());
        var total_received = parseFloat($('#total_received').val());
        var total_company_claim = parseFloat($('#total_company_claim').val());
        var total_damage = parseFloat($('#total_damage').val());
        var total_due = total_receivable - (total_received + total_company_claim + total_damage);
        
        $('#total_due').val(total_due);
    });
    
    $('#total_damage').on('keyup', function(event){
        var total_receivable = parseFloat($('#total_receivable').val());
        var total_received = parseFloat($('#total_received').val());
        var total_company_claim = parseFloat($('#total_company_claim').val());
        var total_damage = parseFloat($('#total_damage').val());
        var total_due = total_receivable - (total_received + total_company_claim + total_damage);
        
        $('#total_due').val(total_due);
    });

    $('#total_company_claim').on('keyup', function(event){
        var total_receivable = parseFloat($('#total_receivable').val());
        var total_received = parseFloat($('#total_received').val());
        var total_company_claim = parseFloat($('#total_company_claim').val());
        var total_damage = parseFloat($('#total_damage').val());
        var total_due = total_receivable - (total_received + total_company_claim + total_damage);

        if(isNaN(total_due))
        {
            $('#total_due').val("0.00");
        }
        else
        {
            $('#total_due').val(total_due);
        }
    });

    $('#return').on('keyup', function(event){
        var out = $('#out').val();
        var back = $('#return').val();
        var unit_price = parseFloat($('#sell_price').val());

        var total = (out - back) * unit_price;

        $('#total_sell').val(total);
    });
    
    $('#sell_price').on('keyup', function(event){
        var out = $('#out').val();
        var back = $('#return').val();
        var unit_price = parseFloat($('#sell_price').val());

        var total = (out - back) * unit_price;

        $('#total_sell').val(total);
    });

</script>



@endsection