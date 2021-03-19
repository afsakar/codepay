<div class="content">
    <h2 class="content-heading"><?=$title?>
        <a href="<?=base_url("invoices/payments/$inv_id/$cus_id")?>" class="btn btn-alt-primary btn-sm pull-right">
            <i class="fa fa-arrow-left"></i> <?=trans("back")?>
        </a>
    </h2>
    <?=$breadcrumbs?>
    <!-- Full Table -->
    <div class="block">
        <div class="block-content">
            <div class="col-md-8 offset-md-2">
                <form action="<?=base_url("invoices/addPayment/$inv_id/$cus_id")?>" method="post" enctype="multipart/form-data">
                    <input type="hidden" value="<?=$inv_id?>" name="inv_id">
                    <input type="hidden" value="<?=$cus_id?>" name="cus_id">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label><?=trans("account_name")?></label>
                            <select class="js-select2 form-control" id="acc_id" name="acc_id" style="width: 100%;">
                                <?php foreach($accounts as $account): ?>
                                    <option value="<?=$account->acc_id?>" <?php if(isset($form_error) && set_value("acc_id") == $account->acc_id){ echo "selected"; } ?>><?=$account->acc_name?> (<?= currencyFormat($account->acc_balance) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('acc_name')?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label><?=trans("price")?></label>
                            <input type="text" name="inv_pay_amount" class="form-control" value="<?php if (isset($form_error)){ echo set_value('inv_pay_amount'); } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('inv_pay_amount')?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label><?=trans("date")?></label>
                            <input type="text" class="js-datepicker form-control" id="example-datepicker1" value="<?php if (isset($form_error)){ echo set_value('inv_pay_date'); } ?>" name="inv_pay_date" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="yyyy/mm/dd">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('inv_pay_date')?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label><?=trans("description")?></label>
                            <textarea name="inv_pay_description" class="form-control" rows="5"><?php if (isset($form_error)){ echo set_value('inv_pay_description'); } ?></textarea>
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('inv_pay_description')?></div>
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