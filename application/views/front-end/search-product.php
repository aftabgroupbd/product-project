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
        <div class="col-md-10" style="margin: auto;">
            <div class="tile">
                <h3 class="tile-title">Search Product</h3>
                <div class="tile-body">
                    <table style="margin: auto;">
                        <th><a class="btn btn-primary" id="only_date" style="color: #fff">Only Date</a></th>
                        <th><a class="btn btn-primary" id="procurer_entry" style="color: #fff">Only Procurer</a></th>
                        <th><a class="btn btn-primary" id="issue_entry" style="color: #fff">Only Issue</a></th>
                        <th><a class="btn btn-primary" id="vendor" style="color: #fff">Only Vendor</a></th>
                    </table>

                    <div class="table-responsive" style="margin-top: 30px;" id="table_one_div">
                    <table class="table table-hover table-bordered"  id="table_one">
                        <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Amount</th>
                            <th>Date of product</th>
                            <th>Procurer Name</th>
                            <th>Vendor Name</th>
                        </tr>
                        </thead>
                        <tbody id="showData">

                        </tbody>
                    </table>
                    </div>
                    <div class="table-responsive" style="margin-top: 30px;display: none;" id="table_two_div">
                        <table class="table table-hover table-bordered" id="table_two">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Vendor Name</th>
                        </tr>
                        </thead>
                        <tbody id="showVendorData">

                        </tbody>
                    </table>

                 </div>
                </div>

                <div class="modal fade" id="search_date_modal" tabindex="10" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Search Entry By date</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="tile-body">
                                    <form class="form-horizontal" id="search_date_form">
                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Date of product</label>
                                            <div class="col-md-8">
                                                <input class="form-control" autocomplete="off" type="text" id="entry_date" name="entry_date" placeholder="Product Entry date" >
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Select Query</label>
                                            <div class="col-md-8">
                                            <select class="form-control form-control-sm" name="query_init">
                                                <option value="1">Equal</option>
                                                <option value="2">Not Equal</option>
                                                <option value="3">Greater Then</option>
                                                <option value="4">Less Then</option>
                                            </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" id="query_btn" class="btn btn-primary">Query</button>
                            </div>
                        </div>
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
<script type="text/javascript">$('#table_two').DataTable();</script>
<script type="text/javascript">$('#table_one').DataTable();</script>
<script>
    $("#procurer_entry").click(function () {
        var procurer_entry = 1;
        showAllEntity(procurer_entry);
    });
    $("#issue_entry").click(function () {
        var issue_entry = 2;
        showAllEntity(issue_entry);
    });
    $("#vendor").click(function () {
        showAllVendor();
    });


    function showAllVendor() {
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: '<?php echo base_url("show-vendor") ?>',
            async: false,
            dataType: 'json',
            success: function(data){
                $("#table_one_div").hide();
                $("#table_two_div").show();
                var html = '';
                var i;
                for(i=0; i<data.length; i++){
                    html +='<tr>'+
                        '<td>'+data[i].id+'</td>'+
                        '<td>'+data[i].vendor_name+'</td>'+
                        '</tr>';
                }
                $('#showVendorData').html(html);
            },
            error: function(){
                alert('Could not get Data from Database');
            }
        });
    }
    function showAllEntity(id){
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: '<?php echo base_url("show-entry") ?>',
            data:{id:id},
            async: false,
            dataType: 'json',
            success: function(data){
                $("#table_one_div").show();
                $("#table_two_div").hide();
                var html = '';
                var i;
                for(i=0; i<data.length; i++){
                    html +='<tr>'+

                        '<td>'+data[i].product_name+'</td>'+
                        '<td>'+data[i].product_quantity+'</td>'+
                        '<td>'+data[i].unit_price+'</td>'+
                        '<td>'+data[i].amount+'</td>'+
                        '<td>'+data[i].entry_date+'</td>'+
                        '<td>'+data[i].procurer_name+'</td>'+
                        '<td>'+data[i].vendor_name+'</td>'+
                        '</tr>';
                }

                $('#showData').html(html);
            },
            error: function(){
                alert('Could not get Data from Database');
            }
        });
    };
    $("#only_date").click(function () {
        $("#search_date_modal").modal('show');
    });
    $("#query_btn").click(function () {
        var data = $('#search_date_form').serialize();

        $.ajax({
            type: 'ajax',
            method: 'POST',
            url: '<?php echo base_url('entry-by-date')?>',
            data: data,
            async: false,
            dataType: 'json',
            success: function(data){
                // swal('Message',data,'success');
                $("#search_date_modal").modal('hide');
                $('#search_date_form')[0].reset();
                $("#table_one_div").show();
                $("#table_two_div").hide();
                var html = '';
                var i;
                for(i=0; i<data.length; i++){
                    html +='<tr>'+

                        '<td>'+data[i].product_name+'</td>'+
                        '<td>'+data[i].product_quantity+'</td>'+
                        '<td>'+data[i].unit_price+'</td>'+
                        '<td>'+data[i].amount+'</td>'+
                        '<td>'+data[i].entry_date+'</td>'+
                        '<td>'+data[i].procurer_name+'</td>'+
                        '<td>'+data[i].vendor_name+'</td>'+
                        '</tr>';
                }

                $('#showData').html(html);
            },
            error: function(){
                alert('Could not add data');
            }
        });
    });


</script>