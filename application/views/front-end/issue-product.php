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
                <div class="tile-body">
                    <table style="margin: auto;">
<!--                        <th><a class="btn btn-primary" id="only_date" style="color: #fff">Only Date</a></th>-->
                        <th><a class="btn btn-primary" id="procurer_entry" style="color: #fff">Only Procurer</a></th>
                        <th><a class="btn btn-primary" id="issue_entry" style="color: #fff">Only Issue</a></th>
                        <th><a class="btn btn-primary" id="vendor_product" style="color: #fff">Only Vendor</a></th>
                    </table>
                    <div id="table_one">
                        <h4>Product</h4>
                        <table class="table table-hover" style="margin-top: 30px;" id="issue_table_one">
                            <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Amount</th>
                                <th>Date of product</th>
                                <th>Procurer Name</th>
                                <th>Vendor Name</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="showData">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="tile-body" style="margin-top: 30px;display: none;" id="table_two">
                    <h4>Issue Product</h4>
                    <table class="table table-hover" style="margin-top: 30px;" id="issue_table_two">
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
                        <tbody id="showIssueData">

                        </tbody>
                    </table>
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
                <div class="modal fade" id="search_vendor_modal" tabindex="10" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Search Entry By vendor</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="tile-body">
                                    <form class="form-horizontal" id="search_vendor_form">
                                        <div class="form-group row">
                                            <label class="control-label col-md-3">Select Query</label>
                                            <div class="col-md-8">
                                                <select class="form-control form-control-sm" name="query_vendor" id="show_vendor_name">

                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" id="vendor_query_btn" class="btn btn-primary">Query</button>
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
<script>
    $(document).ready(function(){
            $.ajax({
                type: 'ajax',
                method: 'post',
                url: '<?php echo base_url("show-vendor-name") ?>',
                async: false,
                dataType: 'json',
                success: function(data){
                    var html = '';
                    var i;
                    for(i=0; i<data.length; i++){
                        html +='<option value="'+data[i].vendor_name+'">'+data[i].vendor_name+'</option>';
                    }
                    $('#show_vendor_name').html(html);
                },
                error: function(){
                    alert('Could not get Data from Database');
                }
            });
        $("#issue_entry").click(function () {
            $("#table_one").hide();
            $("#table_two").show();
            showTwoTypeData(2,'showIssueData');
        });
        showTwoTypeData(1,'showData');
        function showTwoTypeData(id,table) {

            $.ajax({
                type: 'ajax',
                method: 'post',
                url: '<?php echo base_url("show-two-type-data") ?>',
                async: false,
                data:{id:id},
                dataType: 'json',
                success: function(data){
                    if (table == 'showData'){
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
                                '<td><button type="button" class="btn btn-danger item-delete" data="'+data[i].id+'"><i class="fa fa-trash" aria-hidden="true"></i></button></td>'+
                                '</tr>';
                        }
                        $('#showData').html(html);
                    }
                    if (table == 'showIssueData')
                    {
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
                        $('#showIssueData').html(html);
                    }

                },
                error: function(){
                    alert('Could not get Data from Database');
                }
            });
        }

    });
</script>
<script>
    $("#procurer_entry").click(function () {
        var procurer_entry = 1;
        showAllEntity(procurer_entry);
    });

    $("#vendor_product").click(function () {
        $("#search_vendor_modal").modal('show');
    });
    $("#vendor_query_btn").click(function () {
        var issue_entry = 3;
        var entryData = $("#show_vendor_name").val();
        showAllEntity(issue_entry,entryData);
    });
    function showAllEntity(id,entryData=''){

        $.ajax({
            type: 'ajax',
            method: 'post',
            url: '<?php echo base_url("show-entry") ?>',
            data:{id:id,entryData:entryData},
            async: false,
            dataType: 'json',
            success: function(data){
                $("#table_one").show();
                $("#table_two").hide();
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
                        '<td><button type="button" class="btn btn-danger item-delete" data="'+data[i].id+'"><i class="fa fa-trash" aria-hidden="true"></i></button></td>'+
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
                $("#table_one").show();
                $("#table_two").hide();
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
                        '<td><button type="button" class="btn btn-danger item-delete" data="'+data[i].id+'"><i class="fa fa-trash" aria-hidden="true"></i></button></td>'+
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
<script>
    $('#showData').on('click', '.item-delete', function(){
        var id = $(this).attr('data');
            $.ajax({
                type: 'ajax',
                method: 'get',
                async: false,
                url: '<?php echo base_url("delete-entry") ?>',
                data:{id:id},
                dataType: 'json',
                success: function(response){
                    swal({
                        title: "Deleted Successfully",
                        text: "You have successfully Deleted.",
                        type: "success",
                        showCancelButton: true,
                        closeOnConfirm: false,
                        closeOnCancel: false
                    });
                    document.location.reload(true);
                },
                error: function(data){
                    console.log(data);
                    //$('#deleteModal').modal('hide');
                    //alert('Error deleting');
                }
            });
    });
</script>