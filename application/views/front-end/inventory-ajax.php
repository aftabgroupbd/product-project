<div class="box-body">
    <div class="table-responsive">
        <table class="table no-margin">
            <thead>
            <tr>
            <tr>
                <th style="border:1px solid #dee2e6">Date</th>
                <th style="border:1px solid #dee2e6">Name</th>
                <th style="border:1px solid #dee2e6">Size <span style="font-size: 11px;color:#e11616;">(inches/liter/kg)</span></th>
                <th style="border:1px solid #dee2e6">Procurer</th>
                <th style="border:1px solid #dee2e6">CSD-1</th>
                <th style="border:1px solid #dee2e6">WB-1</th>
                <th style="border:1px solid #dee2e6">HB-1</th>
                <th style="border:1px solid #dee2e6">CSD-2</th>
                <th style="border:1px solid #dee2e6">WB-2</th>
                <th style="border:1px solid #dee2e6">HB-2</th>
                <th style="border:1px solid #dee2e6">CSD-3</th>
                <th style="border:1px solid #dee2e6">WB-3</th>
                <th style="border:1px solid #dee2e6">HB-3</th>
                <th style="border:1px solid #dee2e6">CSD-4</th>
                <th style="border:1px solid #dee2e6">WB-4</th>
                <th style="border:1px solid #dee2e6">HB-4</th>
                <th style="border:1px solid #dee2e6">CSD-5</th>
                <th style="border:1px solid #dee2e6">WB-5</th>
                <th style="border:1px solid #dee2e6">HB-5</th>
                <th style="border:1px solid #dee2e6">CSD-6</th>
                <th style="border:1px solid #dee2e6">WB-6</th>
                <th style="border:1px solid #dee2e6">HB-6</th>
                <th style="border:1px solid #dee2e6">Remaining</th>
            </tr>
            </tr>
            </thead>
            <tbody>
            <?php if( ! empty($products)) { ?>
                <?php $i = 1;?>
                <?php foreach($products as $inventory){


                    ?>
                    <tr>
                        <td style="border:1px solid #dee2e6"><?= $inventory->date?></td>
                        <td style="border:1px solid #dee2e6"><?= $inventory->name?></td>
                        <td style="border:1px solid #dee2e6"><?= $inventory->size?></td>
                        <td style="border:1px solid #dee2e6"><?= $inventory->procurer?></td>
                        <td style="border:1px solid #dee2e6"><?= $inventory->CSD_one?></td>
                        <td style="border:1px solid #dee2e6"><?= $inventory->WB_one?></td>
                        <td style="border:1px solid #dee2e6"><?= $inventory->HB_one?></td>
                        <td style="border:1px solid #dee2e6"><?= $inventory->CSD_two?></td>
                        <td style="border:1px solid #dee2e6"><?= $inventory->WB_two?></td>
                        <td style="border:1px solid #dee2e6"><?= $inventory->HB_two?></td>
                        <td style="border:1px solid #dee2e6"><?= $inventory->CSD_three?></td>
                        <td style="border:1px solid #dee2e6"><?= $inventory->WB_three?></td>
                        <td style="border:1px solid #dee2e6"><?= $inventory->HB_three?></td>
                        <td style="border:1px solid #dee2e6"><?= $inventory->CSD_four?></td>
                        <td style="border:1px solid #dee2e6"><?= $inventory->WB_four?></td>
                        <td style="border:1px solid #dee2e6"><?= $inventory->HB_four?></td>
                        <td style="border:1px solid #dee2e6"><?= $inventory->CSD_five?></td>
                        <td style="border:1px solid #dee2e6"><?= $inventory->WB_five?></td>
                        <td style="border:1px solid #dee2e6"><?= $inventory->HB_five?></td>
                        <td style="border:1px solid #dee2e6"><?= $inventory->CSD_six?></td>
                        <td style="border:1px solid #dee2e6"><?= $inventory->WB_six?></td>
                        <td style="border:1px solid #dee2e6"><?= $inventory->HB_six?></td>
                        <td style="border:1px solid #dee2e6"><?= $inventory->remaining?></td>
                    </tr>
                    <?php $i++;?>
                <?php } ?>
            <?php } else { ?>
                <tr><td colspan="8" class="no-records">No records</td></tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>
<div class="box-footer">
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