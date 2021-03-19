<div class="content">
    <h2 class="content-heading"><?=$title?> (<?=$item->user_name?>)
        <a href="<?=base_url("users")?>" class="btn btn-alt-primary btn-sm pull-right">
            <i class="fa fa-arrow-left"></i> <?=trans("back")?>
        </a>
    </h2>
    <?=$breadcrumbs?>
    <!-- Full Table -->
    <div class="block">
        <div class="block-content">
            <div class="col-md-8 offset-md-2">
                <form action="<?=base_url("users/updatePassword/$item->id")?>" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label><?=trans("password")?></label>
                            <input type="password" class="form-control" name="password" value="<?php if (isset($form_error)){ echo set_value('password'); } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('password')?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label><?=trans("re_password")?></label>
                            <input type="password" class="form-control" name="re_password" value="<?php if (isset($form_error)){ echo set_value('re_password'); } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('re_password')?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-alt-primary"><i class="fa fa-save"></i> <?=trans("update")?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END Full Table -->

</div>