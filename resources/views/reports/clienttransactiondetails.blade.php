@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="panel panel-default" style="margin-top:30px;">
                <div class="panel-heading" style="overflow:auto;">
                    <label>Due Report For Client: {{$client->client_name}}</label>
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
                            <tbody>
                                <?php
                                    $paid = 0;
                                    $due = 0;
                                ?>
                                @foreach($brand->daily_zone_deliveryman_combos as $key=>$dailyBrand)
                                    @foreach($dailyBrand->acc_client_transactions as $key2=>$transaction)

                                        @if($transaction->client_id == $client->id)
                                        <tr>
                                            <td>#</td>
                                            <td>{{$transaction->created_at}}</td>
                                            <td>{{$transaction->transaction_type}}</td>
                                            <td>{{$transaction->transaction_amount}}</td>
                                        </tr>
                                            @if($transaction->transaction_type == "Due")
                                                <?php
                                                    $due += $transaction->transaction_amount;
                                                ?>
                                            @else
                                                <?php
                                                    $paid += $transaction->transaction_amount;
                                                ?>
                                            @endif
                                        @endif
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>
                        
                        Final Account: {{$due - $paid}}
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection