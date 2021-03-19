<div class="content">
    <h2 class="content-heading">
        <?=$title?>
        <a href="<?=base_url("suppliers")?>" class="btn btn-alt-primary btn-sm pull-right">
            <i class="fa fa-arrow-left"></i> <?=trans("back")?>
        </a>
    </h2>
    <?=$breadcrumbs?>

    <!-- Page Content -->
    <div class="content">

        <!-- supplier -->
        <h2 class="content-heading">
            <?=trans("supplier_info")?>
        </h2>
        <div class="row row-deck">
            <!-- supplier's Basic Info -->
            <div class="col-lg-4">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content bg-secondary">
                        <div class="push">
                            <br>
                            <img class="img-fluid" width="200" src="<?=base_url("uploads/$viewFolder/$item->sup_logo")?>" alt="">
                            <br>
                        </div>
                        <div class="pull-r-l pull-b py-10 bg-black-op-25">
                            <div class="font-w600 mb-5 text-white">
                                <?=$item->sup_name?>
                            </div>
                            <div class="font-size-sm text-white-op"><i class="si si-user"></i> <?=$item->sup_owner?></div>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="row items-push text-center">
                            <div class="col-6">
                                <div class="mb-5"><i class="si si-docs font-size-h6"></i> <span class="font-size-h6"><?=trans("bill_total")?></span></div>
                                <div class="text-muted font-size-h5">
                                    <?= currencyFormat($invSum->bill_total) ?>
                                </div>
                            </div>
                            <?php
                            $incSum = $this->db
                                    ->where(array("sup_id" => $item->sup_id, "op_type" => "official"))
                                    ->select_sum('op_price')
                                    ->get('expenses')
                                    ->row();
                            ?>
                            <div class="col-6">
                                <div class="mb-5"><i class="fa fa-money font-size-h6"></i> <span class="font-size-h6"><?=trans("total_official_amount")?></span></div>
                                <div class="text-muted font-size-h5">
                                    <?= currencyFormat($incSum->op_price) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- END supplier's Basic Info -->

            <!-- supplier's Past Orders -->
            <div class="col-lg-8">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title"><?=trans("bill_info")?></h3>
                    </div>
                    <div class="block-content">
                        <div class="font-size-lg text-black mb-5"><?=$item->sup_name?></div>
                        <div class="col-md-12 mb-5"><span class="font-w700"><?=trans("address")?>:</span> <?=$item->sup_address?></div>
                        <div class="col-md-12 mb-5"><span class="font-w700"><?=trans("phone")?>:</span>  <?=$item->sup_phone?><br></div>
                        <div class="col-md-12 mb-5"><?php if($item->sup_fax): ?><span class="font-w700"><?=trans("fax")?>:</span>  <?=$item->sup_fax?><br><?php endif; ?></div>
                        <div class="col-md-12 mb-5"><span class="font-w700"><?=trans("gsm")?>:</span>  <?=$item->sup_gsm?><br></div>
                        <div class="col-md-12 mb-5"><span class="font-w700"><?=trans("email")?>:</span> <?=$item->sup_email?></div>
                        <div class="col-md-12 mb-5"><span class="font-w700"><?=trans("tax_office_name")?>:</span> <?=$item->sup_tax_office?></div>
                        <div class="col-md-12 mb-20"><span class="font-w700"><?=trans("tax_number")?>:</span> <?=$item->sup_tax_number?></div>
                    </div>
                </div>
            </div>
            <!-- END supplier's Past Orders -->
        </div>
        <!-- END supplier -->

        <!-- bills -->
        <h2 class="content-heading">
            <?=trans("bill_list")?>
        </h2>
        <div class="block block-rounded">
            <div class="block-content">
                <?php if (!$bills): ?>
                    <div class="col-md-8 offset-md-2">
                        <div class="alert alert-primary text-center"><?=trans("nothing_added")?></div>
                    </div>
                <?php else: ?>
                <!-- Orders Table -->
                <div class="table-responsive">
                    <table class="table table-striped table-vcenter table-hover table-container js-dataTable-full">
                    <thead>
                    <tr>
                        <th class="d-none"></th>
                        <th><?=trans("bill_number")?></th>
                        <th><?=trans("description")?></th>
                        <th><?=trans("price")?></th>
                        <th><?=trans("total_amount")?></th>
                        <th><?=trans("date")?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($bills as $bill): ?>
                    <?php
                    $payments = $this->db
                        ->where(array("bill_id" => $bill->bill_id))
                        ->join('accounts', 'accounts.acc_id = bill_payments.acc_id', 'left')
                        ->select_sum('bill_pay_amount')
                        ->order_by("bill_pay_date DESC")
                        ->get("bill_payments")
                        ->row();
                     ?>
                        <tr>
                            <td class="d-none"></td>
                            <td>
                                <a href="<?=base_url("bills/updateForm/$bill->bill_id")?>" class="btn btn-alt-primary btn-sm">#<?=$bill->bill_number?></a>
                            </td>
                            <td>
                                <?=$bill->bill_description?>
                            </td>
                            <td>
                                <?= currencyFormat($bill->bill_total) ?>
                            </td>
                            <td>
                                <?= currencyFormat($payments->bill_pay_amount) ?>
                            </td>
                            <td>
                                <?=$bill->bill_cre_date?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
                </div>
                <?php endif; ?>
                <!-- END Orders Table -->
            </div>
        </div>
        <!-- END bills -->

        <!-- Other Payments -->
        <h2 class="content-heading">
            <?=trans("other_payments")?>
        </h2>
        <?php
        $expenses = $this->db->where(array("sup_id" => $item->sup_id))
            ->join('accounts', 'accounts.acc_id = expenses.acc_id', 'left')
            ->join('expense_category', 'expense_category.exc_id = expenses.exc_id', 'left')
            ->order_by("op_date DESC")
            ->get("expenses")
            ->result();
        ?>
        <div class="block block-rounded">
            <div class="block-content">
                <?php if (!$expenses): ?>
                    <div class="col-md-8 offset-md-2">
                        <div class="alert alert-primary text-center"><?=trans("nothing_added")?></div>
                    </div>
                <?php else: ?>
                    <!-- Orders Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-vcenter table-hover table-container js-dataTable-full">
                            <thead>
                            <tr>
                                <th class="d-none"></th>
                                <th><?=trans("description")?></th>
                                <th><?=trans("account_name")?></th>
                                <th><?=trans("category")?></th>
                                <th><?=trans("type")?></th>
                                <th><?=trans("price")?></th>
                                <th><?=trans("date")?></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($expenses as $expense): ?>
                                <tr>
                                    <td class="d-none"></td>
                                    <td>
                                        <?=$expense->op_description?>
                                    </td>
                                    <td>
                                        <?=$expense->acc_name?>
                                    </td>
                                    <td>
                                        <?=$expense->exc_title?>
                                    </td>
                                    <td>
                                        <span class="badge badge-primary"><?=trans("$expense->op_type")?></span>
                                    </td>
                                    <td>
                                        <?= currencyFormat($expense->op_price) ?>
                                    </td>
                                    <td>
                                        <?=$expense->op_date?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
                <!-- END Orders Table -->
            </div>
        </div>
        <!-- END Other Payments -->

        <!-- Private Notes -->
        <h2 class="content-heading"><?=trans("supplier_notes")?></h2>
        <div class="block block-rounded">
            <div class="block-content">
                <div class="alert alert-info" role="alert">
                    <p class="mb-0"><i class="fa fa-info-circle mr-5"></i><?=trans("supplier_note_text")?></p>
                </div>
                <form action="<?=base_url("suppliers/editInfo/$item->sup_id")?>" method="post">
                    <div class="form-group row mb-10">
                        <div class="col-10 offset-1">
                            <textarea name="sup_info" id="js-ckeditor-inline"><?php if (isset($form_error)){ echo set_value('sup_info'); }else{ echo $item->sup_info; }?></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-alt-primary"><?=trans("update")?></button>
                    </div>
                </form>
            </div>
        </div>
        <!-- END Private Notes -->
    </div>
    <!-- END Page Content -->
</div>