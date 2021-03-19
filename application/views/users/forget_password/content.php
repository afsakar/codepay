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
                    <h2 class="h5 font-w400 text-muted mb-0"><?=trans("fp_welcome_title")?></h2>
                </div>
                <!-- END Header -->

                <!-- Sign In Form -->
                <!-- jQuery Validation functionality is initialized with .js-validation-signin class in js/pages/op_auth_signin.min.js which was auto compiled from _es6/pages/op_auth_signin.js -->
                <!-- For more examples you can check out https://github.com/jzaefferer/jquery-validation -->
                <form action="<?=base_url('usersop/reset_password')?>" method="post">
                    <div class="block block-themed block-rounded block-shadow">
                        <div class="block-header bg-gd-primary">
                            <h3 class="block-title"><?=trans("forgot_password")?></h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option">
                                    <i class="si si-wrench"></i>
                                </button>
                            </div>
                        </div>
                        <div class="block-content">
                            <div class="form-group row">
                                <div class="col-12">
                                    <label for="reminder-credential"><?=trans("email")?></label>
                                    <input type="text" class="form-control" required id="reminder-credential" name="email" value="<?php if (isset($form_error)){ echo set_value('user_email'); }elseif($remember_me){echo $member->email;} ?>">
                                </div>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" class="btn btn-alt-primary">
                                    <i class="fa fa-asterisk mr-10"></i> <?=trans("reset_password")?>
                                </button>
                            </div>
                        </div>
                        <div class="block-content bg-body-light">
                            <div class="form-group text-center">
                                <a class="link-effect text-muted mr-10 mb-5 d-inline-block" href="<?=base_url("login")?>">
                                    <i class="si si-login text-muted mr-5"></i> <?=trans("login")?>
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