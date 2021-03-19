<div class="content">
    <h2 class="content-heading"><?=$title?> (<?=$item->op_description?>)
        <a href="<?=base_url("expenses")?>" class="btn btn-alt-primary btn-sm pull-right">
            <i class="fa fa-arrow-left"></i> <?=trans("back")?>
        </a>
    </h2>
    <?=$breadcrumbs?>
    <!-- Full Table -->
    <div class="block">
        <div class="block-content">
            <div class="col-md-8 offset-md-2">
                <form action="<?=base_url("expenses/updateItem/$item->op_id")?>" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label><?=trans("supplier_name")?></label>
                            <select class="js-select2 form-control" id="sup_id" name="sup_id" style="width: 100%;">
                                <option value="0">---</option>
                                <?php foreach($suppliers as $supplier): ?>
                                    <option value="<?=$supplier->sup_id?>" <?php if(isset($form_error) && set_value("sup_id") == $supplier->sup_id || $item->sup_id == $supplier->sup_id){ echo "selected"; } ?>><?=$supplier->sup_name?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('acc_name')?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label><?=trans("account_name")?></label>
                            <select class="js-select2 form-control" id="acc_id" name="acc_id" style="width: 100%;">
                                <?php foreach($accounts as $account): ?>
                                    <option value="<?=$account->acc_id?>" <?php if(isset($form_error) && set_value("acc_id") == $account->acc_id || $account->acc_id == $item->acc_id){ echo "selected"; } ?>><?=$account->acc_name?> (<?= currencyFormat($account->acc_balance) ?>)</option>
                                <?php endforeach; ?>
                            </select>
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('acc_id')?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label><?=trans("type")?></label>
                            <select class="js-select2 form-control" id="op_type" name="op_type" style="width: 100%;">
                                <option value="official" <?php if(isset($form_error) && set_value("official") == "official" || $item->op_type == "official"){ echo "selected"; } ?>><?=trans("official")?></option>
                                <option value="unofficial" <?php if(isset($form_error) && set_value("unofficial") == "unofficial" || $item->op_type == "unofficial"){ echo "selected"; } ?>><?=trans("unofficial")?></option>
                            </select>
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('acc_name')?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label><?=trans("category")?></label>
                            <select class="js-select2 form-control" id="exc_id" name="exc_id" style="width: 100%;">
                                <?php foreach($expense_categories as $category): ?>
                                    <option value="<?=$category->exc_id?>" <?php if(isset($form_error) && set_value("exc_id") == $category->exc_id ||  $category->exc_id == $item->exc_id){ echo "selected"; } ?>><?=$category->exc_title?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('opc_id')?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-6">
                            <label><?=trans("price")?></label>
                            <input type="text" name="op_price" class="form-control" value="<?php if (isset($form_error)){ echo set_value('op_price'); }else{ echo $item->op_price; } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('op_price')?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label><?=trans("date")?></label>
                            <input type="text" class="js-datepicker form-control" id="example-datepicker1" value="<?php if (isset($form_error)){ echo set_value('op_date'); }else{ echo $item->op_date; } ?>" name="op_date" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="yyyy/mm/dd">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('op_date')?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label><?=trans("description")?></label>
                            <textarea name="op_description" class="form-control" rows="5"><?php if (isset($form_error)){ echo set_value('op_description'); }else{ echo $item->op_description; } ?></textarea>
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('op_description')?></div>
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