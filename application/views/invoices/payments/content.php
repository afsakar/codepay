<?php
$payments = $this->db
    ->where(array("inv_id" => $invoice->inv_id))
    ->select_sum('inv_pay_amount')
    ->order_by("inv_pay_date DESC")
    ->get("invoice_payments")
    ->row();
?>
<div class="content">
    <h2 class="content-heading"><?=$title?> (#<?=$invoice->inv_number?>)
        <div class="btn-group pull-right">
            <a href="<?=base_url("invoices")?>" class="btn btn-alt-secondary btn-sm">
                <i class="fa fa-arrow-left"></i> <?=trans("back")?>
            </a>
            <?php if(permission("invoices", "add")): ?>
                <a href="<?=base_url("invoices/paymentForm/$invoice->inv_id/$cus_id")?>" class="btn btn-alt-primary btn-sm">
                    <i class="fa fa-plus"></i> <?=trans("add_new")?>
                </a>
            <?php endif; ?>
        </div>
    </h2>
    <?=$breadcrumbs?>
    <div class="row gutters-tiny mb-20">
        <!-- In Orders -->
        <div class="col-md-6">
            <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
                <div class="block-content block-content-full block-sticky-options">
                    <div class="block-options">
                        <div class="block-options-item">
                            <i class="si si-docs fa-2x text-info-light"></i>
                        </div>
                    </div>
                    <div class="py-20 text-center">
                        <div class="font-size-h2 font-w700 mb-0 text-info">
                            <?= currencyFormat($invoice->inv_total) ?>
                        </div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted"><?=trans("invoice_amount")?></div>
                    </div>
                </div>
            </a>
        </div>
        <!-- END In Orders -->

        <!-- Stock -->
        <div class="col-md-6">
            <a class="block block-rounded block-link-shadow" href="javascript:void(0)">
                <div class="block-content block-content-full block-sticky-options">
                    <div class="block-options">
                        <div class="block-options-item">
                            <i class="fa fa-money fa-2x text-success-light"></i>
                        </div>
                    </div>
                    <div class="py-20 text-center">
                        <div class="font-size-h2 font-w700 mb-0 text-success">
                            <?= currencyFormat($payments->inv_pay_amount) ?>
                        </div>
                        <div class="font-size-sm font-w600 text-uppercase text-muted"><?=trans("total_amount")?></div>
                    </div>
                </div>
            </a>
        </div>
        <!-- END Stock -->
        <!-- END Delete Product -->
    </div>
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
                        <th><?=trans("description")?></th>
                        <th><?=trans("account_name")?></th>
                        <th><?=trans("price")?></th>
                        <th><?=trans("date")?></th>
                        <th class="text-center" style="width: 100px;"><?=trans("actions")?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item): ?>
                    <?php $account = $this->accounts_model->get(array("acc_id" => $item->acc_id)); ?>
                    <tr>
                        <td class="d-none"></td>
                        <td class="font-w600">
                            <?=$item->inv_pay_description?>
                        </td>
                        <td class="font-w600">
                            <?=$account->acc_name?>
                        </td>
                        <td class="font-w600">
                            <?= currencyFormat($item->inv_pay_amount) ?>
                        </td>
                        <td class="font-w600">
                            <?=$item->inv_pay_date?>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <?php if(permission("invoices", "delete")): ?>
                                    <button data-url="<?php echo base_url("invoices/deletePayment/$item->inv_pay_id")?>"
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