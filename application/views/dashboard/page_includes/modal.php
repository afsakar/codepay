<?php if ($calendar): ?>
    <?php $cookie = get_cookie("events"); ?>
    <?php if ($cookie != "true"): ?>
        <div class="modal fade" id="modal-onboarding" tabindex="-1" role="dialog" aria-labelledby="modal-onboarding"
             aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-popout" role="document">
                <div class="modal-content rounded">
                    <div class="block block-rounded block-transparent mb-0 bg-pattern"
                         style="background-image: url('<?= base_url("assets") ?>/media/various/bg-pattern-inverse.png');">
                        <div class="block-header justify-content-end">
                            <h5 class="block-title">Bugünkü İşlemler</h5>
                            <div class="block-options">
                                <button class="font-w600 btn btn-link text-danger dontShow" data-dismiss="modal" data-url="<?= base_url("dashboard/dontShowAgain") ?>">
                                    <?= trans("dont_show_again") ?>
                                </button>
                                <a class="font-w600 btn btn-sm btn-primary" href="#" data-dismiss="modal" aria-label="Close">
                                    <?= trans("close") ?>
                                </a>
                            </div>
                        </div>
                        <div class="block-content block-content-full">
                            <div class="pb-50">
                                <div class="row justify-content-center text-center">
                                    <div class="col-md-12">
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
                                                                <?php if (settings("money_status") == "after"): ?>
                                                                    <?= number_format($forwardTrans->op_price, 2) . " " . settings("currency") ?>
                                                                <?php else: ?>
                                                                    <?= settings("currency") . " " . number_format($forwardTrans->op_price, 2) ?>
                                                                <?php endif; ?>
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>