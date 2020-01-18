@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="panel panel-default" style="margin-top:30px;">
                <div class="panel-heading" style="overflow:auto;">
                    <label>Brand Transactions</label>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-condensed">
                            <form method="get" action="/brandtransactionbydatesearch">
                                <tr>
                                    <td>
                                        <select id="month" name="month" class="form-control">
                                            <option value="1">January</option>
                                            <option value="2">February</option>
                                            <option value="3">March</option>
                                            <option value="4">April</option>
                                            <option value="5">May</option>
                                            <option value="6">June</option>
                                            <option value="7">July</option>
                                            <option value="8">August</option>
                                            <option value="9">September</option>
                                            <option value="10">October</option>
                                            <option value="11">November</option>
                                            <option value="12">December</option>
                                        </select>
                                    </td>
                                    <td>
                                        <select id="year" name="year" class="form-control">
                                        </select>
                                    </td>
                                    <input type="hidden" id="brand_id" name="brand_id" value="{{$brand[0]->id}}">
                                    <td>
                                        <input type="submit" class="btn btn-primary form-control" value="Search"/>
                                    </td>
                                </tr>
                            </form>
                        </table>
                    </div>
                </div>
                <div id="printarea" class="panel-body" align="center">
                    <h3>{{$brand[0]->brand_name}}</h3>

                    <?php
                    $monthNum  = $month;
                    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                    $monthName = $dateObj->format('F');
                    ?>
                    <h4>{{$monthName}}, {{$year}}</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-condensed">
                            <thead>
                                <th>Index</th>
                                <th>Transaction Date</th>
                                <th>Transaction Type</th>
                                <th>Transaction Amount (In Tk.)</th>
                                <th>Actions</th>
                            </thead>
                            <?php
                                $total_pay = 0;
                                $total_receive = 0;
                            ?>
                            <tbody>
                                @foreach($transactions as $key=>$value)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$value->created_at->toDateString()}}</td>
                                    <td>{{$value->transaction_type}}</td>
                                    <td>{{$value->transaction_amount}}</td>
                                    <?php
                                    if($value->transaction_type == "Pay")
                                        $total_pay = $total_pay + $value->transaction_amount;
                                    else
                                        $total_receive = $total_receive + $value->transaction_amount;
                                    ?>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <h4>Total Paid: {{$total_pay}}</h4>
                    <h4>Total Received: {{$total_receive}}</h4>
                    <h4>Total Due: {{$total_pay - $total_receive}}</h4>
                </div>
                <input type="button" class="btn btn-primary" onclick="printDiv('printarea')" value="Print"/>
            </div>
        </div>
    </div>
</div>

<script>

    var year = 2019;
    var till = 2025;
    var options = "";
    
    for(var y=year; y<=till; y++){
        options += "<option>"+ y +"</option>";
    }
    document.getElementById("year").innerHTML = options;

    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }

</script>

@endsection