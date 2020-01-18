<?php $categories = \App\Http\Controllers\CategoryController::get_categories_all();?>

<tr>
    <td style="width:30%;">Category Name</td>
    <td>
        <select id="category_id" name="category_id" class="form-control category_id" style="width:100%;" required>
            <option value="0">--Select Category--</option>
            @foreach($categories as $key=>$value)
            <option value="{{$value->id}}">{{$value->category_name}}</option>
            @endforeach
        </select>
    </td>
</tr>

<script>
    $('.category_id').select2({
        dropdownParent: $("#add_edit")
    });
</script>