@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="panel panel-default" style="margin-top:30px;">
                <div class="panel-heading" style="overflow:auto;">
                    <label>Report - Daily Final Count <span style="color:blue;">{{$no_data[0]->brand_name}}</span></label>
                </div>
                <div class="panel-body">
                    <span style="color:red;"><b>No Data Found</b></span>
                </div>
                <div class="panel-body">
                    <form id="search" method="get" action="/reportdailybrandfinalcountbydatesearch">
                        <table class="table-bordered table-striped table-condensed">
                            <tr>
                                <td><b>Date: </b></td>
                                <input type="hidden" id="brand_id" name="brand_id" value="{{$no_data[0]->id}}"/>
                                <td><input type="date" class="form-control" id="search_date" name="search_date" value="{{ date('Y-m-d') }}"/></td>
                                <td><input type="submit" class="btn btn-primary" value="Search"></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection