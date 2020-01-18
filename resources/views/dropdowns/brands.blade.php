<?php $brands = \App\Http\Controllers\BrandController::get_brands_all();?>

<tr>
    <td style="width:30%;">Brand Name</td>
    <td>
        <select id="brand_id" name="brand_id" class="form-control brand_id" style="width:100%;" required>
            <option value="0">--Select Brand--</option>
            @foreach($brands as $key=>$value)
            <option value="{{$value->id}}">{{$value->brand_name}}</option>
            @endforeach
        </select>
    </td>
</tr>

<script>
    $('.brand_id').select2({
        dropdownParent: $("#add_edit")
    });
</script>
