<?php
$remember_me = get_cookie("remember_me");
if($remember_me){
    $member = json_decode($remember_me);
}
?>
<!-- Page Content -->
<div class="bg-body-dark bg-pattern" style="background-image: url('assets/media/various/bg-pattern-inverse.png');">
    <div class="row mx-0 justify-content-center">
        <div class="hero-static col-lg-6 col-xl-4">
            <div class="content content-full overflow-hidden">
                <!-- Header -->
                <div class="py-30 text-center">
                    <img src="<?=logo("logo")?>" class="img-fluid-100 w-50 mb-0" alt="">
                    <h1 class="h4 font-w700 mt-30 mb-10"><?=settings("title")?></h1>
                    <h2 class="h5 font-w400 text-muted mb-0"><?=trans("login_welcome_title")?></h2>
                </div>
                <!-- END Header -->

                <!-- Sign In Form -->
                <!-- jQuery Validation functionality is initialized with .js-validation-signin class in js/pages/op_auth_signin.min.js which was auto compiled from _es6/pages/op_auth_signin.js -->
                <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                <form action="<?=base_url('usersop/doLogin')?>" method="post">
                    <div class="block block-themed block-rounded block-shadow">
                        <div class="block-header bg-gd-primary">
                            <h3 class="block-title"><?=trans("login_welcome_subtitle")?></h3>
                        </div>
                        <div class="block-content">
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="login-username"><?=trans("email")?></label>
                                    <input type="email" class="form-control" id="login-username" name="user_email" placeholder="<?=trans("enter_email")?>" value="<?php if (isset($form_error)){ echo set_value('user_email'); }elseif($remember_me){echo $member->email;} ?>">
                                    <span class="text-danger"><?=form_error('user_email')?></span>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="login-password"><?=trans("password")?></label>
                                    <input type="password" class="form-control" id="login-password" name="user_password" placeholder="<?=trans("enter_password")?>">
                                    <span class="text-danger"><?=form_error('user_password')?></span>
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-sm-6 d-sm-flex align-items-center push">
                                    <div class="custom-control custom-checkbox mr-auto ml-0 mb-0">
                                        <input type="checkbox" class="custom-control-input" id="login-remember-me" name="remember_me" <?php if($remember_me) { echo "checked"; }else{ echo ""; }?>>
                                        <label class="custom-control-label" for="login-remember-me"><?=trans("remember_me")?></label>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-sm-right push">
                                    <button type="submit" class="btn btn-alt-primary">
                                        <i class="si si-login mr-10"></i> <?=trans("login")?>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="block-content bg-body-light">
                            <div class="form-group text-center">
                                <!-- <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="op_auth_signup3.html">
                                    <i class="fa fa-plus mr-5"></i> Yeni hesap oluştur
                                </a> -->
                                <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="<?=base_url("forget_password")?>">
                                    <i class="fa fa-warning mr-5"></i> <?=trans("forgot_password")?>
                                </a>
                            </div>
                        </div>
                    </div>
                </form>
                <!-- END Sign In Form -->
            </div>
        </div>
    </div>
</div>
<!-- END Page Content -->