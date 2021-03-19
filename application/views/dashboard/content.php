<div class="content">
    <!-- Calendar and Events functionality is initialized in js/pages/be_comp_calendar.min.js which was auto compiled from _es6/pages/be_comp_calendar.js -->
    <!-- For more info and examples you can check out https://fullcalendar.io/ -->
    <div class="block">
        <div class="block-content">
            <div class="row items-push">
                <div class="col-xl-3">
                    <div class="block-header">
                        <h5 class="block-title"><?= trans("add_event") ?></h5>
                    </div>
                    <!-- Add Event Form -->
                    <form action="<?= base_url("dashboard/addItem") ?>" method="post">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="<?= trans("add_event") ?>" name="title"
                                   required>
                        </div>
                        <div class="form-group">
                            <input type="text" class="js-flatpickr form-control bg-white" id="start_date"
                                   name="start_date" placeholder="<?= trans("start_date") ?>" required
                                   data-week-start="1" data-autoclose="true" data-today-highlight="true"
                                   data-date-format="Y/m/d">
                        </div>
                        <div class="form-group">
                            <input type="text" class="js-flatpickr form-control bg-white" id="end_date" name="end_date"
                                   placeholder="<?= trans("end_date") ?>" required data-week-start="1"
                                   data-autoclose="true" data-today-highlight="true" data-date-format="Y/m/d">
                        </div>
                        <div class="form-group">
                            <div class="js-colorpicker input-group" data-format="hex">
                                <input type="text" class="form-control" id="example-colorpicker2" name="bgColor"
                                       placeholder="<?= trans("background_color") ?>" required>
                                <div class="input-group-append">
                                    <span class="input-group-text colorpicker-input-addon">
                                        <i></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="js-colorpicker input-group" data-format="hex">
                                <input type="text" class="form-control" id="example-colorpicker2" name="textColor"
                                       placeholder="<?= trans("text_color") ?>" required>
                                <div class="input-group-append">
                                    <span class="input-group-text colorpicker-input-addon">
                                        <i></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-alt-primary btn-block"><i
                                        class="fa fa-save"></i> <?= trans("save") ?></button>
                        </div>
                    </form>
                    <!-- END Add Event Form -->
                </div>
                <div class="col-xl-9 calendarContainer">
                    <!-- Calendar Container -->
                    <div id='calendar'></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="block mb-0 bg-pattern"
                 style="background-image: url('<?= base_url("assets") ?>/media/various/bg-pattern-inverse.png');">
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