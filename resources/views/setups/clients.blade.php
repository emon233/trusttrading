@extends('layouts.app')

@section('content')

<div class="container" id="add_div" hidden>
    <div class="row justify-content-center">
        <div class="col-sm-6 col-md-offset-2">
            <div class="panel  panel-default" style="margin-top:30px;">
                <div class="panel-heading">
                    <label>ADD NEW CLIENT</label>
                </div>

                <div class="panel-body">
                    <form id="add_edit" name="add_edit" method="post" action="/clients">
                        @csrf
                        <table class="table-bordered table-condensed table-striped" style="width:100%">
                            <tr>
                                <td style="width:30%;">Name</td>
                                <td style="width:70%;">
                                    <input type="text" id="client_name" name="client_name" class="form-control" style="width:100%;" required/>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:30%;">Mobile</td>
                                <td style="width:70%;">
                                    <input type="text" id="mobile" name="mobile" class="form-control" style="width:100%;" required/>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:30%;">Address</td>
                                <td style="width:70%;">
                                    <textarea type="text" id="address" name="address" class="form-control" style="width:100%;" required></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td><input type="hidden" id="id" name="id" /></td>
                            </tr>
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
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="panel  panel-default" style="margin-top:30px;">
                <div class="panel-heading" style="overflow:auto;">
                    <label>Clients</label>

                    <button type="button" id="add_new" name="add_new" class="btn btn-primary" style="float:right;">
                        ADD NEW
                    </button>
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed">
                            <thead>
                                <th>Index</th>
                                <th>Name</th>
                                <th>Mobile</th>
                                <th>Address</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Actions</th>
                            </thead>

                            <tbody>
                                @foreach($clients as $key=>$value)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$value->client_name}}</td>
                                    <td>{{$value->mobile}}</td>
                                    <td>{{$value->address}}</td>
                                    <td>{{$value->created_at}}</td>
                                    <td>{{$value->updated_at}}</td>
                                    <td>
                                        <div role="group">
                                            <a href="#" class="edit" style="color:green;" 
                                            data-id="{{$value->id}}" 
                                            data-client_name="{{$value->client_name}}"
                                            data-mobile="{{$value->mobile}}"
                                            data-address="{{$value->address}}">
                                                Edit
                                            </a>&nbsp;
                                            
                                            <a href="/clients/destroy/{{$value->id}}" style="color:red;">Delete</a>
                                        </div>
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

<script>
    $('#add_new').click(function() {
        $('#add_edit').attr('action','/clients');
    });

    $('.edit').click( function(){
        var id = $(this).data("id");
        var client_name = $(this).data("client_name");
        var mobile = $(this).data("mobile");
        var address = $(this).data("address");
        
        $('#add_edit').attr('action', '/clients/update');

        $('#id').val(id);
        $('#client_name').val(client_name);
        $('#mobile').val(mobile);
        $('#address').val(address);
    });
</script>

@endsection
