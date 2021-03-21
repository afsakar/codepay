<div class="content">
    <h2 class="content-heading"><?=$title?>
        <?php if(permission("email_settings", "add")): ?>
            <a href="<?=base_url("email_settings/addForm")?>" class="btn btn-alt-primary btn-sm pull-right">
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
                            <th class="text-center" style="width: 100px;"><i class="fa fa-hashtag"></i></th>
                            <th><?=trans("email_title")?></th>
                            <th><?=trans("host")?></th>
                            <th><?=trans("protocol")?></th>
                            <th><?=trans("email")?></th>
                            <th><?=trans("from")?></th>
                            <th><?=trans("to")?></th>
                            <?php if(permission("email_settings", "edit")): ?>
                                <th><?=trans("status")?></th>
                            <?php endif; ?>
                            <th class="text-center" style="width: 100px;"><?=trans("actions")?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($items as $item): ?>
                        <tr>
                            <td class="text-center">
                                <?=$item->id?>
                            </td>
                            <td class="font-w600">
                                <?=$item->user_name?>
                            </td>
                            <td><?=$item->host?></td>
                            <td><?=$item->protocol?></td>
                            <td><?=$item->user?></td>
                            <td><?=$item->from?></td>
                            <td><?=$item->to?></td>
                            <?php if(permission("email_settings", "edit")): ?>
                                <td>
                                    <label class="css-control css-control-sm css-control-primary css-switch">
                                        <input type="checkbox" class="css-control-input isActive" id="block-form-remember-me<?=$item->id?>" data-url="<?php echo base_url("email_settings/isActiveSetter/$item->id")?>" <?=$item->isActive == 1 ? 'checked' : null?>>
                                        <span class="css-control-indicator"></span>
                                    </label>
                                </td>
                            <?php endif; ?>
                            <td class="text-center">
                                <div class="btn-group">
                                    <?php if(permission("email_settings", "edit")): ?>
                                    <a href="<?php echo base_url("email_settings/updateForm/$item->id")?>" type="button" class="btn btn-sm btn-secondary">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <?php endif; ?>
                                    <?php if(permission("email_settings", "delete")): ?>
                                        <button data-url="<?php echo base_url("email_settings/deleteItem/$item->id")?>"
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
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- END Full Table -->

</div>