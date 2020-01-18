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
                                <th>Total Paid</th>
                                <th>Total Due</th>
                                <th>Total Cash</th>
                                <th>Total Market Due</th>
                                <th>Total Damage</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @foreach($brands as $key=>$value)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$value->brand->brand_name}}</td>
                                    <td>{{$value->total_paid_amount}}</td>
                                    <td>{{$value->total_due_amount}}</td>
                                    <td>{{$value->total_cash_amount}}</td>
                                    <td>{{$value->total_market_due_amount}}</td>
                                    <td>{{$value->total_damage_amount}}</td>
                                    <td>
                                        <a target="_blank" rel="noopener noreferrer" href="/inventroyreportdetails/{{$value->brand_id}}" style="color:blue;"><i class="fas fa-globe"></i> Invetory Status</a>
                                        <br>
                                        <a target="_blank" rel="noopener noreferrer" href="/brandinformationdetails/{{$value->brand_id}}" style="color:blue;"><i class="fas fa-globe"></i> Brand Info</a>
                                        <br>
                                        <a target="_blank" rel="noopener noreferrer" href="/duereportdetails/{{$value->brand_id}}" style="color:blue;"><i class="fas fa-globe"></i> Dues</a>
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