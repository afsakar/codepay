<div class="content">
    <h2 class="content-heading">
        <?=$title?>
        <a href="<?=base_url("customers")?>" class="btn btn-alt-primary btn-sm pull-right">
            <i class="fa fa-arrow-left"></i> <?=trans("back")?>
        </a>
    </h2>
    <?=$breadcrumbs?>

    <!-- Page Content -->
    <div class="content">

        <!-- Customer -->
        <h2 class="content-heading">
            <?=trans("customer_info")?>
        </h2>
        <div class="row row-deck">
            <!-- Customer's Basic Info -->
            <div class="col-lg-4">
                <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                    <div class="block-content bg-secondary">
                        <div class="push">
                            <br>
                            <img class="img-fluid" width="200" src="<?=base_url("uploads/$viewFolder/$item->cus_logo")?>" alt="">
                            <br>
                        </div>
                        <div class="pull-r-l pull-b py-10 bg-black-op-25">
                            <div class="font-w600 mb-5 text-white">
                                <?=$item->cus_name?>
                            </div>
                            <div class="font-size-sm text-white-op"><i class="si si-user"></i> <?=$item->cus_owner?></div>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="row items-push text-center">
                            <div class="col-6">
                                <div class="mb-5"><i class="si si-docs font-size-h6"></i> <span class="font-size-h6"><?=trans("invoice_total")?></span></div>
                                <div class="text-muted font-size-h5">
                                    <?= currencyFormat($invSum->inv_total) ?>
                                </div>
                            </div>
                            <?php
                            $incSumOff = $this->db
                                    ->where(array("cus_id" => $item->cus_id, "op_type" => "official"))
                                    ->select_sum('op_price')
                                    ->get('incomes')
                                    ->row();
                            ?>
                            <div class="col-6">
                                <div class="mb-5"><i class="fa fa-money font-size-h6"></i> <span class="font-size-h6"><?=trans("total_official_amount")?></span></div>
                                <div class="text-muted font-size-h5">
                                    <?= currencyFormat($incSumOff->op_price) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <!-- END Customer's Basic Info -->

            <!-- Customer's Past Orders -->
            <div class="col-lg-8">
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title"><?=trans("invoice_info")?></h3>
                    </div>
                    <div class="block-content">
                        <div class="font-size-lg text-black mb-5"><?=$item->cus_name?></div>
                        <div class="col-md-12 mb-5"><span class="font-w700"><?=trans("address")?>:</span> <?=$item->cus_address?></div>
                        <div class="col-md-12 mb-5"><span class="font-w700"><?=trans("phone")?>:</span>  <?=$item->cus_phone?><br></div>
                        <div class="col-md-12 mb-5"><?php if($item->cus_fax): ?><span class="font-w700"><?=trans("fax")?>:</span>  <?=$item->cus_fax?><br><?php endif; ?></div>
                        <div class="col-md-12 mb-5"><span class="font-w700"><?=trans("gsm")?>:</span>  <?=$item->cus_gsm?><br></div>
                        <div class="col-md-12 mb-5"><span class="font-w700"><?=trans("email")?>:</span> <?=$item->cus_email?></div>
                        <div class="col-md-12 mb-5"><span class="font-w700"><?=trans("tax_office_name")?>:</span> <?=$item->cus_tax_office?></div>
                        <div class="col-md-12 mb-20"><span class="font-w700"><?=trans("tax_number")?>:</span> <?=$item->cus_tax_number?></div>
                    </div>
                </div>
            </div>
            <!-- END Customer's Past Orders -->
        </div>
        <!-- END Customer -->

        <!-- Invoices -->
        <h2 class="content-heading">
            <?=trans("invoice_list")?>
        </h2>
        <div class="block block-rounded">
            <div class="block-content">
                <?php if (!$invoices): ?>
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
                        <th><?=trans("invoice_number")?></th>
                        <th><?=trans("description")?></th>
                        <th><?=trans("price")?></th>
                        <th><?=trans("total_amount")?></th>
                        <th><?=trans("date")?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($invoices as $invoice): ?>
                    <?php
                    $payments = $this->db
                        ->where(array("inv_id" => $invoice->inv_id))
                        ->join('accounts', 'accounts.acc_id = invoice_payments.acc_id', 'left')
                        ->select_sum('inv_pay_amount')
                        ->order_by("inv_pay_date DESC")
                        ->get("invoice_payments")
                        ->row();
                     ?>
                        <tr>
                            <td class="d-none"></td>
                            <td>
                                <a href="<?=base_url("invoices/updateForm/$invoice->inv_id")?>" class="btn btn-alt-primary btn-sm">#<?=$invoice->inv_number?></a>
                            </td>
                            <td>
                                <?=$invoice->inv_description?>
                            </td>
                            <td>
                                <?= currencyFormat($invoice->inv_total) ?>
                            </td>
                            <td>
                                <?= currencyFormat($payments->inv_pay_amount) ?>
                            </td>
                            <td>
                                <?=$invoice->inv_cre_date?>
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
        <!-- END Invoices -->

        <!-- Other Payments -->
        <h2 class="content-heading">
            <?=trans("other_payments")?>
        </h2>
        <?php
        $incomes = $this->db->where(array("cus_id" => $item->cus_id))
            ->join('accounts', 'accounts.acc_id = incomes.acc_id', 'left')
            ->join('income_category', 'income_category.inc_id = incomes.inc_id', 'left')
            ->order_by("op_date DESC")
            ->get("incomes")
            ->result();
        ?>
        <div class="block block-rounded">
            <div class="block-content">
                <?php if (!$incomes): ?>
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
                            <?php foreach ($incomes as $income): ?>
                                <tr>
                                    <td class="d-none"></td>
                                    <td>
                                        <?=$income->op_description?>
                                    </td>
                                    <td>
                                        <?=$income->acc_name?>
                                    </td>
                                    <td>
                                        <?=$income->inc_title?>
                                    </td>
                                    <td>
                                        <span class="badge badge-primary"><?=trans("$income->op_type")?></span>
                                    </td>
                                    <td>
                                        <?= currencyFormat($income->op_price) ?>
                                    </td>
                                    <td>
                                        <?=$income->op_date?>
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
        <h2 class="content-heading"><?=trans("customer_notes")?></h2>
        <div class="block block-rounded">
            <div class="block-content">
                <div class="alert alert-info" role="alert">
                    <p class="mb-0"><i class="fa fa-info-circle mr-5"></i><?=trans("customer_note_text")?></p>
                </div>
                <form action="<?=base_url("customers/editInfo/$item->cus_id")?>" method="post">
                    <div class="form-group row mb-10">
                        <div class="col-10 offset-1">
                            <textarea name="cus_info" id="js-ckeditor-inline"><?php if (isset($form_error)){ echo set_value('c_info'); }else{ echo $item->cus_info; }?></textarea>
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