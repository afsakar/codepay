<div class="content">
    <h2 class="content-heading"><?=$title?>
        <a href="<?=base_url("email_settings")?>" class="btn btn-alt-primary btn-sm pull-right">
            <i class="fa fa-arrow-left"></i> <?=trans("back")?>
        </a>
    </h2>
    <?=$breadcrumbs?>
    <!-- Full Table -->
    <div class="block">
        <div class="block-content">
            <div class="col-md-8 offset-md-2">
                <form action="<?=base_url("email_settings/addItem")?>" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label><?=trans("port")?></label>
                            <input type="number" class="form-control" name="port" value="<?php if (isset($form_error)){ echo set_value('port'); } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('port')?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label><?=trans("protocol")?></label>
                            <select class="js-select2 form-control form-control-lg" id="example-select2" name="protocol" style="width: 100%;">
                                <option value="smtp" <?php if(isset($form_error) && set_value('protocol') == "smtp"){echo "selected"; }else{ echo ""; } ?>>SMTP</option>
                                <option value="tls" <?php if(isset($form_error) && set_value('protocol') == "tls"){echo "selected"; }else{ echo ""; } ?>>TLS</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label><?=trans("host")?></label>
                            <input type="text" class="form-control" name="host" value="<?php if (isset($form_error)){ echo set_value('host'); } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('host')?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label><?=trans("email_title")?></label>
                            <input type="text" class="form-control" name="user_name" value="<?php if (isset($form_error)){ echo set_value('user_name'); } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('user_name')?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label><?=trans("email")?></label>
                            <input type="email" class="form-control" name="user" value="<?php if (isset($form_error)){ echo set_value('user'); } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('user')?></div>
                            <?php endif; ?>
                        </div>
                    </div>
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
                        <div class="col-md-6">
                            <label><?=trans("to")?></label>
                            <input type="text" class="form-control" name="to" value="<?php if (isset($form_error)){ echo set_value('to'); } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('to')?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label><?=trans("from")?></label>
                            <input type="text" class="form-control" name="from" value="<?php if (isset($form_error)){ echo set_value('from'); } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('from')?></div>
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