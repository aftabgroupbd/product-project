<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> <?php echo $page_title;?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('profile')?>">Back</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-6" style="margin: auto;">

            <div class="tile">
                <h3 class="tile-title">Single Product</h3>
                <div>
                    <p>Product Name : <span style="color: red"><?= $single_product->product_name?></span></p>
                    <p>Product Quantity : <span style="color: red"><?= $single_product->product_quantity?></span></p>
                    <p>Product Size : <span style="color: red"><?= $single_product->size?></span></p>
                    <p>Product Unit Price : <span style="color: red"><?= $single_product->unit_price?></span></p>
                    <p>Product Amount : <span style="color: red"><?= $single_product->amount?></span></p>
                    <p>Product Entry Date : <span style="color: red"><?= $single_product->entry_date?></span></p>
                    <p>Procurer Name : <span style="color: red"><?= $single_product->procurer_name?></span></p>
                    <p>Issue Name : <span style="color: red"><?= $single_product->issue_name?></span></p>
                    <p>Vendor Name : <span style="color: red"><?= $single_product->vendor_name?></span></p>
                </div>
            </div>
        </div>
        <!-- Edit Modal -->

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
<script type="text/javascript">$('#sampleTable').DataTable();</script>

<script type="text/javascript" src="<?= base_url('assets/js/plugins/sweetalert.min.js')?>"></script>

