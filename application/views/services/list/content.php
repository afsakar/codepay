<div class="content">
    <h2 class="content-heading"><?=$title?>
        <?php if(permission("services", "add")): ?>
            <a href="<?=base_url("services/addForm")?>" class="btn btn-alt-primary btn-sm pull-right">
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
                <table class="table table-striped table-vcenter table-hover table-container js-dataTable-full">
                    <thead>
                    <tr>
                        <th class="text-center"><i class="fa fa-hashtag"></i></th>
                        <th><?=trans("title")?></th>
                        <th><?=trans("description")?></th>
                        <th><?=trans("unit")?></th>
                        <th style="width: 100px;"><?=trans("amount")?></th>
                        <th style="width: 100px;"><?=trans("price")?></th>
                        <th><?=trans("tax")?></th>
                        <?php if(permission("services", "edit")): ?>
                            <th><?=trans("status")?></th>
                        <?php endif; ?>
                        <th class="text-center" style="width: 100px;"><?=trans("actions")?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td class="text-center">
                            <?=$item->sr_code?>
                        </td>
                        <td class="font-w600">
                            <?=$item->sr_name?>
                        </td>
                        <td class="font-w600">
                            <?=$item->sr_description?>
                        </td>
                        <td class="font-w600">
                            <?=$item->sr_unit?>
                        </td>
                        <td class="font-w600">
                            <?= currencyFormat($item->sr_amount) ?>
                        </td>
                        <td class="font-w600">
                            <?= currencyFormat($item->sr_price) ?>
                        </td>
                        <td class="font-w600">
                            %<?=$item->sr_tax?>
                        </td>
                        <?php if(permission("services", "edit")): ?>
                            <td>
                                <label class="css-control css-control-sm css-control-primary css-switch">
                                    <input type="checkbox" class="css-control-input isActive" id="block-form-remember-me<?=$item->sr_id?>" data-url="<?php echo base_url("services/isActiveSetter/$item->sr_id")?>" <?=$item->sr_isActive == 1 ? 'checked' : null?>>
                                    <span class="css-control-indicator"></span>
                                </label>
                            </td>
                        <?php endif; ?>
                        <td class="text-center">
                            <div class="btn-group">
                                <?php if(permission("services", "edit")): ?>
                                <a href="<?php echo base_url("services/updateForm/$item->sr_id")?>" type="button" class="btn btn-sm btn-secondary">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <?php endif; ?>
                                <?php if(permission("services", "delete")): ?>
                                    <button data-url="<?php echo base_url("services/deleteItem/$item->sr_id")?>"
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