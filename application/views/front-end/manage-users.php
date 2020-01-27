<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> <?php echo $page_title;?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('users')?>">Users</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-10" style="margin: auto;">
            <div style="text-align: center;"><?php if ($error = $this->session->flashdata('success_message')): ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="alert alert-success">
                                <?= $error;?>
                            </div>
                        </div>
                    </div>
                <?php endif;?></div>
            <div class="tile ">
                <div >
                    <h3 style="width: 45%;display: inline-block;" class="tile-title">users</h3>
                    <div style="width: 45%;text-align: right;display: inline-block;">

                        <a  href="<?= base_url('add-user')?>" class="btn btn-primary">Add user</a>
                    </div>

                </div>
                <div class="tile-body">
                    <div class="table-responsive" style="margin-top: 30px;" id="table_one_div">
                        <table class="table table-hover table-bordered"  id="table_one">
                            <thead>
                            <tr>
                                <th>User Name</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Activation</th>
                                <?php if ($userInfo['role'] == 'admin'){?>
                                <th>Action</th>
                                <?php }?>
                            </tr>
                            </thead>
                            <tbody id="showData">
                            <?php foreach ($all_users as $all_user){?>
                                <tr>
                                    <td><?= $all_user['username']?></td>
                                    <td><?= $all_user['first_name'].' '.$all_user['last_name']?></td>
                                    <td><?= $all_user['email']?></td>
                                    <td><?= $all_user['phone']?></td>
                                    <?php if ($all_user['active'] == 1){?>
                                        <td><a href="<?= base_url('deactivate-user/').$all_user['id']?>" class="btn btn-primary">Deactivate</a></td>
                                    <?php }?>
                                    <?php if ($all_user['active'] == 0){?>
                                    <td>
										<a href="<?= base_url('active-user/').$all_user['id']?>" class="btn btn-primary">Active</a>
										</td>
                                    <?php }?>
                                    <?php if ($userInfo['role'] == 'admin'){?>
                                    <td>
                                        <a href="<?= base_url('edit-user/').$all_user['id']?>" class="btn btn-primary">Edit</a>
                                        <a href="#" userId="<?php echo $all_user['id']?>" class="btn btn-primary delete-user">Delete</a>

                                    </td>
                                    <?php }?>
                                </tr>
                            <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div id="deleteModal" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>
                    <div class="modal-body">
                        <p>Are you sure delete this user?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" userid="" class="btn btn-default yseBtn" data-dismiss="modal">Yes</button>
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
    $(".delete-user").click(function () {

        $('#deleteModal').modal("show");
        var userId = $(this).attr('userId');
        $('.yseBtn').attr('userid',userId);
    });
    $(".yseBtn").click(function () {
        var userId = $(this).attr('userid');
        $.ajax({
            type: "POST",
            url: 'delete-user',
            data: {userId:userId},
            success: function(response) {
                $('#deleteModal').modal("hide");
                document.location.reload(true);
            }
        });
    });
</script>
<script type="text/javascript" src="<?= base_url('assets/js/plugins/jquery.dataTables.min.js')?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/plugins/dataTables.bootstrap.min.js')?>"></script>
<script type="text/javascript">$('#table_two').DataTable();</script>
<script type="text/javascript">$('#table_one').DataTable();</script>
