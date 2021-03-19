<div class="content">
    <h2 class="content-heading d-print-none"><?= $title ?>
        <a href="<?= base_url("accounts") ?>" class="btn btn-alt-primary btn-sm pull-right">
            <i class="fa fa-arrow-left"></i> <?= trans("back") ?>
        </a>
    </h2>
    <div class="d-print-none"><?= $breadcrumbs ?></div>
    <!-- Full Table -->
    <div class="block repeater">
        <form action="<?= base_url("accounts/extract/$item->acc_id") ?>" method="post" name="getDate">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    <div class="row">
                        <div class="col-md-8 offset-md-2">
                            <div class="input-daterange input-group" data-date-format="yyyy/mm/dd" data-week-start="1"
                                 data-autoclose="true" data-today-highlight="true">
                                <input type="text" class="form-control-plaintext" id="example-daterange1" name="start_date"
                                       placeholder="<?= trans("start_date") ?>" data-week-start="1" data-autoclose="true"
                                       data-today-highlight="true" value="<?= $this->input->post("start_date") ?? $firstDay ?>">
                                <div class="input-group-prepend input-group-append">
                                    <span class="input-group-text font-w600 border-0">-</span>
                                </div>
                                <input type="text" class="form-control-plaintext" id="example-daterange2" name="end_date"
                                       placeholder="<?= trans("end_date") ?>" data-week-start="1" data-autoclose="true"
                                       data-today-highlight="true" value="<?= $this->input->post("end_date") ?? $lastDay ?>">
                            </div>
                        </div>
                    </div>
                </h3>
                <div class="block-options">
                    <!-- Print Page functionality is initialized in Helpers.print() -->
                    <button type="button" class="btn-block-option" onclick="Codebase.helpers('print-page');">
                        <i class="si si-printer"></i> <?= trans("print") ?>
                    </button>
                    <button type="submit" class="btn-block-option" id="saveItem" name="getDate">
                        <i class="fa fa-save"></i> <?= trans("save") ?>
                    </button>
                    <button type="button" class="btn-block-option" data-toggle="block-option"
                            data-action="fullscreen_toggle"></button>
                </div>
            </div>
            <div class="block-content">
                <!-- Invoice Info -->
                <div class="row my-20">
                    <!-- Company Info -->
                    <div class="col-6">
                        <img src="<?= logo("logo") ?>" width="250" class="img-fluid-100 mb-20" alt="">
                        <p class="h3"><?= settings("company_name") ?></p>
                        <address>
                            <span class="font-weight-bold"><?= trans("address") ?>:</span> <?= settings("address") ?>
                            <br>
                            <span class="font-weight-bold"><?= trans("phone") ?>:</span> <?= settings("phone") ?><br>
                            <span class="font-weight-bold"><?= trans("tax_office_name") ?>:</span> <?= settings("tax_name") ?>
                            <br>
                            <span class="font-weight-bold"><?= trans("tax_number") ?>:</span> <?= settings("tax_number") ?>
                            <br>
                            <span class="font-weight-bold"><?= trans("email") ?>:</span> <?= settings("email") ?><br>
                        </address>
                    </div>
                    <!-- END Company Info -->

                    <!-- Client Info -->
                    <div class="col-6 text-right">
                        <div id="customer-box">
                            <p class="h3"><?= $item->acc_name ?></p>
                            <address>
                                <span class="font-weight-bold"><?= trans("account_owner") ?>:</span> <?= $item->acc_owner ?>
                                <br>
                                <span class="font-weight-bold"><?= trans("bank_name") ?>:</span> <?= $item->acc_bank_name ?>
                                <br>
                                <span class="font-weight-bold"><?= trans("branch_name") ?>:</span> <?= $item->acc_branch_name ?>
                                <br>
                                <span class="font-weight-bold"><?= trans("branch_code") ?>:</span> <?= $item->acc_branch_number ?>
                                <br>
                                <span class="font-weight-bold"><?= trans("account_iban") ?>:</span> <?= $item->acc_iban ?>
                                <br>
                                <span class="font-weight-bold"><?= trans("balance") ?>:</span>
                                <?= currencyFormat($item->acc_balance) ?><br>
                            </address>
                        </div>
                        <div id="customer_detail" class="d-none mt-50">
                        </div>
                    </div>
                    <!-- END Client Info -->
                </div>
                <!-- END Invoice Info -->
                <!-- Table -->
                <div class="table-responsive push">
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th style="width: 90px;"><?= trans("date") ?></th>
                            <th class="text-center"><?= trans("description") ?></th>
                            <th class="text-center" style="width: 200px;"><?= trans("category") ?></th>
                            <th class="text-center" style="width: 120px;"><?= trans("type") ?></th>
                            <th class="text-center" style="width: 200px;"><?= trans("price") ?></th>
                        </tr>
                        </thead>
                        <tbody id="products">
                        <?php foreach ($incomes as $income): ?>
                            <?php $inc = $this->income_category_model->get(array("inc_id" => $income->inc_id)); ?>
                            <tr>
                                <td class="text-center">
                                    <?= $income->op_date ?>
                                </td>
                                <td>
                                    <?= $income->op_description ?>
                                </td>
                                <td class="text-center">
                                    <?= $inc->inc_title ?? "" ?>
                                </td>
                                <td class="text-center">
                                    <?= trans($income->op_type) ?>
                                </td>
                                <td class="text-right item_tax">
                                    <?= currencyFormat($income->op_price) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        <?php foreach ($expenses as $expens): ?>
                            <?php $exc = $this->expense_category_model->get(array("exc_id" => $expens->exc_id)); ?>
                            <tr>
                                <td class="text-center">
                                    <?= $expens->op_date ?>
                                </td>
                                <td>
                                    <?= $expens->op_description ?>
                                </td>
                                <td class="text-center">
                                    <?= $exc->exc_title ?? "" ?>
                                </td>
                                <td class="text-center">
                                    <?= trans($expens->op_type) ?>
                                </td>
                                <td class="text-right item_tax">
                                    <?= currencyFormat($expens->op_price) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan="4" class="font-w600 text-right text-uppercase"><?= trans("income") ?></td>
                            <td class="text-right inv_subtotal">
                                <?php
                                $incomeTotal = "";
                                foreach ($incSum as $income) {
                                    $incomeTotal .= $income->op_price;
                                }
                                echo $incomeTotal ? currencyFormat($incomeTotal) : currencyFormat(0);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" class="font-w600 text-right text-uppercase"><?= trans("expense") ?></td>
                            <td class="text-right inv_total_tax">
                                <?php
                                $expenseTotal = "";
                                foreach ($expSum as $expens) {
                                    $expenseTotal .= $expens->op_price;
                                }
                                echo $expenseTotal ? currencyFormat($expenseTotal) : currencyFormat(0);
                                ?>
                            </td>
                        </tr>
                        <tr class="table-warning">
                            <td colspan="4" class="font-w700 text-uppercase text-right">Genel Toplam</td>
                            <td class="font-w700 text-right inv_total">
                                <?php
                                if ($incomeTotal == 0 && $expenseTotal == 0) {
                                    echo currencyFormat(0);
                                } else {
                                    echo currencyFormat(($incomeTotal != 0 ? $incomeTotal : 0) - ($expenseTotal != 0 ? $expenseTotal : 0));
                                }
                                ?>
                            </td>
                        </tr>
                        <input type="hidden" class="form-control-plaintext text-center inv_total" id="inv_total"
                               name="inv_total" value="" readonly>
                        </tfoot>
                    </table>
                </div>
                <!-- END Table -->
            </div>
        </form>
    </div>
    <!-- END Full Table -->

</div>