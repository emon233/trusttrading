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
                    <form id="search" method="get" action="/dailybrandduedatesearch">
                        <table class="table-bordered table-striped table-condensed">
                            <tr>
                                <td><b>Date: </b></td>
                                <input type="hidden" id="brand_id" name="brand_id" value="{{$brand[0]->id}}"/>
                                <td><input type="date" class="form-control" id="search_date" name="search_date" value="{{ date('Y-m-d') }}"/></td>
                                <td><input type="submit" class="btn btn-primary" value="Search"></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div id="printarea" class="panel-body" align="center">
                    <h3>{{$brand[0]->brand_name}}</h3>
                    <h4>Date: {{$date}}</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-condensed">
                            <thead>
                                <th>Index</th>
                                <th>Client</th>
                                <th>Transaction Type</th>
                                <th>Transaction Amount</th>
                            </thead>
                            <tbody>
                                @foreach($transactions_due as $key=>$value)
                                    <tr>
                                        <td>{{$key+1}}</td>
                                        <td>{{$value->client_name}}</td>
                                        <td>{{$value->transaction_type}}</td>
                                        <td>{{$value->transaction_amount}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
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
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
@endsection