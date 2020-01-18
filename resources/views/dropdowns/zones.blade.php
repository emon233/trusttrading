<?php $zones = \App\Http\Controllers\ZoneController::get_zones_all();?>

<tr>
    <td style="width:30%;">Zone Name</td>
    <td>
        <select id="zone_id" name="zone_id" class="form-control zone_id" style="width:100%;" required>
            <option value="0">--Select Zone--</option>
            @foreach($zones as $key=>$value)
            <option value="{{$value->id}}">{{$value->zone_name}}</option>
            @endforeach
        </select>
    </td>
</tr>

<script>
    $('.zone_id').select2({
        dropdownParent: $("#add_edit")
    });
</script>