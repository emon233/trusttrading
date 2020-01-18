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
                    <h4>Due Report For <span><b><i>{{$brand[0]->brand_name}}</i></b></span></h4>
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
                                    $brand_due = 0;
                                ?>
                                @for($i=0; $i<$counter2; $i++)
                                
                                    <?php
                                        $total_due = 0;
                                        $total_paid = 0;
                                    ?>
                                    @for($j=0; $j<$counter; $j++)
                                        
                                        @if($clients[$i]->client_id == $transactions[$j]->client_id)
                                            <?php
                                                if($transactions[$j]->type == "Due")
                                                {
                                                    $total_due = $total_due + $transactions[$j]->amount;
                                                }
                                                else
                                                {
                                                    $total_paid = $total_paid + $transactions[$j]->amount;
                                                }
                                            ?>
                                        @endif
                                    @endfor
                                    <?php
                                        $final_due = $total_due - $total_paid;
                                    ?>
                                    @if($final_due != 0)
                                        <tr>
                                            <td>#</td>
                                            <td>{{$clients[$i]->client_name}}</td>
                                            <td>{{$final_due}}</td>
                                            <td><a href="/clienttransactiondetails/{{$clients[$i]->client_id}}/{{$brand[0]->id}}">Details</a></td>
                                        </tr>
                                        <?php
                                            $brand_due = $brand_due + $final_due;
                                        ?>
                                    @endif
                                @endfor
                                <td></td>
                                <td>Total Due</td>
                                <td>{{$brand_due}}</td>
                                <td></td>
                                
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