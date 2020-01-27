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
        <div class="col-md-8" style="margin: auto;">
            <div class="tile">
                <h3 class="tile-title">Product Entry</h3>
                <div style="text-align: center;">  <?php echo validation_errors(); ?> </div>
                <?php if ($error = $this->session->flashdata('success_message')): ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="alert alert-success">
                                <?= $error;?>
                            </div>
                        </div>
                    </div>
                <?php endif;?>
                <div class="tile-body">
                    <form class="form-horizontal" action="<?= base_url('product-entry')?>" method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label class="control-label col-md-3">product Name</label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" name="product_name" placeholder="Enter product name">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-3">Product Size <span style="font-size: 11px;color:#e11616;">(inches/liter/kg)</label>
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
                        <div class="form-group row">
                            <label class="control-label col-md-3">JPG/PDF</label>
                            <div class="col-md-8">
                                <input class="form-control" type="file" name="product_file" />
                            </div>
                        </div>
                        <div class="tile-footer">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-3">
                                    <input class="btn btn-primary" type="submit" name="product_btn" value="Submit">
                                </div>
                            </div>
                        </div>
                    </form>
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