@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="panel panel-default" style="margin-top:30px;">
                <div class="panel-heading" style="overflow:auto;">
                    <label>Daily Due Report</label>
                </div>
                <div class="panel-body">
                    <form id="search">
                        <table id="table_client" class="table-bordered table-striped table-condensed">
                            @include('dropdowns.clients')
                            <tr>
                                <td></td>
                                <td><input type="submit" class="btn btn-primary" value="Search" style="width:100%;"></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div class="panel-body" align="center;">
                    <div class="table table-resonsive">
                        <table class="table-bordered table-striped table-condensed">
                            <thead>
                                <th>Index</th>
                                <th>Transaction Date</th>
                                <th>Transaction Type</th>
                                <th>Transaction Amount</th>
                            </thead>
                            <tbody id="result">
                            </tbody>
                        </table>
                    </div>
                    <div id="result_2">
                        <table>
                            <tr>
                                <td><h4>Total Due: </h4></td>
                                <td><input type="text" class="form-control" id="total_due" readonly/></td>
                            </tr>
                            <tr>
                                <td><h4>Total Paid: </h4></td>
                                <td><input type="text" class="form-control" id="total_paid" readonly/></td>
                            </tr>
                            <tr>
                                <td><h4>Final Amount: </h4></td>
                                <td><input type="text" class="form-control" id="final_amount" readonly/></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $('#search').on('submit', function(event){
        event.preventDefault();
        var form_data = $(this).serialize();
        var url = "/reportclienttransactiondetails";
        var total_due = 0;
        var total_paid = 0;
        $('#result').empty();
        $.ajax({
            url:url,
            method:'get',
            data:form_data,
            dataType:'json',
            success:function(data)
            {
                var j=1;
                for (var i=0; i<data.length; i++) {
                    var date = data[i].created_at;
                    $('#result').append(
                        '<tr>'+
                            '<td>'+i+1+'</td>'+
                            '<td>'+date+'</td>'+
                            '<td>'+data[i].transaction_type+'</td>'+
                            '<td>'+data[i].transaction_amount+'</td>'+
                        '</tr>'
                        
                    );
                    if(data[i].transaction_type == "Due")
                    {
                        total_due = parseInt(total_due) + parseInt(data[i].transaction_amount);
                    }
                    else
                    {
                        total_paid = parseInt(total_paid) + parseInt(data[i].transaction_amount);
                    }
                }
                $('#total_due').empty();
                $('#total_paid').empty();
                $('#final_amount').empty();

                $('#total_due').val(total_due);
                $('#total_paid').val(total_paid);
                $('#final_amount').val(total_due - total_paid);
            },
            error:function(data)
            {
                console.log(data);
            }
        });
    });

</script>

@endsection