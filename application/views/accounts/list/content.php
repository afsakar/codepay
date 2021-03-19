<div class="content">
    <h2 class="content-heading"><?=$title?>
        <?php if(permission("accounts", "add")): ?>
            <a href="<?=base_url("accounts/addForm")?>" class="btn btn-alt-primary btn-sm pull-right">
                <i class="fa fa-plus"></i> <?=trans("add_new")?>
            </a>
        <?php endif; ?>
    </h2>
    <?=$breadcrumbs?>
    <!-- Full Table -->
    <div class="block">
        <div class="block-content">
            <?php if (!$items): ?>
            <div class="col-md-8 offset-md-2">
                <div class="alert alert-primary text-center"><?=trans("nothing_added")?></div>
            </div>
            <?php else: ?>
            <div class="table-responsive">
                <?php if(settings("table_type") == "normal"): ?>
                    <input type="text" id="search" placeholder="<?=trans("search")?>" class="form-control"></input>
                <?php endif; ?>
                <table class="table table-striped table-vcenter table-hover table-container<?php if(settings("table_type") == "datatable"): ?> js-dataTable-full<?php endif; ?>">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 100px;"><i class="fa fa-hashtag"></i></th>
                        <th><?=trans("account_name")?></th>
                        <th><?=trans("bank_name")?></th>
                        <th><?=trans("account_type")?></th>
                        <th><?=trans("account_balance")?></th>
                        <?php if(permission("accounts", "edit")): ?>
                            <th><?=trans("status")?></th>
                        <?php endif; ?>
                        <th class="text-center" style="width: 100px;"><?=trans("actions")?></th>
                    </tr>
                    </thead>
                    <tbody data-url="<?php echo base_url("accounts/rankSetter")?>">
                    <?php foreach ($items as $item): ?>
                    <?php $acc_type = $this->accounts_type_model->get(array("act_isActive" => 1, "act_id" => $item->acc_type)); ?>
                    <tr id="ord-<?=$item->acc_id?>">
                        <td class="text-center">
                            <?=$item->acc_id?>
                        </td>
                        <td class="font-w600">
                            <a href="<?php echo base_url("accounts/extract/$item->acc_id")?>"><?=$item->acc_name?></a>
                        </td>
                        <td class="font-w600">
                            <?=$item->acc_bank_name?>
                        </td>
                        <td class="font-w600">
                            <?php if(isset($acc_type->act_title)){ echo $acc_type->act_title;}else{ echo "Nakit"; }?>
                        </td>
                        <td class="font-w600">
                            <?=currencyFormat($item->acc_balance)?>
                        </td>
                        <?php if(permission("accounts", "edit")): ?>
                            <td>
                                <label class="css-control css-control-sm css-control-primary css-switch">
                                    <input type="checkbox" class="css-control-input isActive" id="block-form-remember-me<?=$item->acc_id?>" data-url="<?php echo base_url("accounts/isActiveSetter/$item->acc_id")?>" <?=$item->acc_isActive == 1 ? 'checked' : null?>>
                                    <span class="css-control-indicator"></span>
                                </label>
                            </td>
                        <?php endif; ?>
                        <td class="text-center">
                            <div class="btn-group">
                                <?php if ($item->acc_balance > 0): ?>
                                <a href="<?php echo base_url("accounts/transferForm/$item->acc_id")?>" type="button" class="btn btn-sm btn-secondary">
                                    <i class="fa fa-refresh"></i>
                                </a>
                                <?php endif; ?>
                                <?php if(permission("accounts", "edit")): ?>
                                <a href="<?php echo base_url("accounts/updateForm/$item->acc_id")?>" type="button" class="btn btn-sm btn-secondary">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <?php endif; ?>
                                <?php if(permission("accounts", "delete")): ?>
                                    <button data-url="<?php echo base_url("accounts/deleteItem/$item->acc_id")?>"
                                            data-title="<?=trans("delete_title")?>"
                                            data-text="<?=trans("delete_text")?>"
                                            data-confirm="<?=trans("delete_button_confirm")?>"
                                            data-cancel="<?=trans("delete_button_cancel")?>"
                                            type="button" class="btn btn-sm btn-secondary remove-btn">
                                        <i class="fa fa-times"></i>
                                    </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                <?php if(settings("table_type") == "normal"): ?>
                <?=$links?>
                <?php endif; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- END Full Table -->

</div>