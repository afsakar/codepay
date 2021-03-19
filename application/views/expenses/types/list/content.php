<div class="content">
    <h2 class="content-heading"><?=$title?>
        <?php if(permission("expense_category", "add")): ?>
            <a href="<?=base_url("expenses/categoryForm")?>" class="btn btn-alt-primary btn-sm pull-right">
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
            <div class="table-responsive mb-20">
                <table class="table table-striped table-vcenter table-hover table-container js-dataTable-full">
                    <thead>
                    <tr>
                        <th class="text-center" style="wexc_idth: 100px;"><i class="fa fa-hashtag"></i></th>
                        <th><?=trans("title")?></th>
                        <?php if(permission("expense_category", "edit")): ?>
                            <th><?=trans("status")?></th>
                        <?php endif; ?>
                        <th class="text-center" style="wexc_idth: 100px;"><?=trans("actions")?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item): ?>
                    <tr>
                        <td class="text-center">
                            <?=$item->exc_id?>
                        </td>
                        <td class="font-w600">
                            <?=$item->exc_title?>
                        </td>
                        <?php if(permission("expense_category", "edit")): ?>
                            <td>
                                <label class="css-control css-control-sm css-control-primary css-switch">
                                    <input type="checkbox" class="css-control-input isActive" exc_id="block-form-remember-me<?=$item->exc_id?>" data-url="<?php echo base_url("expenses/isActiveCategory/$item->exc_id")?>" <?=$item->exc_isActive == 1 ? 'checked' : null?>>
                                    <span class="css-control-indicator"></span>
                                </label>
                            </td>
                        <?php endif; ?>
                        <td class="text-center">
                            <div class="btn-group">
                                <?php if(permission("expense_category", "edit")): ?>
                                <a href="<?php echo base_url("expenses/updateCategory/$item->exc_id")?>" type="button" class="btn btn-sm btn-secondary">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <?php endif; ?>
                                <?php if($item->exc_id != 0):?>
                                <?php if(permission("expense_category", "delete")): ?>
                                    <button data-url="<?php echo base_url("expenses/deleteCategory/$item->exc_id")?>"
                                            data-title="<?=trans("delete_title")?>"
                                            data-text="<?=trans("delete_text")?>"
                                            data-confirm="<?=trans("delete_button_confirm")?>"
                                            data-cancel="<?=trans("delete_button_cancel")?>"
                                            type="button" class="btn btn-sm btn-secondary remove-btn">
                                        <i class="fa fa-times"></i>
                                    </button>
                                <?php endif; ?>
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