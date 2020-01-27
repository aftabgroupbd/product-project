<div class="box-body">
    <div class="table-responsive">
        <table class="table no-margin">
            <thead>
            <tr>
                
                <th style="border:1px solid #dee2e6">Product Name</th>
                <th style="border:1px solid #dee2e6">Quantity</th>
                <th style="border:1px solid #dee2e6">Size <span style="font-size: 11px;color:#e11616;">(inches/liter/kg)</span></th>
                <th style="border:1px solid #dee2e6">Unit Price</th>
                <th style="border:1px solid #dee2e6">Amount</th>
                <th style="border:1px solid #dee2e6">Entry Date</th>
                 <th style="border:1px solid #dee2e6">Name</th>
                <th style="border:1px solid #dee2e6">Procurer/Issue</th>
                <th style="border:1px solid #dee2e6">Vendor Name</th>
                <th style="border:1px solid #dee2e6">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php if( ! empty($products)) { ?>
                 
                <?php foreach($products as $product){
                   
                    ?>
                    <tr>
                        
                        <td style="border:1px solid #dee2e6"><?php echo $product->product_name ?></td>
                        <td style="border:1px solid #dee2e6"><?php echo $product->product_quantity  ?></td>
                        <td style="border:1px solid #dee2e6"><?php echo $product->size  ?></td>
                        <td style="border:1px solid #dee2e6"><?php echo $product->unit_price  ?></td>
                        <td style="border:1px solid #dee2e6"><?php echo $product->amount  ?></td>
                        <td style="border:1px solid #dee2e6"><?php echo $product->entry_date  ?></td>
                        <td style="border:1px solid #dee2e6"><?php echo $product->procurer_name  ?></td>
                        <td style="border:1px solid #dee2e6">procurer</td>
                        <td style="border:1px solid #dee2e6"><?php echo $product->vendor_name  ?></td>
                        <td style="border:1px solid #dee2e6" class="action">
                            <button class="btn btn-primary entry_edit" entry_id="<?= $product->id ?>">Edit</button>
                        </td>
                    </tr>
                    
                <?php } ?>
            <?php } else { ?>
                <tr><td colspan="8" class="no-records">No records</td></tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<div class="box-footer" style="margin-top:20px;">
    <ul class="pagination">
        <?php echo $pagelinks ?>
    </ul>
</div>
<script>
    $(".entry_edit").click(function () {
        var entry_value = $(this).attr('entry_id');
        $("#EditModal").modal('show');
        $('#editForm').attr('action', '<?php echo base_url("update-entry") ?>');
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: '<?php echo base_url("edit-entry") ?>',
            data: {entry_value: entry_value},
            async: false,
            dataType: 'json',
            success: function(data){
                $('input[name=product_name]').val(data.product_name);
                $('input[name=product_quantity]').val(data.product_quantity);
                $('input[name=product_size]').val(data.size);
                $('input[name=unit_price]').val(data.unit_price);
                $('input[name=amount]').val(data.amount);
                $('input[name=entry_date]').val(data.entry_date);
                $('input[name=procurer_name]').val(data.procurer_name);
                $('input[name=vendor_name]').val(data.vendor_name);
                $('input[name=entry_id]').val(data.id);
            },
            error: function(){
                alert('Could not Edit Data');
            }
        });
    });
</script>
<script>

    $("#update_btn").click(function () {
        var url = $('#editForm').attr('action');

        var data = $('#editForm').serialize();

        $.ajax({
            method: 'POST',
            url: url,
            data: data,
            success: function(response){
                // swal('Message',response,'success');
                $("#EditModal").modal('hide');
                $('#editForm')[0].reset();
                showMessage();
                document.location.reload(true);
            },
            error: function(){
                alert('Could not add data');
            }
        });
    });

    function showMessage() {
        swal({
            title: "Entry Update",
            text: "You have successfully Updated.",
            type: "success",
            showCancelButton: true,
            //confirmButtonText: "Admin Message",
            //cancelButtonText: "Cancel",
            closeOnConfirm: false,
            closeOnCancel: false
        })
    }
</script>