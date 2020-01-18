@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="panel panel-default" style="margin-top:30px;">
                <div class="panel-heading" style="overflow:auto;">
                    <label>Reports</label>
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
                                        <a target="_blank" rel="noopener noreferrer" href="/dailybrandfinalcount/{{$value->brand_id}}" style="color:blue;"><i class="fas fa-globe"></i> Final Count</a>
                                        <br>
                                        <a target="_blank" rel="noopener noreferrer" href="/dailybranddue/{{$value->brand_id}}" style="color:red;"><i class="fal fa-money-bill-alt"></i> Market Due List</a>
                                        <br>
                                        <a target="_blank" rel="noopener noreferrer" href="/dailybrandpayment/{{$value->brand_id}}" style="color:green;"><i class="far fa-money-bill-alt"></i> Market Payment List</a>
                                        <br>
                                        <a target="_blank" rel="noopener noreferrer" href="/dailybrandtransaction/{{$value->brand_id}}" style="color:darkblue;"><i class="fas fa-money-check"></i> Market Full Transaction List</a>
                                        <br>
                                        <a target="_blank" rel="noopener noreferrer" href="/brandtransaction/{{$value->brand_id}}" style="color:maroon;"><i class="fas fa-money-check"></i> Brand Transaction List</a>
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
</div>

@endsection