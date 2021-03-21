<div class="content">

    <div class="row mb-20">
        <div class="col-12">
            <div class="row gutters-tiny">
                <!-- Row #1 -->
                <div class="col-md-6 col-xl-3">
                    <a class="block block-link-shadow text-right" href="<?=base_url("accounts")?>">
                        <div class="block-content block-content-full clearfix">
                            <div class="float-left mt-10">
                                <i class="fa fa-money fa-3x text-body-bg-dark"></i>
                            </div>
                            <div class="font-size-h3 font-w600"><?=getSum($accounts, "acc_balance")?></div>
                            <div class="font-size-sm font-w600 text-uppercase text-muted">KASA</div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-xl-3">
                    <a class="block block-link-shadow text-right" href="javascript:void(0)">
                        <div class="block-content block-content-full clearfix">
                            <div class="float-left mt-10">
                                <i class="si si-wallet fa-3x text-body-bg-dark"></i>
                            </div>
                            <div class="font-size-h3 font-w600">
                                <?php

                                $incomeTotal = "";
                                $expenseTotal = "";

                                foreach ($dailyIncome as $income) {
                                    $incomeTotal .= $income->op_price;
                                }

                                if($incomeTotal != 0){
                                    $incomeTotal = $incomeTotal;
                                }else{
                                    $incomeTotal = 0;
                                }

                                foreach ($dailyExpense as $expense) {
                                    $expenseTotal .= $expense->op_price;
                                }

                                if($expenseTotal != 0){
                                    $expenseTotal = $expenseTotal;
                                }else{
                                    $expenseTotal = 0;
                                }

                                echo currencyFormat($incomeTotal-$expenseTotal);
                                ?>
                            </div>
                            <div class="font-size-sm font-w600 text-uppercase text-muted">Günlük Kâr-Zarar</div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-xl-3">
                    <a class="block block-link-shadow text-left" href="<?=base_url("products")?>">
                        <div class="block-content block-content-full clearfix">
                            <div class="float-right mt-10">
                                <i class="si si-handbag fa-3x text-body-bg-dark"></i>
                            </div>
                            <div class="font-size-h3 font-w600"><?=$products->num_rows()?></div>
                            <div class="font-size-sm font-w600 text-uppercase text-muted">Ürün</div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-xl-3">
                    <a class="block block-link-shadow text-left"href="<?=base_url("services")?>">
                        <div class="block-content block-content-full clearfix">
                            <div class="float-right mt-10">
                                <i class="si si-wrench fa-3x text-body-bg-dark"></i>
                            </div>
                            <div class="font-size-h3 font-w600"><?=$services->num_rows()?></div>
                            <div class="font-size-sm font-w600 text-uppercase text-muted">Hizmet</div>
                        </div>
                    </a>
                </div>
                <!-- END Row #1 -->
            </div>
        </div>
    </div>

    <div class="block">
        <div class="block-header justify-content-end">
            <h5 class="block-title">Aylık Resmi Gelir-Gider Durumu</h5>
        </div>
        <div class="block-content">
            <div class="row gutters-tiny">
                <div class="col-md-6">
                    <a class="block" href="javascript:void(0)">
                        <div class="block-content block-content-full">
                            <div class="row py-20 text-center text-success">
                                <div class="col-6 border-r">
                                    <div class="font-size-h3 font-w600">
                                        <?=getSum($invoices, "inv_total")?>
                                    </div>
                                    <div class="font-size-sm font-w600 text-uppercase text-muted"><?=trans("invoice_list")?></div>
                                </div>
                                <div class="col-6">
                                    <div class="font-size-h3 font-w600">
                                        <?=getSum($incomesOff, "op_price")?>
                                    </div>
                                    <div class="font-size-sm font-w600 text-uppercase text-muted"><?=trans("income")?></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6">
                    <a class="block" href="javascript:void(0)">
                        <div class="block-content block-content-full">
                            <div class="row py-20 text-center text-danger">
                                <div class="col-6 border-r">
                                    <div class="font-size-h3 font-w600">
                                        <?=getSum($bills, "bill_total")?>
                                    </div>
                                    <div class="font-size-sm font-w600 text-uppercase text-muted"><?=trans("bill_list")?></div>
                                </div>
                                <div class="col-6">
                                    <div class="font-size-h3 font-w600">
                                        <?=getSum($expensesOff, "op_price")?>
                                    </div>
                                    <div class="font-size-sm font-w600 text-uppercase text-muted"><?=trans("expense")?></div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="block mb-0">
                <div class="block-header justify-content-end">
                    <h5 class="block-title">Bugünkü İşlemler</h5>
                </div>
                <div class="block-content block-content-full">
                    <?php if ($calendar): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                <th><i class="fa fa-hashtag"></i></th>
                                <th><?= trans("start_date") ?></th>
                                <th><?= trans("end_date") ?></th>
                                <th><?= trans("description") ?></th>
                                <th><?= trans("type") ?></th>
                                <th><?= trans("price") ?></th>
                                <th><?= trans("account_name") ?></th>
                                </thead>
                                <tbody>
                                <?php $count = 1;
                                foreach ($calendar as $value): ?>
                                    <?php
                                    if ($value->fw_id == 1) {
                                        $forwardTrans = $this->forward_transactions_model->get(array("op_description" => $value->title));
                                        $account = $this->accounts_model->get(array("acc_id" => $forwardTrans->acc_id));
                                    } else {
                                        $forwardTrans = "";
                                        $account = "";
                                    }
                                    ?>
                                    <tr>
                                        <td><?= $count++ ?></td>
                                        <td><?= date("d/m/Y", strtotime($value->start_date)) ?></td>
                                        <td><?= date("d/m/Y", strtotime($value->end_date)) ?></td>
                                        <td><?= $value->title ?></td>
                                        <?php if ($forwardTrans): ?>
                                            <td>
                                                <span class="badge badge-primary"><?= trans("$forwardTrans->transaction_type") ?></span>
                                            </td>
                                        <?php else: ?>
                                            <td>
                                                <span class="badge badge-primary">Etkinlik</span>
                                            </td>
                                        <?php endif; ?>
                                        <?php if ($forwardTrans): ?>
                                            <td>
                                                <?= currencyFormat($forwardTrans->op_price) ?>
                                            </td>
                                        <?php else: ?>
                                            <td>-</td>
                                        <?php endif; ?>

                                        <?php if ($forwardTrans): ?>
                                            <td>
                                                <?= $account->acc_name ?>
                                            </td>
                                        <?php else: ?>
                                            <td>-</td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="col-md-6 offset-md-3 text-center alert alert-success"><i
                                    class="fa fa-check-circle"></i> Bugün herhangi bir işlem yok.
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>