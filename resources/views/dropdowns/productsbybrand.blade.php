<tr>
    <td style="width:30%;">Product Name</td>
    <td>
        <select name="product_id" id="product_id" class="form-control">
        <?php
            if (old('brand_id') != NULL || request()->input('brand_id')) {
                $brand_id = (request()->input('brand_id') != NULL) ? request()->input('brand_id') : old('brand_id');
                echo "<option value=''>--Select Product--</option>";
                $products = \App\Http\Controllers\ProductController::get_products_by_brand($brand_id);
                foreach ($products as $key=>$value) {
                    echo "<option value='" . $value->id . "'";
                    echo ">" . $value->product_name . "</option>";
                }
            }
        ?>
        </select>
    </td>
</tr>

<script>
    $('#product_id').select2({
        dropdownParent: $("#add_edit")
    });
</script>