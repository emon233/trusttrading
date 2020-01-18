@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel  panel-default" style="margin-top:30px;">

                <div class="panel-body">
                    <div class="alert alert-success" role="alert">
                        {{ strtoupper($message)}} only page!
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection