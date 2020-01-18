 @extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="panel panel-default" style="margin-top:30px;">
                <div class="panel-heading" style="overflow:auto;">
                    <label>Reports</label>
                </div>
                <div id="printarea" class="panel-body" align="center">
                    <h3>Brand: <span><i>{{$products[0]->brand->brand_name}}</i></span></h3>
                    <h4>Date: <span>{{Carbon\Carbon::today()->toDateString()}}</span></h4>
                    <h4>Inventory Status</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-condensed">
                            <thead>
                                <th>Index</th>
                                <th>Product</th>
                                <th>Inventory</th>
                                <th>Unit Price</th>
                                <th>Total Price</th>
                            </thead>
                            <tbody>
                                <?php
                                    $inventory = 0;
                                ?>
                                @foreach($products as $key=>$value)
                                    <?php
                                        $inventory = $inventory + $value->stocks->stock_amount * $value->purchase_rate;
                                    ?>
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$value->product_name}}</td>
                                        <td>{{$value->stocks->stock_amount}}</td>
                                        <td>{{$value->purchase_rate}}</td>
                                        <td>{{$value->stocks->stock_amount * $value->purchase_rate}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <h4>Accounts</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-condensed" style="width:45%;">

                            <input type="hidden" id="total_cash" class="form-control" value="{{$totals[0]->total_cash_amount}}"/>
                            <input type="hidden" id="total_paid" class="form-control" value="{{$totals[0]->total_paid_amount}}"/>
                            
                            <tr>
                                <td>Total Market Due</td>
                                <td><input type="text" id="total_market_due" class="form-control" value="{{$totals[0]->total_market_due_amount}}" readonly/></td>
                            </tr>
                            <tr>
                                <td>Total Damage</td>
                                <td><input type="text" id="total_damage" class="form-control" value="{{$totals[0]->total_damage_amount}}" readonly/></td>
                            </tr>
                            <tr>
                                <td>Product In Inventory</td>
                                <td><input type="text" id="inventory_total" class="form-control" value="{{$inventory}}" readonly/></td>
                            </tr>
                            <tr>
                                <td>Balance</td>
                                <td><input type="text" id="account_balance" class="form-control" value="0.00" readonly></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <input type="button" class="btn btn-primary" onclick="printDiv('printarea')" value="Print"/>
            </div>
        </div>
    </div>
</div>

<script>
    
  
    function printDiv(divName) {
        var mywindow = window.open('', 'PRINT', 'height=400,width=600');

        mywindow.document.write('<html><head><title> Details </title>');
        mywindow.document.write('</head><body >');
        mywindow.document.write('<h1>Inventory Status</h1>');
        mywindow.document.write(document.getElementById(elem).innerHTML);
        mywindow.document.write('</body></html>');

        mywindow.document.close();
        mywindow.focus(); 

        mywindow.print();
        mywindow.close();

        return true;
    }

    $('.unit_price').on('keyup', function(event){
        var unit = $(this).closest('tr').find('#unit');
        var unit_price = $(this).closest('tr').find('#unit_price');
        var total_price = $(this).closest('tr').find('#total_price');

        var cal_unit = parseFloat(unit.val());
        var cal_unit_price = parseFloat(unit_price.val());

        total_price.val(cal_unit * cal_unit_price);
    });

    $('.unit_price').on('change', function(event){
        var unit = $(this).closest('tr').find('#unit');
        var unit_price = $(this).closest('tr').find('#unit_price');
        var total_price = $(this).closest('tr').find('#total_price');
        
        var cal_total_price = parseFloat(total_price.val());
        var inventory_total = parseFloat($('#inventory_total').val());
        
        var invest = parseFloat(0.00);
        var paid = parseFloat($('#total_paid').val());
        var cash = parseFloat($('#total_cash').val());
        var market_due = parseFloat($('#total_market_due').val());
        var damage = parseFloat($('#total_damage').val());
        var inventory = inventory_total + cal_total_price;
        
        unit_price.prop('value', unit_price.val());
        unit_price.prop('readonly', true);

        $('#inventory_total').val(inventory);
        var account_balance = (cash+market_due+damage+due+inventory) - paid;
        $('#account_balance').val(account_balance);

    });

</script>

@endsection