<?php
    use Illuminate\Support\Carbon;
?>

@extends('layouts.app')
@section('content')

<div class="container" id="add_div">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="panel panel-default" style="margin-top:30px;">
                <div class="panel-heading">
                    <label>DAILY MORNING OUT</label>
                </div>
                <div class="panel-body">
                    <div class="col-sm-6 col-md-offset-2">
                        <div class="panel  panel-default" style="margin-top:10px;">
                            <div class="panel-heading">
                                <label>Assign Products</label>
                            </div>

                            <div class="panel-body">
                                <table class="table-bordered table-condensed table-striped" style="width:100%">
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
                                        <input type="hidden" id="brand_id" value="{{$zone_deliveryman[0]->brand->id}}">
                                    </tr>
                                    <tr>
                                        <td>Date</td>
                                        <td><label>{{$zone_deliveryman[0]->created_at->toDateString()}}</label></td>
                                    </tr>
                                </table>
                            </div>

                            <div class="panel-body">
                                <form id="add_edit" name="add_edit">
                                    @csrf
                                    <table class="table-bordered table-condensed table-striped" style="width:100%">
                                        @include('dropdowns.productsbybrand')
                                        <tr>
                                            <td style="width:30%;">Inventory Amount</td>
                                            <td style="width:70%;">
                                                <input type="text" id="product_in_inventory" name="product_in_inventory" class="form-control" style="width:100%;" readonly/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="width:30%;">Outgoing Amount</td>
                                            <td style="width:70%;">
                                                <input type="text" id="product_out_amount" name="product_out_amount" class="form-control" style="width:100%;" required/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <input type="hidden" id="daily_zone_delivery_man_combo_id" name="daily_zone_delivery_man_combo_id" value="{{$id}}"/>
                                        </tr>
                                        <tr>
                                            <td style="width:30%;"></td>
                                            <td style="width:70%;">
                                                <input type="submit" id="outgoing_product" class="btn btn-primary" value="Submit" style="width:100%;"/>
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="panel-body">
                    <div class="col-lg-10 col-md-offset-1">
                        <div class="panel  panel-default" style="margin-top:10px;">
                            <div class="panel-heading">
                                <label>Previous Entries</label>
                            </div>
                            <div class="panel-body">
                                <table class="table-bordered table-condensed table-striped" style="width:100%">
                                    <thead>
                                        <th>Index</th>
                                        <th>Product Name</th>
                                        <th>Outgoing Amount</th>
                                        <th>Action</th>
                                    </thead>

                                    <tbody id="table_outproducts">
                                        @foreach($products as $key=>$value)
                                        <?php
                                            $today = Carbon::now();
                                        ?>
                                        <tr>
                                            <td>{{$key+1}}</td>
                                            <td>{{$value->product->product_name}}</td>
                                            <td>{{$value->product_out_amount}}</td>
                                            <td>
                                                <a href="#">Edit</a>
                                                <br>
                                                <a href="#">Delete</a>
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
    </div>
</div>

<script>
    $(document).ready(function(event){
        var brand_id = $('#brand_id').val();
        if (brand_id != "") {
            var brand_id = $('#brand_id').val();
            console.log(brand_id);
            $("#product_id").html("<option value=''>Loading...</option>");
            var url = "/productsbybrand";
            $.ajax({
                url:url,
                method:'get',
                data:{
                    brand_id:brand_id,
                },
                dataType:'json',
                success:function(data)
                {
                    var HTML = "";
                    HTML += "<option value=''>--Select Product--</option>";
                    for (var i in data) {
                        HTML += "<option value='" + data[i].id + "'>" + data[i].product_name + "</option>";
                    }
                    $("#product_id").html(HTML);
                },
                error:function(data)
                {
                    console.log(data);
                }
            });
            // $.get("/product/Getajax", {"brand_id": $(this).val()}, function (data) {
            //     console.log(data);
            //     var HTML = "";
            //     HTML += "<option value=''>--Select Product--</option>";
            //     for (var i in data) {
            //         HTML += "<option value='" + data[i].id + "'>" + data[i].product_name + "</option>";
            //     }
            //     $("#product_id").html(HTML);
            // });
        }
        else {
            $("#product_id").html("");
        }
    });
    $('#add_edit').on('submit', function(event){
        event.preventDefault();
        var form_data = $(this).serialize();
        var url = "/storeDailyOutData";

        $.ajax({
            url:url,
            method:'post',
            data:form_data,
            dataType:'json',
            success:function(data)
            {
                if(data == "Success")
                {
                    $('#table_outproducts').append(
                        '<tr>'+
                        '<td>#</td>'+
                        '<td>'+$("#product_id option:selected").text()+'</td>'+
                        '<td>'+$('#product_out_amount').val()+'</td>'+
                        '<td>'+
                            '<a href="#">Edit</a>'+
                            '<br>'+
                            '<a href="#">Delete</a>'+
                        '</td>'+
                        '</tr>'
                    );
                }
                else
                {
                    alert("Product Already Added");
                }
                
                $('#product_in_inventory').val("");
                $('#product_out_amount').val("");
            },
            error:function(data)
            {
                console.log(data);
            }
        });
    });

    $('#product_id').on('change', function(event){
        var product_id = $('#product_id').val();
        var url="/getInventoryStatusOfProduct";
        $('#product_in_inventory').val('--Loading--');
        $.ajax({
            url:url,
            method:'get',
            data:{
                product_id:product_id,
            },
            dataType:'json',
            success:function(data)
            {
                $('#product_in_inventory').val(data);
            },

            error:function(data)
            {
                console.log(data);
            }
        });
    });

    $('#product_out_amount').on('keyup', function(event){
        var out = parseInt($('#product_out_amount').val());
        var inventory = parseInt($('#product_in_inventory').val());

        if(out>inventory)
        {
            $('#product_out_amount').css('background','#f45642');
        }
        else
        {
            $('#product_out_amount').css('background','white');
        }
    });

</script>



@endsection