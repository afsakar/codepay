<div class="content">
    <h2 class="content-heading"><?=$title?>
        <a href="<?=base_url("services")?>" class="btn btn-alt-primary btn-sm pull-right">
            <i class="fa fa-arrow-left"></i> <?=trans("back")?>
        </a>
    </h2>
    <?=$breadcrumbs?>
    <!-- Full Table -->
    <div class="block">
        <div class="block-content">
            <div class="col-md-8 offset-md-2">
                <form action="<?=base_url("services/addItem")?>" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label><?=trans("title")?></label>
                            <input type="text" class="form-control" name="sr_name" value="<?php if (isset($form_error)){ echo set_value('sr_name'); } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('sr_name')?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label><?=trans("service_code")?></label>
                            <input type="text" class="form-control" name="sr_code" value="<?php if (isset($form_error)){ echo set_value('sr_code'); } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('sr_code')?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label><?=trans("amount")?></label>
                            <input type="text" class="form-control" name="sr_amount" value="<?php if (isset($form_error)){ echo set_value('sr_amount'); } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('sr_amount')?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label><?=trans("tax")?></label>
                            <input type="text" class="form-control" name="sr_price" value="<?php if (isset($form_error)){ echo set_value('sr_price'); } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('sr_price')?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label><?=trans("unit")?></label>
                            <input type="text" class="form-control" name="sr_unit" value="<?php if (isset($form_error)){ echo set_value('sr_unit'); } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('sr_unit')?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label><?=trans("tax_rate")?></label>
                            <input type="text" class="form-control" name="sr_tax" value="<?php if (isset($form_error)){ echo set_value('sr_tax'); } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('sr_tax')?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label><?=trans("description")?></label>
                            <textarea name="sr_description" rows="5" class="form-control"><?php if (isset($form_error)){ echo set_value('sr_description'); } ?></textarea>
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('sr_description')?></div>
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