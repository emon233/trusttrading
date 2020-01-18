<?php $clients = \App\Http\Controllers\ClientController::get_clients_all();?>

<tr>
    <td style="width:30%;">Client Name</td>
    <td>
        <select id="client_id" name="client_id" class="form-control client_id" style="width:100%;" required>
            <option value="0">--Select Client--</option>
            @foreach($clients as $key=>$value)
            <option value="{{$value->id}}">{{$value->client_name}}</option>
            @endforeach
        </select>
    </td>
</tr>

<script>
    $('.client_id').select2({
        dropdownParent: $("#table_client")
    });
   
</script>