<div class="login-box">
            <!--  <img class="mb-4" src="https://getbootstrap.com/docs/4.0/assets/brand/bootstrap-solid.svg" alt="" width="72" height="72">
             -->

            <?php echo form_open("auth/login");?>
    <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h3>

    <small id="infoMessage" class="form-text text-danger text-center"><?php echo $message;?></small>

            <div>
                <?php echo lang('login_identity_label', 'identity');?>
            </div>
            <div>
                <?php echo form_input($identity);?>
            </div>

            <div>
                <?php echo lang('login_password_label', 'password');?>

            </div>
            <div>
                <?php echo form_input($password);?>
            </div>

            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember" value="1">
                <label class="form-check-label" for="exampleCheck1">Remember Me</label>
            </div>

            <button class="btn btn-primary btn-block mt-2" type="submit" name="submit" value="Login">Log in</button>

            <?php echo form_close();?>
<!--            <p class="text-center"><a href="forgot_password">--><?php //echo lang('login_forgot_password');?><!--</a></p>-->
</div>


