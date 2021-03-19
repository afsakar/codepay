<div class="content">
    <h2 class="content-heading"><?=$title?>
        <a href="<?=base_url("users")?>" class="btn btn-alt-primary btn-sm pull-right">
            <i class="fa fa-arrow-left"></i> <?=trans("back")?>
        </a>
    </h2>
    <?=$breadcrumbs?>
    <!-- Full Table -->
    <div class="block">
        <div class="block-content">
            <div class="col-md-8 offset-md-2">
                <form action="<?=base_url("users/addItem")?>" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label><?=trans("user_name")?></label>
                            <input type="text" class="form-control" name="user_name" value="<?php if (isset($formError)){ echo set_value('user_name'); } ?>">
                            <?php if(isset($formError)): ?>
                                <div class="form-text text-danger"><?=form_error('user_name')?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label><?=trans("name_surname")?></label>
                            <input type="text" class="form-control" name="full_name" value="<?php if (isset($formError)){ echo set_value('full_name'); } ?>">
                            <?php if(isset($formError)): ?>
                                <div class="form-text text-danger"><?=form_error('full_name')?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label><?=trans("avatar")?></label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" name="img_url" data-toggle="custom-file-input">
                                <label class="custom-file-label" for="example-file-input-custom"><?=trans("select_image")?></label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label><?=trans("permission")?></label>
                            <select class="js-select2 form-control form-control-lg" id="example-select2" name="user_type" style="width: 100%;" data-placeholder="Yetki seçin..">
                                <option value="user" <?php if(isset($formError) && set_value('user_type') == "user"){echo "selected"; }else{ echo ""; } ?>><?=trans("user")?></option>
                                <option value="admin" <?php if(isset($formError) && set_value('user_type') == "admin"){echo "selected"; }else{ echo ""; } ?>><?=trans("admin")?></option>
                                <option value="superadmin" <?php if(isset($formError) && set_value('user_type') == "superadmin"){echo "selected"; }else{ echo ""; } ?>><?=trans("superadmin")?></option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label><?=trans("email")?></label>
                            <input type="text" class="form-control" name="email" value="<?php if (isset($formError)){ echo set_value('email'); } ?>">
                            <?php if(isset($formError)): ?>
                                <div class="form-text text-danger"><?=form_error('email')?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label><?=trans("password")?></label>
                            <input type="password" class="form-control" name="password" value="<?php if (isset($formError)){ echo set_value('password'); } ?>">
                            <?php if(isset($formError)): ?>
                                <div class="form-text text-danger"><?=form_error('password')?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label><?=trans("re_password")?></label>
                            <input type="password" class="form-control" name="re_password" value="<?php if (isset($formError)){ echo set_value('re_password'); } ?>">
                            <?php if(isset($formError)): ?>
                                <div class="form-text text-danger"><?=form_error('re_password')?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-alt-primary"><i class="fa fa-save"></i> <?=trans("save")?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END Full Table -->

</div>