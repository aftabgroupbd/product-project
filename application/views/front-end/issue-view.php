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
        <div class="col-md-11" style="margin: auto;background: #fff">
            <h3 style="padding-left: 20px;padding-top: 30px;" class="tile-title">Product Issue</h3>
            <div class="text-center" id="message_show"></div>
            <form id="issue_form" class="form-horizontal">

            <div class="tile row">

                <div class="col-md-6">
                    <div class="tile-body">
                          <div class="form-group row">
                                <label class="control-label col-md-3">product Name</label>
                                <div class="col-md-8">
                                    <input class="form-control issue_search" required type="text" name="product_name" placeholder="Enter product name">
                                    <input class="form-control " id="product_id" type="hidden" name="product_id" value="0">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Product Size</label>
                                <div class="col-md-8">
                                    <input class="form-control issue_search" required autocomplete="off" type="text" name="product_size" placeholder="Enter product size">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Quantity</label>
                                <div class="col-md-8">
                                    <input class="form-control" autocomplete="off" required type="text" id="quantity" name="product_quantity" placeholder="Enter product Quantity">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3">Issue name</label>
                                <div class="col-md-8">
                                    <input class="form-control" autocomplete="off" required type="text"  name="issue_name" placeholder="Enter issuer name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="control-label col-md-3" for="exampleSelect1">Issue To</label>
                                <div class="col-md-8">
                                    <select class="form-control" id="exampleSelect1" name="issue_type" required>
                                        <option value="CSD_one">CSD - 1 </option>
                                        <option value="WB_one">WB - 1</option>
                                        <option value="HB_one">HB - 1</option>
                                        <option value="CSD_two">CSD - 2</option>
                                        <option value="WB_two">WB - 2</option>
                                        <option value="HB_two">HB - 2</option>
                                        <option value="CSD_three">CSD - 3</option>
                                        <option value="WB_three">WB - 3</option>
                                        <option value="HB_three">HB - 3</option>
                                        <option value="CSD_four">CSD - 4</option>
                                        <option value="WB_four">WB - 4</option>
                                        <option value="HB_four">HB - 4</option>
                                        <option value="CSD_five">CSD - 5</option>
                                        <option value="WB_five">WB - 5</option>
                                        <option value="HB_five">HB - 5</option>
                                        <option value="CSD_six">CSD - 6</option>
                                        <option value="WB_six">WB - 6</option>
                                        <option value="HB_six">HB - 6</option>
                                    </select>
                                </div>
                            </div>
                            <div class="tile-footer" style="border: none;">
                                <div class="row">
                                    <div class="col-md-8 col-md-offset-3">
                                        <button class="btn btn-primary" id="issue_btn" type="button"  name="product_btn">Submit</button>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Size</th>
<!--                            <th scope="col">Action</th>-->
                        </tr>
                        </thead>
                        <tbody id="issue_table">

                        </tbody>
                    </table>
                </div>
            </div>
            </form>
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
    $(".issue_search").change(function(){
        var form = $("#issue_form");
        $.ajax({
            type: 'ajax',
            method: 'POST',
            url: '<?php echo base_url('search-issue')?>',
            data: form.serialize(),
            async: false,
            dataType: 'json',
            success: function(data){
                console.log(data.product);
                var html = '';
                var i;
                var sl ;
                for(i=0; i<data.product.length; i++)
                {
                    sl = i+1;
                    var pId = data.product[i].id;
                    html +='<tr>'+

                        '<td>'+sl+'</td>'+
                        '<td>'+data.product[i].product_name+'</td>'+
                        '<td>'+data.product[i].total_quantity+'</td>'+
                        '<td>'+data.product[i].size+'</td>'+
                        // '<td><input class="form-check-input" type="radio" name="product_id"  value="'+data.product[i].id+'" ></td>'+
                        '</tr>';
                    $("#product_id").val(pId);
                }
                $('#issue_table').html(html);
            },
            error: function(){
                alert('Could not add data');
            }
        });
    });


</script>
<script>

    $("#issue_btn").click(function () {
        var form = $("#issue_form");
        $.ajax({
            type: 'ajax',
            method: 'POST',
            url: '<?php echo base_url('quantity_issue')?>',
            data: form.serialize(),
            async: false,
            dataType: 'json',
            success: function(data){
                $("#message_show").html(data.msg);
                $("#issue_form")[0].reset();
                window.location = "issue-product-list";
            },
            error: function(){
                alert('Could not add data');
            }
        });
    });

</script>
