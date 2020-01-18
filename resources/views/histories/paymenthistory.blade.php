@extends('layouts.app')
@section('content')

<div class="container" id="add_div" hidden>
    <div class="row justify-content-center">
        <div class="col-sm-6 col-md-offset-2">
            <div class="panel  panel-default" style="margin-top:30px;">
                <div class="panel-heading">
                    <label>UPDATE TRANSACTION INFO: <span style="color:blue;">{{$brand->brand_name}}<span></label>
                    <button type="button" id="add_new" name="add_new" class="btn btn-danger" style="float:right;">
                        ADD NEW
                    </button>
                </div>

                <div class="panel-body">
                    <form id="add_edit" method="post" action="/accounts/update">
                        @csrf
                        <table class="table-bordered table-condensed table-striped" style="width:100%">
                            <tr>
                                <td style="width:30%;">Transaction Date</td>
                                <td style="width:70%;">
                                    <input type="text" id="transaction_date" name="transaction_date" class="form-control" style="width:100%;" readonly/>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:30%;">Transaction Type</td>
                                <td style="width:70%;">
                                    <input type="text" id="transaction_type" name="transaction_type" class="form-control" style="width:100%;" readonly/>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:30%;">Transaction Amount</td>
                                <td style="width:70%;">
                                    <input type="text" id="transaction_amount" name="transaction_amount" class="form-control" style="width:100%;"/>
                                </td>
                                <input type="hidden" id="id" name="id"/>
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
                    <label>Transaction History: <span style="color:blue;">{{$brand->brand_name}}</span></label>
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed">
                            <thead>
                                <th>Index</th>
                                <th>Transaction Type</th>
                                <th>Transaction Amount (In Tk.)</th>
                                <th>Transaction Date</th>
                                <th>Last Updated</th>
                                <th>Actions</th>
                            </thead>

                            <tbody>
                                @foreach($histories as $key=>$value)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$value->transaction_type}}</td>
                                    <td>{{$value->transaction_amount}}</td>
                                    <td>{{$value->created_at->toDateString()}}</td>
                                    <td>{{$value->updated_at}}</td>
                                    <td>
                                        <a href="#" class="edit" data-id="{{$value->id}}"
                                        data-transaction_amount="{{$value->transaction_amount}}"
                                        data-transaction_type="{{$value->transaction_type}}"
                                        data-transaction_date="{{$value->created_at->toDateString()}}"
                                        >Edit</a>
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

<script>

    $('.edit').click(function(){
        var id = $(this).data("id");
        var date = $(this).data("transaction_date");
        var amount = $(this).data("transaction_amount");
        var type = $(this).data("transaction_type");
        
        $('#transaction_date').val(date);
        $('#transaction_type').val(type);
        $('#transaction_amount').val(amount);
        $('#id').val(id);
        
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
