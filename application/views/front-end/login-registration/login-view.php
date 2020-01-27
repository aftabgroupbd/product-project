<div class="login-box">
<form class="login-form" id="loginForm">
    <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>SIGN IN</h3>
    <div class="form-group">
        <label class="control-label">USERNAME</label>
        <input class="form-control" type="text" placeholder="Email" autofocus name="username">
        <span class="username"></span>
    </div>
    <div class="form-group">
        <label class="control-label">PASSWORD</label>
        <input class="form-control" type="password" placeholder="Password" name="password">
        <input type="hidden" name="login">
        <span class="password"></span>
    </div>
    <div class="form-group">
        <div class="utility">
            <div class="animated-checkbox">
                <label>
                    <input type="checkbox"><span class="label-text">Stay Signed in</span>
                </label>
            </div>
            <p class="semibold-text mb-2"><a href="#" data-toggle="flip">Forgot Password ?</a></p>
        </div>
    </div>
    <div class="form-group btn-container">
        <button class="btn btn-primary btn-block" id="sign_in"><i class="fa fa-sign-in fa-lg fa-fw"></i>SIGN IN</button>
    </div>
</form>
<form class="forget-form" action="index.html">
    <h3 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>Forgot Password ?</h3>
    <div class="form-group">
        <label class="control-label">EMAIL</label>
        <input class="form-control" type="text" placeholder="Email">
    </div>
    <div class="form-group btn-container">
        <button class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>RESET</button>
    </div>
    <div class="form-group mt-3">
        <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Back to Login</a></p>
    </div>
</form>
</div>
<script>
    $("#sign_in").click(function (event) {
        event.preventDefault();
        var loginInfo = $('#loginForm').serialize();
        $.ajax(
            {
                method:'POST',
                data:loginInfo,
                url:'login',
                dataType: 'json',
                success:function (data) {
                    console.log(data);
                    if (data.msg)
                    {
                        $.each(data.msg, function(key,val) {
                            $('.'+key).text(val).css({"display":"block","color":"red"}).fadeOut(5000);
                        });
                        $('#loginForm')[0].reset();
                    }
                }
            });
    });
</script>