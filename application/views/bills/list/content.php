<div class="content">
    <h2 class="content-heading"><?=$title?>
        <?php if(permission("bills", "add")): ?>
            <a href="<?=base_url("bills/addForm")?>" class="btn btn-alt-primary btn-sm pull-right">
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
                        <th class="d-none"></th>
                        <th class="text-center"><i class="fa fa-hashtag"></i></th>
                        <th><?=trans("supplier_name")?></th>
                        <th><?=trans("description")?></th>
                        <th width="100"><?=trans("price")?></th>
                        <th><?=trans("total_amount")?></th>
                        <th><?=trans("date")?></th>
                        <th class="text-center" style="width: 100px;"><?=trans("actions")?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item): ?>
                    <?php $supplier = $this->suppliers_model->get(array("sup_id" => $item->sup_id)); ?>
                    <?php
                        $payments = $this->db
                            ->where(array("bill_id" => $item->bill_id))
                            ->select_sum('bill_pay_amount')
                            ->order_by("bill_pay_date DESC")
                            ->get("bill_payments")
                            ->row();
                        ?>
                    <tr>
                        <td class="d-none"></td>
                        <td class="text-center">
                            <?=$item->bill_number?>
                        </td>
                        <td class="font-w600">
                            <?=$supplier->sup_name?>
                        </td>
                        <td class="font-w600">
                            <?=$item->bill_description?>
                        </td>
                        <td class="font-w600">
                            <?=currencyFormat($item->bill_total)?>
                        </td>
                        <td class="font-w600">
                            <?=currencyFormat($payments->bill_pay_amount)?>
                        </td>
                        <td class="font-w600">
                            <?=$item->bill_cre_date?>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <?php if(permission("bills", "show")): ?>
                                    <a href="<?php echo base_url("bills/payments/$item->bill_id/$supplier->sup_id")?>" type="button" class="btn btn-sm btn-secondary">
                                        <i class="fa fa-money"></i>
                                    </a>
                                <?php endif; ?>
                                <?php if(permission("bills", "edit")): ?>
                                <a href="<?php echo base_url("bills/updateForm/$item->bill_id")?>" type="button" class="btn btn-sm btn-secondary">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <?php endif; ?>
                                <?php if(permission("bills", "delete")): ?>
                                    <button data-url="<?php echo base_url("bills/deleteItem/$item->bill_id")?>"
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