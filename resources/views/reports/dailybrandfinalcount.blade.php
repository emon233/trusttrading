@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="panel panel-default" style="margin-top:30px;">
                <div class="panel-heading" style="overflow:auto;">
                    <label>Report - Daily Final Count <span style="color:blue;">{{$final_counts[0]->brand->brand_name}}</span></label>
                </div>
                <div class="panel-body">
                    <form id="search" method="get" action="/reportdailybrandfinalcountbydatesearch">
                        <table class="table-bordered table-striped table-condensed">
                            <tr>
                                <td><b>Date: </b></td>
                                <input type="hidden" id="brand_id" name="brand_id" value="{{$final_counts[0]->brand_id}}"/>
                                <td><input type="date" class="form-control" id="search_date" name="search_date" value="{{ date('Y-m-d') }}"/></td>
                                <td><input type="submit" class="btn btn-primary" value="Search"></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div id="printarea" class="panel-body" align="center">
                    <h2>{{$final_counts[0]->brand->brand_name}}</h2>
                    <h4>Date: {{$final_counts[0]->date}}</h4>
                    <div class="table table-responsive">
                        <table class="table-bordered table-striped table-condensed">
                            <tr>
                                <td><b>Net Receivable: </b></td>
                                <td><i>{{$final_counts[0]->net_product_sell}}</i></td>
                            </tr>
                            <tr>
                                <td><b>Total Receivable: </b></td>
                                <td><i>{{$final_counts[0]->product_sell}}</i></td>
                            </tr>
                            <tr>
                                <td><b>Total Received: </b></td>
                                <td><i>{{$final_counts[0]->collection}}</i></td>
                            </tr>
                            <tr>
                                <td><b>Total Due: </b></td>
                                <td><i>{{$final_counts[0]->market_due}}</i></td>
                            </tr>
                            <tr>
                                <td><b>Total Claimable: </b></td>
                                <td><i>{{$final_counts[0]->debit_claim}}</i></td>
                            </tr>
                            <tr>
                                <td><b>Total Damage: </b></td>
                                <td><i>{{$final_counts[0]->damage}}</i></td>
                            </tr>
                            <tr>
                                <td><b>Total Due Collection: </b></td>
                                <td><i>{{$final_counts[0]->due_collection}}</i></td>
                            </tr>
                        </table>
                    </div>
                    <h4>Total Collection: <i>{{$final_counts[0]->collection + $final_counts[0]->due_collection}}</i></h4>
                </div>
                <input type="button" class="btn btn-primary" onclick="printDiv('printarea')" value="Print">
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