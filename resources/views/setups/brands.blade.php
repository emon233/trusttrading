@extends('layouts.app')
@section('content')

<div class="container" id="add_div" hidden>
    <div class="row justify-content-center">
        <div class="col-sm-6 col-md-offset-2">
            <div class="panel  panel-default" style="margin-top:30px;">
                <div class="panel-heading">
                    <label>ADD NEW BRAND</label>
                </div>

                <div class="panel-body">
                    <form id="add_edit" name="add_edit" method="post" action="/brands">
                        @csrf
                        <table class="table-bordered table-condensed table-striped" style="width:100%">
                            <tr>
                                <td style="width:30%;">Brand Name</td>
                                <td style="width:70%;">
                                    <input type="text" id="brand_name" name="brand_name" class="form-control" style="width:100%;" required/>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:30%;">Contact Info</td>
                                <td style="width:70%;">
                                    <textarea class="form-control" id="brand_contact_detail" name="brand_contact_detail" style="width:100%;" required></textarea>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:30%;">Mobile No:</td>
                                <td style="width:70%;">
                                    <input type="text" id="brand_mobile_no_1" name="brand_mobile_no_1" class="form-control" style="width:100%;"/>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:30%;">Mobile No:</td>
                                <td style="width:70%;">
                                    <input type="text" id="brand_mobile_no_2" name="brand_mobile_no_2" class="form-control" style="width:100%;"/>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:30%;">Phone No:</td>
                                <td style="width:70%;">
                                    <input type="text" id="brand_mobile_no_3" name="brand_mobile_no_3" class="form-control" style="width:100%;"/>
                                </td>
                            </tr>
                            <tr>
                                <td style="width:30%;">Account No:</td>
                                <td style="width:70%;">
                                    <input type="text" id="brand_account_no" name="brand_account_no" class="form-control" style="width:100%;"/>
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
                    <label>Brands</label>
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
                                <th>Contact Info</th>
                                <th>Mobile No</th>
                                <th>Phone No</th>
                                <th>Account No</th>
                                <th>Actions</th>
                                <th>Advance</th>
                            </thead>
                            <tbody>
                                @foreach($brands as $key=>$value)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$value->brand_name}}</td>
                                    <td>{{$value->brand_contact_detail}}</td>
                                    <td>{{$value->brand_mobile_no_1}}</td>
                                    <td>{{$value->brand_mobile_no_3}}</td>
                                    <td>{{$value->brand_account_no}}</td>
                                    <td>
                                        <div role="group">
                                            <a href="#" class="edit" style="color:green;" 
                                            data-id="{{$value->id}}" 
                                            data-brand_name="{{$value->brand_name}}"
                                            data-brand_contact_detail="{{$value->brand_contact_detail}}">
                                                Edit
                                            </a>&nbsp;
                                            <a href="/brands/destroy/{{$value->id}}" style="color:red;">Delete</a>
                                        </div>
                                    </td>
                                    <td>
                                        <div role="group">
                                            <a href="/products/{{$value->id}}" style="color:blue;"><i class="fa fa-paw"></i> Products</a>
                                            <br>
                                            <a href="/stocks/{{$value->id}}" style="color:green;"><i class="fa fa-database"></i> Inventory</a>
                                            <br>
                                            <a href="/purchases/{{$value->id}}" style="color:DarkBlue;"><i class="fa fa-truck"></i> Purchase</a>
                                            <br>
                                            <a href="/accounts" style="color:DarkRed;"><i class="fas fa-dollar-sign"></i> Accounts</a>
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
        $('#add_edit').attr('action','/brands');
    });

    $('.edit').click( function(){
        var id = $(this).data("id");
        var brand_name = $(this).data("brand_name");
        var brand_contact_detail = $(this).data("brand_contact_detail");
        $('#add_edit').attr('action', '/brands/update');
        $('#id').val(id);
        $('#brand_name').val(brand_name);
        $('#brand_contact_detail').val(brand_contact_detail);
    });
</script>

@endsection

