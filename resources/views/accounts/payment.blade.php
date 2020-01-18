@extends('layouts.app')
@section('content')

<div class="container" id="add_div" hidden>
    <div class="row justify-content-center">
        <div class="col-sm-6 col-md-offset-2">
            <div class="panel panel-default" style="margin-top:30px;">
                <div class="panel-heading">
                    <label id="label_header"></label>
                </div>

                <div class="panel-body">
                    <form id="add_edit" name="add_edit" method="post" action="/accounts">
                        @csrf
                        <table class="table-bordered table-condensed table-striped" style="width:100%">
                            <tr>
                                <td style="width:30%;">Brand Name</td>
                                <td style="width:70%;"><input id="brand_name" class="form-control" readonly/></td>
                                <input type="hidden" id="brand_id" name="brand_id" required/>
                            </tr>
                            <tr>
                                <td style="width:30%;"><label id="label_transaction_text"></label></td>
                                <td style="width:70%;"><input type="number" id="transaction_amount" name="transaction_amount" class="form-control" required/></td>
                                <input type="hidden" id="transaction_type" name="transaction_type" />
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
            <div class="panel panel-default" style="margin-top:30px;">
                <div class="panel-heading" style="overflow:auto;">
                    <label>Make Payment</label>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-condensed">
                            <thead>
                                <th>Index</th>
                                <th>Brand Name</th>
                                <th>Total Market Due</th>
                                <th>Total Damage</th>
                                <th>Total Claim</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach($brands as $key=>$value)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$value->brand->brand_name}}</td>
                                    <td>{{$value->total_market_due_amount}}</td>
                                    <td>{{$value->total_damage_amount}}</td>
                                    <td>{{$value->total_claim_amount}}</td>
                                    <td>
                                        <a href="/paymenthistory/{{$value->brand_id}}" style="color:green;"><i class="fas fa-history"></i> Payment History</a>
                                        <br>
                                        <a href="#" style="color:red;" class="make_payment"
                                        data-brand_id="{{$value->brand_id}}"
                                        data-brand_name="{{$value->brand->brand_name}}">
                                        <i class="fas fa-credit-card"></i> Make Payment</a>
                                        <br>
                                        <a href="#" style="color:darkblue;" class="product_received"
                                        data-brand_id="{{$value->brand_id}}"
                                        data-brand_name="{{$value->brand->brand_name}}">
                                        <i class="far fa-money-bill-alt"></i> Product Received</a>
                                        <br>
                                        <a href="#" class="damage_adjust" data-toggle="modal" data-target="#damageModal" style="color:#03511e;"
                                            data-brand_id="{{$value->brand_id}}"
                                            data-brand_name="{{$value->brand->brand_name}}"
                                            data-damage_amount="{{$value->total_damage_amount}}">
                                            <i class="fas fa-exclamation-triangle"></i> Adjust Damage
                                        </a>
                                        <br>
                                        <a href="#" class="claim_adjust" data-toggle="modal" data-target="#claimModal" style="color:#07adaf;"
                                            data-brand_id="{{$value->brand_id}}"
                                            data-brand_name="{{$value->brand->brand_name}}"
                                            data-claim_amount="{{$value->total_claim_amount}}">
                                            <i class="fas fa-exclamation-circle"></i> Adjust Claim
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="panel-footer">
                </div>
            </div>
        </div>
    </div>

    <div id="damageModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="damageModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Damage Claim For: <span id="brand_for_damage"></span></h4>
                </div>
                <div class="modal-body" align="center">
                    <div class="table-responsive">
                        <table class="table-bordered table-condensed table-striped">
                            <form method="post" action="/storeDamageClaimedData">
                            @csrf
                            <input type="hidden" id="brand_id_for_damage" name="brand_id_for_damage" />
                            <tr>
                                <td>Date</td>
                                <td><input type="date" class="form-control" id="date_till" name="date_till" value="<?php echo date('Y-m-d'); ?>" /></td>
                            </tr>
                            <tr>
                                <td>Claimable Damage</td>
                                <td><input type="text" class="form-control" id="damage_amount" name="damage_amount" style="width:100%;" readonly/></td>
                            </tr>
                            <tr>
                                <td>Damage Claimed</td>
                                <td><input type="number" class="form-control" id="damage_received" name="damage_received" style="width:100%;" /></td>
                            </tr>
                            <tr>
                                <td>Remaining Damage</td>
                                <td><input type="text" class="form-control" id="remaining_damage" name="remaining_damage" style="width:100%;" readonly/></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><input type="submit" class="form-control btn btn-primary" value="Claim Damage"/></td>
                            </tr>
                            </form>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <div id="claimModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="claimModalLabel" aria-hidden="true">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Debit Claim For: <span id="brand_for_debit"></span></h4>
            </div>
            <div class="modal-body" align="center">
                <div class="table-responsive">
                    <table class="table-bordered table-condensed table-striped">
                        <form method="post" action="/storeDebitClaimedData">
                        @csrf
                        <input type="hidden" id="brand_id_for_debit" name="brand_id_for_debit" />
                        <tr>
                            <td>Date</td>
                            <td><input type="date" class="form-control" id="date_till" name="date_till" value="<?php echo date('Y-m-d'); ?>" /></td>
                        </tr>
                        <tr>
                            <td>Claimable</td>
                            <td><input type="text" class="form-control" id="claimable_amount" name="claimable_amount" style="width:100%;" readonly/></td>
                        </tr>
                        <tr>
                            <td>Debit Claimed</td>
                            <td><input type="number" class="form-control" id="debit_received" name="debit_received" style="width:100%;" /></td>
                        </tr>
                        <tr>
                            <td>Remaining Claim</td>
                            <td><input type="text" class="form-control" id="remaining_claim" name="remaining_claim" style="width:100%;" readonly/></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="submit" class="form-control btn btn-primary" value="Claim"/></td>
                        </tr>
                        </form>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </div>

        </div>
    </div>
