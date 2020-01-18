<?php $delivery_men = \App\Http\Controllers\DeliveryManController::get_deliverymen_all();?>

<tr>
    <td style="width:30%;">Delivery Man Name</td>
    <td>
        <select id="delivery_man_id" name="delivery_man_id" class="form-control delivery_man_id" style="width:100%;" required>
            <option value="0">--Select Delivery Man--</option>
            @foreach($delivery_men as $key=>$value)
            <option value="{{$value->id}}">{{$value->delivery_man_name}}</option>
            @endforeach
        </select>
    </td>
</tr>

<script>
    $('.delivery_man_id').select2({
        dropdownParent: $("#add_edit")
    });
</script>