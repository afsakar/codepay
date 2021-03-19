<div class="content">
    <h2 class="content-heading"><?=$title?>
        <?php if(permission("invoices", "add")): ?>
            <a href="<?=base_url("invoices/addForm")?>" class="btn btn-alt-primary btn-sm pull-right">
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
                        <th class="d-none"></th>
                        <th class="text-center"><i class="fa fa-hashtag"></i></th>
                        <th><?=trans("customer_name")?></th>
                        <th><?=trans("description")?></th>
                        <th width="100"><?=trans("price")?></th>
                        <th><?=trans("total_amount")?></th>
                        <th><?=trans("date")?></th>
                        <th class="text-center" style="width: 100px;"><?=trans("actions")?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item): ?>
                    <?php $customer = $this->customers_model->get(array("cus_id" => $item->cus_id)); ?>
                    <?php
                        $payments = $this->db
                            ->where(array("inv_id" => $item->inv_id))
                            ->select_sum('inv_pay_amount')
                            ->order_by("inv_pay_date DESC")
                            ->get("invoice_payments")
                            ->row();
                        ?>
                    <tr>
                        <td class="d-none"></td>
                        <td class="text-center">
                            <?=$item->inv_number?>
                        </td>
                        <td class="font-w600">
                            <?=$customer->cus_name?>
                        </td>
                        <td class="font-w600">
                            <?=$item->inv_description?>
                        </td>
                        <td class="font-w600">
                            <?= currencyFormat($item->inv_total) ?>
                        </td>
                        <td class="font-w600">
                            <?= currencyFormat($payments->inv_pay_amount) ?>
                        </td>
                        <td class="font-w600">
                            <?=$item->inv_cre_date?>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <?php if(permission("invoices", "show")): ?>
                                    <a href="<?php echo base_url("invoices/payments/$item->inv_id/$customer->cus_id")?>" type="button" class="btn btn-sm btn-secondary">
                                        <i class="fa fa-money"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if(permission("invoices", "edit")): ?>
                                <a href="<?php echo base_url("invoices/updateForm/$item->inv_id")?>" type="button" class="btn btn-sm btn-secondary">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <?php endif; ?>
                                <?php if(permission("invoices", "delete")): ?>
                                    <button data-url="<?php echo base_url("invoices/deleteItem/$item->inv_id")?>"
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