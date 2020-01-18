@extends('layouts.app')
@section('content')

<?php

use Carbon\Carbon;
?>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="panel panel-default" style="margin-top:30px;" id="printarea">
                <div class="panel-heading" style="overflow:auto;">
                    <h4>Due Report For <span><b><i>{{$brand->brand_name}}</i></b></span></h4>
                    <br>
                    <label>Date: {{Carbon::today()->toFormattedDateString()}}</label>
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-condensed table-striped table-bordered">
                            <thead>
                                <th>Index</th>
                                <th>Client Name</th>
                                <th>Due Amount</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                <?php
                                $total = 0;
                                ?>
                                @foreach($clients as $client)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $client->client_name }}</td>
                                    <td>{{ $client->due - $client->paid }}</td>
                                    <td><a href="/clienttransactiondetails/{{$client->client_id}}/{{$brand->id}}">Details</a></td>
                                    <?php
                                    $total += $client->due - $client->paid;
                                    ?>
                                </tr>
                                @endforeach
                                <tr>
                                    <td>#</td>
                                    <td>Total Due</td>
                                    <td>{{ $total }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="panel-footer">
                    <input type="button" onclick="printDiv('printarea')" class="form-control btn btn-primary" value="Print" />
                </div>
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