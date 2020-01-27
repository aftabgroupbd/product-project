<main class="app-content">
    <div class="app-title">
        <div>
            <h1><i class="fa fa-dashboard"></i> <?php echo $page_title;?></h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
            <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
            <li class="breadcrumb-item"><a href="<?php echo base_url('add-user')?>">add user</a></li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-6" style="margin: auto;">
            <div class="tile">
                <h3 class="tile-title">Add user</h3>
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
                    <form class="form-horizontal" action="<?= base_url('add-user')?>" method="post" enctype="multipart/form-data">
                        <div class="form-group row">
                                <label class="control-label col-md-4">First name</label>
                                <div class="col-md-8">
                                    <input class="form-control" autocomplete="off" type="text" name="first_name" placeholder="Enter first name">
                                </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-4">Last name</label>
                            <div class="col-md-8">
                                <input class="form-control" autocomplete="off" type="text" name="last_name" placeholder="Enter last name">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="control-label col-md-4">Email</label>
                            <div class="col-md-8">
                                <input class="form-control" autocomplete="off" type="email" name="email" placeholder="Enter email">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-4">Phone</label>
                            <div class="col-md-8">
                                <input class="form-control" autocomplete="off" type="number" name="phone" placeholder="Enter phone">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="control-label col-md-4">Username</label>
                            <div class="col-md-8">
                                <input class="form-control" autocomplete="off" type="text" name="username" placeholder="username">
                            </div>
                        </div>
						<div class="form-group row">
							<label class="control-label col-md-4">User role</label>
							<div class="col-md-8">
								<select class="form-control form-control-sm" name="user_role">
									<option value="admin">Admin</option>
									<option value="editor">Editor</option>
									<option value="member">Member</option>
								</select>
							</div>
						</div>
                        <div class="tile-footer">
                            <div class="row">
                                <div class="col-md-12" style="text-align: right">
                                    <input class="btn btn-primary" type="submit" name="user_btn" value="Submit">
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
