@extends('layouts.app')
@section('content')

<div class="container" id="add_div">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="panel panel-default" style="margin-top:30px;">
                <div class="panel-heading">
                    <label>Daily Sheet</label>
                </div>

                <div class="panel-body">
                    <table class="table-bordered table-condensed table-striped" style="width:100%">
                        <thead>
                            <th>Index</th>
                            <th>Date</th>
                            <th>Brand</th>
                            <th>Zone</th>
                            <th>Deliveryman</th>
                            <th>Total Receivable</th>
                            <th>Total Received</th>
                            <th>Total Due</th>
                            <th>Total Damage</th>
                            <th>Action</th>
                        </thead>
                        <tbody>
                            @foreach($daily_sheets as $key=>$value)
                            <tr>
                                <td>{{$key+1}}</td>
                                <td>{{$value->created_at->toDateString()}}</td>
                                <td>{{$value->brand->brand_name}}</td>
                                <td>{{$value->zone->zone_name}}</td>
                                <td>{{$value->delivery_man->delivery_man_name}}</td>
                                <td>{{$value->total_receivable}}</td>
                                <td>{{$value->total_received}}</td>
                                <td>{{$value->total_due}}</td>
                                <td>{{$value->total_damage}}</td>
                                <td>
                                    <a target="_blank" rel="noopener noreferrer" href="/dailysheetdetails/{{$value->id}}">Detail</a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $daily_sheets->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection