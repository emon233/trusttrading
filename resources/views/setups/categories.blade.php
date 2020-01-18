@extends('layouts.app')

@section('content')


<div class="container" id="add_div" hidden>
    <div class="row justify-content-center">
        <div class="col-sm-6 col-md-offset-2">
            <div class="panel  panel-default" style="margin-top:30px;">
                <div class="panel-heading">
                    <label>ADD NEW CATEGORY</label>
                </div>

                <div class="panel-body">
                    <form id="add_edit" method="post" action="/categories">
                        @csrf
                        <table class="table-bordered table-condensed table-striped" style="width:100%">
                            <tr>
                                <td style="width:30%;">Category Name</td>
                                <td style="width:70%;">
                                    <input type="text" id="category_name" name="category_name" class="form-control" style="width:100%;" required/>
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
                    <label>Product Categories</label>

                    <button type="button" id="add_new" name="add_new" class="btn btn-primary" style="float:right;">
                        ADD NEW
                    </button>
                </div>

                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-condensed">
                            <thead>
                                <th>Index</th>
                                <th>Category Name</th>
                                <th>Created At</th>
                                <th>Updated At</th>
                                <th>Actions</th>
                            </thead>

                            <tbody>
                                @foreach($categories as $key=>$value)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$value->category_name}}</td>
                                    <td>{{$value->created_at}}</td>
                                    <td>{{$value->updated_at}}</td>
                                    <td>
                                        <div role="group">
                                            <a href="#" class="edit" style="color:green;" 
                                            data-id="{{$value->id}}" 
                                            data-category_name="{{$value->category_name}}">
                                                Edit
                                            </a>&nbsp;
                                            
                                            <a href="/categories/destroy/{{$value->id}}" style="color:red;">Delete</a>
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
        $('#add_edit').attr('action','/categories');
    });

    $('.edit').click( function(){
        var id = $(this).data("id");
        var category_name = $(this).data("category_name");
        $('#add_edit').attr('action', '/categories/update');
        
        $('#id').val(id);
        $('#category_name').val(category_name);
    });
</script>


@endsection
