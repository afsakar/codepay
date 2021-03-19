<div class="content">
    <h2 class="content-heading"><?=$title?>
        <a href="<?=base_url("accounts")?>" class="btn btn-alt-primary btn-sm pull-right">
            <i class="fa fa-arrow-left"></i> <?=trans("back")?>
        </a>
    </h2>
    <?=$breadcrumbs?>
    <!-- Full Table -->
    <div class="block">
        <div class="block-content">
            <div class="col-md-8 offset-md-2">
                <form action="<?=base_url("accounts/addItem")?>" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label><?=trans("account_name")?></label>
                            <input type="text" class="form-control" name="acc_name" value="<?php if (isset($form_error)){ echo set_value('acc_name'); } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('acc_name')?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label><?=trans("account_owner")?></label>
                            <input type="text" class="form-control" name="acc_owner" value="<?php if (isset($form_error)){ echo set_value('acc_owner'); } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('acc_owner')?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label><?=trans("bank_name")?></label>
                            <input type="text" class="form-control" name="acc_bank_name" value="<?php if (isset($form_error)){ echo set_value('acc_bank_name'); } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('acc_bank_name')?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label><?=trans("branch_name")?></label>
                            <input type="text" class="form-control" name="acc_branch_name" value="<?php if (isset($form_error)){ echo set_value('acc_branch_name'); } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('acc_branch_name')?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label><?=trans("account_number")?></label>
                            <input type="text" class="form-control" name="acc_number" value="<?php if (isset($form_error)){ echo set_value('acc_number'); } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('acc_number')?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label><?=trans("branch_code")?></label>
                            <input type="text" class="form-control" name="acc_branch_number" value="<?php if (isset($form_error)){ echo set_value('acc_branch_number'); }?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('acc_branch_number')?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label><?=trans("account_iban")?></label>
                            <input type="text" class="form-control" name="acc_iban" value="<?php if (isset($form_error)){ echo set_value('acc_iban'); }else{ echo "TR"; } ?>">
                            <div class="form-text text-muted"><?=trans("no_spaces")?></div>
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('acc_iban')?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label><?=trans("account_type")?></label>
                            <select class="js-select2 form-control" id="example-select2" name="acc_type" style="width: 100%;">
                                <option <?php if(isset($form_error) && set_value('acc_type') == 0){echo "selected"; }else{ echo ""; } ?> value="0">Nakit</option>
                                <?php foreach($accTypes as $type): ?>
                                <option <?php if(isset($form_error) && set_value('acc_type') == $type->act_id){echo "selected"; }else{ echo ""; } ?> value="<?=$type->act_id?>"><?=$type->act_title?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('acc_type')?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label><?=trans("date")?></label>
                            <input type="text" class="js-datepicker form-control" id="example-datepicker1" value="<?php if (isset($form_error)){ echo set_value('acc_date'); } ?>" name="acc_date" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="dd/mm/yyyy">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('acc_date')?></div>
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