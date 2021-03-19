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
                <form action="<?=base_url("accounts/addTransfer/$item->acc_id")?>" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label><?=trans("sending_account")?></label>
                            <input type="text" readonly class="form-control" value="<?=$item->acc_name?> (<?=currencyFormat($item->acc_balance)?>)">
                        </div>
                        <div class="col-md-6">
                            <label><?=trans("receiver_account")?></label>
                            <select class="js-select2 form-control" id="acc_id" name="acc_id" style="width: 100%;">
                                <?php foreach($accounts as $account): ?>
                                    <option value="<?=$account->acc_id?>" <?php if(isset($form_error) && set_value("acc_id") == $account->acc_id){ echo "selected"; } ?>><?=$account->acc_name?> (<?=currencyFormat($account->acc_balance)?>)</option>
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
                            <input type="text" name="op_price" class="form-control" value="<?php if (isset($form_error)){ echo set_value('op_price'); } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('op_price')?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label><?=trans("date")?></label>
                            <input type="text" class="js-datepicker form-control" id="example-datepicker1" value="<?php if (isset($form_error)){ echo set_value('op_date'); } ?>" name="op_date" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="dd/mm/yyyy">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('op_date')?></div>
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