<div class="content">
    <h2 class="content-heading"><?=$title?>
        <a href="<?=base_url("products")?>" class="btn btn-alt-primary btn-sm pull-right">
            <i class="fa fa-arrow-left"></i> <?=trans("back")?>
        </a>
    </h2>
    <?=$breadcrumbs?>
    <!-- Full Table -->
    <div class="block">
        <div class="block-content">
            <div class="col-md-8 offset-md-2">
                <form action="<?=base_url("products/addItem")?>" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label><?=trans("title")?></label>
                            <input type="text" class="form-control" name="pr_name" value="<?php if (isset($form_error)){ echo set_value('pr_name'); } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('pr_name')?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label><?=trans("product_code")?></label>
                            <input type="text" class="form-control" name="pr_code" value="<?php if (isset($form_error)){ echo set_value('pr_code'); } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('pr_code')?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label><?=trans("amount")?></label>
                            <input type="text" class="form-control" name="pr_amount" value="<?php if (isset($form_error)){ echo set_value('pr_amount'); } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('pr_amount')?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label><?=trans("tax")?></label>
                            <input type="text" class="form-control" name="pr_price" value="<?php if (isset($form_error)){ echo set_value('pr_price'); } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('pr_price')?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label><?=trans("unit")?></label>
                            <input type="text" class="form-control" name="pr_unit" value="<?php if (isset($form_error)){ echo set_value('pr_unit'); } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('pr_unit')?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label><?=trans("tax_rate")?></label>
                            <input type="text" class="form-control" name="pr_tax" value="<?php if (isset($form_error)){ echo set_value('pr_tax'); } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('pr_tax')?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label><?=trans("description")?></label>
                            <textarea name="pr_description" rows="5" class="form-control"><?php if (isset($form_error)){ echo set_value('pr_description'); } ?></textarea>
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('pr_description')?></div>
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