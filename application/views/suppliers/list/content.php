<div class="content">
    <h2 class="content-heading"><?=$title?>
        <?php if(permission("suppliers", "add")): ?>
            <a href="<?=base_url("suppliers/addForm")?>" class="btn btn-alt-primary btn-sm pull-right">
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
                        <th style="width: 150px;"><?=trans("supplier_name")?></th>
                        <th><?=trans("supplier_owner")?></th>
                        <th><?=trans("phone")?></th>
                        <th><?=trans("bill_total")?></th>
                        <th><?=trans("total_official_amount")?></th>
                        <th><?=trans("total_unofficial_amount")?></th>
                        <?php if(permission("suppliers", "edit")): ?>
                            <th><?=trans("status")?></th>
                        <?php endif; ?>
                        <th class="text-center" style="width: 100px;"><?=trans("actions")?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item): ?>
                        <?php
                        $incSumOff = $this->db
                            ->where(array("sup_id" => $item->sup_id, "op_type" => "official"))
                            ->select_sum('op_price')
                            ->get('expenses')
                            ->row();
                        $incSumUnoff = $this->db
                            ->where(array("sup_id" => $item->sup_id, "op_type" => "unofficial"))
                            ->select_sum('op_price')
                            ->get('expenses')
                            ->row();
                        $invSum = $this->db
                            ->where(array("sup_id" => $item->sup_id))
                            ->select_sum('bill_total')
                            ->get('bills')
                            ->row();
                        $invPaySum = $this->db
                            ->where(array("sup_id" => $item->sup_id))
                            ->join('bills', 'bills.bill_id = bill_payments.bill_id', 'left')
                            ->select_sum('bill_pay_amount')
                            ->get('bill_payments')
                            ->row();
                        ?>
                    <tr>
                        <td class="font-w600">
                            <a href="<?php echo base_url("suppliers/activities/$item->sup_id")?>">
                                <?=$item->sup_name?>
                            </a>
                        </td>
                        <td class="font-w600">
                            <?=$item->sup_owner?>
                        </td>
                        <td class="font-w600">
                            <?=$item->sup_phone?>
                        </td>
                        <td class="font-w600">
                            <?= currencyFormat($invSum->bill_total) ?>
                        </td>
                        <td class="font-w600">
                            <?= currencyFormat($invPaySum->bill_pay_amount) ?>
                        </td>
                        <td class="font-w600">
                            <?= currencyFormat($incSumUnoff->op_price) ?>
                        </td>
                        <?php if(permission("suppliers", "edit")): ?>
                            <td>
                                <label class="css-control css-control-sm css-control-primary css-switch">
                                    <input type="checkbox" class="css-control-input isActive" id="block-form-remember-me<?=$item->sup_id?>" data-url="<?php echo base_url("suppliers/isActiveSetter/$item->sup_id")?>" <?=$item->sup_isActive == 1 ? 'checked' : null?>>
                                    <span class="css-control-indicator"></span>
                                </label>
                            </td>
                        <?php endif; ?>
                        <td class="text-center">
                            <div class="btn-group">
                                <a href="<?php echo base_url("suppliers/activities/$item->sup_id")?>" type="button" class="btn btn-sm btn-secondary">
                                    <i class="fa fa-line-chart"></i>
                                </a>
                                <?php if(permission("suppliers", "edit")): ?>
                                <a href="<?php echo base_url("suppliers/updateForm/$item->sup_id")?>" type="button" class="btn btn-sm btn-secondary">
                                    <i class="fa fa-pencil"></i>
                                </a>
                                <?php endif; ?>
                                <?php if(permission("suppliers", "delete")): ?>
                                    <button data-url="<?php echo base_url("suppliers/deleteItem/$item->sup_id")?>"
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