</div>

<!-- The Modal -->
<!-- Modal -->

<script>
    $('.make_payment').click(function() {
        var add_div = document.getElementById('add_div');
        $('#label_header').empty();
        $('#label_transaction_text').empty();
        if(add_div != null)
        {
            var add_div = $('#add_div');
        }
        else 
        {
            var add_div = $('#edit_div');
        }
        if(add_div.attr('hidden')) 
        {
            add_div.removeAttr('hidden');

            var brand_name = $(this).data("brand_name");
            var brand_id = $(this).data("brand_id");
            var transaction_type = "Pay";

            $('#brand_id').val(brand_id);
            $('#brand_name').val(brand_name);
            $('#transaction_type').val(transaction_type);
            $('#label_header').append("<span>TT Entry</span>");
            $('#label_transaction_text').append("<span>Amount Paid</span>");
        } 
        else 
        {
            add_div.prop('hidden', true);
            document.getElementById('add_new').innerText = 'ADD NEW';
        }
    });


    $('.product_received').click(function() {
        var add_div = document.getElementById('add_div');
        $('#label_header').empty();
        $('#label_transaction_text').empty();
        if(add_div != null)
        {
            var add_div = $('#add_div');
        }
        else 
        {
            var add_div = $('#edit_div');
        }
        if (add_div.attr('hidden')) 
        {
            add_div.removeAttr('hidden');

            var brand_name = $(this).data("brand_name");
            var brand_id = $(this).data("brand_id");
            var transaction_type = "Receive";

            $('#brand_id').val(brand_id);
            $('#brand_name').val(brand_name);
            $('#transaction_type').val(transaction_type);
            $('#label_header').append("<span>Product Receive Entry</span>");
            $('#label_transaction_text').append("<span>Product Receive Amount</span>");
        } 
        else 
        {
            add_div.prop('hidden', true);
        }
    });

    $('.damage_adjust').on('click', function(e){
        var brand_name = $(this).data("brand_name");
        var brand_id = $(this).data("brand_id");
        calculateRemainingDamageForBrand(brand_id);
        $('#damage_received').val("");
        $('#remaining_damage').val("");
        $("#brand_for_damage").empty();
        $("#brand_for_damage").append(brand_name);
        $('#brand_id_for_damage').val(brand_id);
    });

    $('#damage_received').on('keyup', function(event){
        var amount_received = $(this).val();
        var damage_amount = $('#damage_amount').val();
        var remaining_damage = damage_amount - amount_received;

        $('#remaining_damage').val(remaining_damage);
    });

    $('.claim_adjust').on('click', function(event){
        var brand_name = $(this).data("brand_name");
        var brand_id = $(this).data("brand_id");
        
        $('#debit_received').val("");
        $('#remaining_claim').val("");
        $("#brand_for_debit").empty();
        $("#brand_for_debit").append(brand_name);
        $('#brand_id_for_debit').val(brand_id);
        calculateRemainingClaimForBrand(brand_id);
    });

    $('#debit_received').on('keyup', function(event){
        var amount_received = $(this).val();
        var claimable_amount = $('#claimable_amount').val();
        var remaining_claim = claimable_amount - amount_received;

        $('#remaining_claim').val(remaining_claim);
    });

    
</script>

@endsection