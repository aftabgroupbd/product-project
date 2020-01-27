<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> <?php echo $page_title;?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('product-entry')?>">Product Entry</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12" style="margin: auto;">
            <?php if ($error = $this->session->flashdata('success_message')): ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="alert alert-success">
                            <?= $error;?>
                        </div>
                    </div>
                </div>
            <?php endif;?>
            <div class="tile">
                <h3 class="tile-title">Product List</h3>
                <div class="container">
                    <div class="row">
                        <div class="col-md-4">

                        </div>
                        <div class="col-md-8">
                            <div class="row" style="margin-bottom: 20px;">
                                <div class="col-md-8">
                                    <div class="search-field">
                                        <input type="text" class="form-control" name="search_key" id="search_key" placeholder="Search by product name" />
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="search-button">
                                        <button type="button" id="searchBtn" class="btn btn-info">Search</button>
                                        <button type="button" id="resetBtn" class="btn btn-warning">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div id="ajaxContent"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Edit Modal -->
        <div class="modal fade" id="EditModal" tabindex="10" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="tile-body">
                            <form class="form-horizontal" id="editForm" action="" method="post" enctype="multipart/form-data">
                                <div class="form-group row">
                                    <label class="control-label col-md-3">product Name</label>
                                    <div class="col-md-8">
                                        <input class="form-control" autocomplete="off" type="text" name="product_name" placeholder="Enter product name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3">Product Size<span style="font-size: 11px;color:#e11616;">(inches/liter/kg)</span></label>
                                    <div class="col-md-8">
                                        <input class="form-control" autocomplete="off" type="number" name="product_size" placeholder="Enter product size">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3">Quantity</label>
                                    <div class="col-md-8">
                                        <input class="form-control" autocomplete="off" type="number" id="quantity" name="product_quantity" placeholder="Enter product Quantity">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3">Unit Price</label>
                                    <div class="col-md-8">
                                        <input class="form-control" autocomplete="off" type="number" id="unit_price" name="unit_price" placeholder="Enter unit price">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3">Amount</label>
                                    <div class="col-md-8">
                                        <input class="form-control" autocomplete="off" type="number" name="amount" id="amount">
                                        <input   type="hidden" name="entry_id">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3">Date of product</label>
                                    <div class="col-md-8">
                                        <input class="form-control" autocomplete="off" type="text" id="entry_date" name="entry_date" placeholder="Product Entry date" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3">Procurer Name</label>
                                    <div class="col-md-8">
                                        <input class="form-control" autocomplete="off" type="text" name="procurer_name" placeholder="Enter Procurer name" >
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="control-label col-md-3">Vendor Name</label>
                                    <div class="col-md-8">
                                        <input class="form-control" autocomplete="off" type="text" name="vendor_name" placeholder="Enter vendor name" >
                                    </div>
                                </div>
<!--                                <div class="form-group row">-->
<!--                                    <label class="control-label col-md-3">JPG/PDF</label>-->
<!--                                    <div class="col-md-8">-->
<!--                                        <input class="form-control" type="file" name="product_file" />-->
<!--                                    </div>-->
<!--                                </div>-->
                            </form>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" id="update_btn" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
<script type="text/javascript" src="<?= base_url('assets/js/plugins/bootstrap-datepicker.min.js')?>"></script>
<script>
    $('#entry_date').datepicker({
        format: "dd/mm/yyyy",
        autoclose: true,
        todayHighlight: true
    });
</script>
<script type="text/javascript" src="<?= base_url('assets/js/plugins/jquery.dataTables.min.js')?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/plugins/dataTables.bootstrap.min.js')?>"></script>
<!--<script type="text/javascript">$('#sampleTable').DataTable();</script>-->
<script>
    var quantity;
    var unit_price;
    $("#quantity").change(function(){
        quantity = parseInt($("#quantity").val());
        $("#amount").val(quantity);
    });
    $("#unit_price").change(function(){
        quantity = parseInt($("#amount").val());
        unit_price = parseInt($("#unit_price").val());
        var amount = quantity*unit_price;
        $("#amount").val(amount);
    });

</script>
<script type="text/javascript" src="<?= base_url('assets/js/plugins/sweetalert.min.js')?>"></script>
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
<script>

    $(function() {

        /*--first time load--*/
        ajaxlist(page_url=false);

        /*-- Search keyword--*/
        $(document).on('click', "#searchBtn", function(event) {
            ajaxlist(page_url=false);
            event.preventDefault();
        });

        /*-- Reset Search--*/
        $(document).on('click', "#resetBtn", function(event) {
            $("#search_key").val('');
            ajaxlist(page_url=false);
            event.preventDefault();
        });

        /*-- Page click --*/
        $(document).on('click', ".pagination li a", function(event) {
            var page_url = $(this).attr('href');
            ajaxlist(page_url);
            event.preventDefault();
        });

        /*-- create function ajaxlist --*/
        function ajaxlist(page_url = false)
        {
            var search_key = $("#search_key").val();

            var dataString = 'search_key=' + search_key;
            var base_url = '<?php echo site_url('DashboardController/index_ajax/') ?>';

            if(page_url == false) {
                var page_url = base_url;
            }

            $.ajax({
                type: "POST",
                url: page_url,
                data: dataString,
                success: function(response) {
                    console.log(response);
                    $("#ajaxContent").html(response);
                }
            });
        }
    });
</script>