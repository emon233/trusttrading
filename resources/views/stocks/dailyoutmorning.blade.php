@extends('layouts.app')
@section('content')

<div class="container" id="add_div">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="panel panel-default" style="margin-top:30px;">
                <div class="panel-heading">
                    <label>DAILY MORNING OUT</label>
                </div>

                <div class="panel-body">
                    <div class="col-sm-6 col-md-offset-2">
                        <div class="panel  panel-default" style="margin-top:10px;">
                            <div class="panel-heading">
                                <label>Assign Delivery Man To Zone</label>
                            </div>

                            <div class="panel-body">
                                <form id="add_edit" name="add_edit" method="post" action="/dailyzonedeliverymancombo">
                                    @csrf
                                    <table class="table-bordered table-condensed table-striped" style="width:100%">
                                        @include('dropdowns.zones')
                                        @include('dropdowns.deliverymen')
                                        @include('dropdowns.brands')
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

                <div class="panel-body">
                    <div class="col-lg-10 col-md-offset-1">
                        <div class="panel  panel-default" style="margin-top:10px;">
                            <div class="panel-heading">
                                <label>Previous Entries</label>
                            </div>

                            <div class="panel-body">
                                <div align="center">
                                    <form method="get" action="/search_dailysheet_by_date">
                                        <table class="table-bordered table-condensed table-striped" style="width:25%">
                                            <tr>
                                                <td><input type="date" id="date" name="date" class="form-control" value="{{ date('Y-m-d') }}"/></td>
                                                <td><input type="submit" class="btn btn-primary form-control" value="Search"></td>
                                            </tr>
                                        </table>
                                    </form>
                                </div>
                                <br>
                                <div>
                                    <table class="table-bordered table-condensed table-striped" style="width:100%">
                                        <thead>
                                            <th>Index</th>
                                            <th>Zone Name</th>
                                            <th>Delivery Man</th>
                                            <th>Brand</th>
                                            <th>Creation Date</th>
                                            <th>Action</th>
                                        </thead>

                                        <tbody>
                                            @foreach($combos as $key=>$value)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$value->zone->zone_name}}</td>
                                                <td>{{$value->delivery_man->delivery_man_name}}</td>
                                                <td>{{$value->brand->brand_name}}</td>
                                                <td>{{$value->created_at->toDateString()}}</td>
                                                <td>
                                                    <a href="/morningoutproducts/{{$value->id}}" style="color:darkblue">Assign Product</a>
                                                    <br>
                                                    <a href="/eveningoutproducts/{{$value->id}}" style="color:green;">Evening Entry</a>
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
        </div>
    </div>
</div>

@endsection