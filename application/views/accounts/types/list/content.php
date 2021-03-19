<div class="content">
    <h2 class="content-heading"><?=$title?>
        <?php if(permission("account_types", "add")): ?>
            <a href="<?=base_url("account_types/typeForm")?>" class="btn btn-alt-primary btn-sm pull-right">
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
                        <th></th>
                        <th class="text-center" style="wact_idth: 100px;"><i class="fa fa-hashtag"></i></th>
                        <th><?=trans("title")?></th>
                        <th><?=trans("created_at")?></th>
                        <?php if(permission("account_types", "edit")): ?>
                            <th><?=trans("status")?></th>
                        <?php endif; ?>
                        <th class="text-center" style="wact_idth: 100px;"><?=trans("actions")?></th>
                    </tr>
                    </thead>
                    <tbody class="sortable" data-url="<?php echo base_url("accounts/typeRankSetter")?>">
                    <?php foreach ($items as $item): ?>
                    <tr id="ord-<?=$item->act_id?>">
                        <td class="sortableItem"><i class="fa fa-bars"></i></td>
                        <td class="text-center">
                            <?=$item->act_id?>
                        </td>
                        <td class="font-w600">
                            <?=$item->act_title?>
                        </td>
                        <td class="font-w600">
                            <?=timeConvert($item->act_createdAt)?>
                        </td>
                        <?php if(permission("account_types", "edit")): ?>
                            <td>
                                <label class="css-control css-control-sm css-control-primary css-switch">
                                    <input type="checkbox" class="css-control-input isActive" act_id="block-form-remember-me<?=$item->act_id?>" data-url="<?php echo base_url("accounts/isActiveType/$item->act_id")?>" <?=$item->act_isActive == 1 ? 'checked' : null?>>
                                    <span class="css-control-indicator"></span>
                                </label>
                            </td>
                        <?php endif; ?>
                        <td class="text-center">
                            <div class="btn-group">
                                <?php if(permission("account_types", "edit")): ?>
                                <a href="<?php echo base_url("account_types/updateType/$item->act_id")?>" type="button" class="btn btn-sm btn-secondary">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <?php endif; ?>
                                <?php if(permission("account_types", "delete")): ?>
                                    <button data-url="<?php echo base_url("accounts/deleteType/$item->act_id")?>"
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