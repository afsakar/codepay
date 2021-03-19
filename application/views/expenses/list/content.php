<div class="content">
    <h2 class="content-heading"><?=$title?>
        <?php if(permission("expenses", "add")): ?>
            <a href="<?=base_url("expenses/addForm")?>" class="btn btn-alt-primary btn-sm pull-right">
                <i class="fa fa-plus"></i> <?=trans("add_expense")?>
            </a>
        <?php endif; ?>
    </h2>
    <?=$breadcrumbs?>

    <div class="block">
        <div class="block-header justify-content-end">
            <h5 class="block-title">Last 7 days expense</h5>
        </div>
        <div class="block-content">
            <?=chart("expenses", "", "Area", $expenses, "op_date", "op_price", trans("expense"), "#E74A3B")?>
        </div>
    </div>

    <!-- expense -->
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
                            <th class="d-none"></th>
                            <th class="text-center"><i class="fa fa-hashtag"></i></th>
                            <th><?=trans("description")?></th>
                            <th><?=trans("account_name")?></th>
                            <th><?=trans("date")?></th>
                            <th><?=trans("type")?></th>
                            <th><?=trans("category")?></th>
                            <th><?=trans("price")?></th>
                            <th class="text-center" style="width: 100px;"><?=trans("actions")?></th>
                        </tr>
                        </thead>
                        <tbody data-url="<?php echo base_url("expenses/rankSetter")?>">
                        <?php foreach ($items as $item): ?>
                            <?php
                            $exc = $this->expense_category_model->get(array("exc_id" => $item->exc_id));
                            $account = $this->accounts_model->get(array("acc_id" => $item->acc_id));
                            $supplier = $this->suppliers_model->get(array("sup_id" => $item->sup_id));
                            ?>
                            <tr>
                                <td class="d-none"></td>
                                <td class="text-center">
                                    <?=$item->op_id?>
                                </td>
                                <td class="font-w600">
                                    <?php if($item->sup_id != 0): ?>
                                        <?=$supplier->sup_name." ".$item->op_description?>
                                    <?php else: ?>
                                        <?=$item->op_description?>
                                    <?php endif; ?>
                                </td>
                                <td class="font-w600">
                                    <?=$account->acc_name?>
                                </td>
                                <td class="font-w600">
                                    <?=$item->op_date?>

                                <td class="font-w600">
                                    <span class="badge badge-primary"><?=trans("$item->op_type")?></span>
                                </td>
                                <td class="font-w600">
                                    <?=$exc->exc_title?>
                                </td>
                                <td class="font-w600">
                                    <?= currencyFormat($item->op_price) ?>
                                </td>
                                <td class="text-center">
                                    <?php if($item->exc_id != 0):?>
                                    <div class="btn-group">
                                        <?php if(permission("expenses", "edit")): ?>
                                            <a href="<?php echo base_url("expenses/updateForm/$item->op_id")?>" type="button" class="btn btn-sm btn-secondary">
                                                <i class="fa fa-pencil"></i>
                                            </a>
                                        <?php endif; ?>
                                        <?php if(permission("expenses", "delete")): ?>
                                            <button data-url="<?php echo base_url("expenses/deleteItem/$item->op_id")?>"
                                                    data-title="<?=trans("delete_title")?>"
                                                    data-text="<?=trans("delete_text")?>"
                                                    data-confirm="<?=trans("delete_button_confirm")?>"
                                                    data-cancel="<?=trans("delete_button_cancel")?>"
                                                    type="button" class="btn btn-sm btn-secondary remove-btn">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        <?php endif; ?>
                                    </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- expense -->

</div>