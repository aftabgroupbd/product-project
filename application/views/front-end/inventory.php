<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> <?php echo $page_title;?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('inventory')?>">inventory</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12" style="margin: auto;">
            <div class="tile">
                <h3 class="tile-title">Product Inventory</h3>
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
            var base_url = '<?php echo site_url('DashboardController/inventory_ajax/') ?>';

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