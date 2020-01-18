@extends('layouts.app')

@section('content')

<div class="container" id="add_div" hidden>
    <div class="row justify-content-center">
        <div class="col-sm-6 col-md-offset-2">
            <div class="panel  panel-default" style="margin-top:30px;">
                <div class="panel-heading">
                    <label>ADD NEW ZONE</label>
                </div>

                <div class="panel-body">
                    <form id="add_edit" name="add_edit" method="post" action="/zones">
                        @csrf
                        <table class="table-bordered table-condensed table-striped" style="width:100%">
                            <tr>
                                <td style="width:30%;">Zone Name</td>
                                <td style="width:70%;">
                                    <input type="text" id="zone_name" name="zone_name" class="form-control" style="width:100%;" required/>
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
                    <label>Zones</label>

                    <button type="button" id="add_new" name="add_new" class="btn btn-primary" style="float:right;">
                        ADD NEW
                    </button>
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed">
                            <thead>
                                <th>Index</th>
                                <th>Zone Name</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Actions</th>
                            </thead>

                            <tbody>
                                @foreach($zones as $key=>$value)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$value->zone_name}}</td>
                                    <td>{{$value->created_at}}</td>
                                    <td>{{$value->updated_at}}</td>
                                    <td>
                                        <div role="group">
                                            <a href="#" class="edit" style="color:green;" 
                                            data-id="{{$value->id}}" 
                                            data-zone_name="{{$value->zone_name}}">
                                                Edit
                                            </a>&nbsp;
                                            
                                            <a href="/zones/destroy/{{$value->id}}" style="color:red;">Delete</a>
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
        $('#add_edit').attr('action','/zones');
    });

    $('.edit').click( function(){
        var id = $(this).data("id");
        var zone_name = $(this).data("zone_name");
        var zone_contact_detail = $(this).data("zone_contact_detail");
        $('#add_edit').attr('action', '/zones/update');

        $('#id').val(id);
        $('#zone_name').val(zone_name);
        $('#zone_contact_detail').val(zone_contact_detail);
    });
</script>

@endsection
