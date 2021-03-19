<div class="content">
    <h2 class="content-heading"><?=$title?>
        <?php if(permission("forward_transactions", "add")): ?>
            <a href="<?=base_url("forward_transactions/addForm")?>" class="btn btn-alt-primary btn-sm pull-right">
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
                        <th><?=trans("date")?></th>
                        <th><?=trans("description")?></th>
                        <th><?=trans("account_name")?></th>
                        <th><?=trans("price")?></th>
                        <th><?=trans("category")?></th>
                        <th><?=trans("type")?></th>
                        <th class="text-center" style="width: 100px;"><?=trans("actions")?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($items as $item): ?>
                    <?php
                    $account = $this->accounts_model->get(array("acc_id" => $item->acc_id));
                        if($item->transaction_type == "income"){
                            if($item->cus_sup_id != 0){
                                $customer = $this->customers_model->get(array("cus_id" => $item->cus_sup_id));
                            }else{
                                $customer = "";
                            }
                        }else{
                            if($item->cus_sup_id != 0){
                                $supplier = $this->suppliers_model->get(array("sup_id" => $item->cus_sup_id));
                            }else{
                                $supplier = "";
                            }
                        }
                        ?>
                    <tr id="ord-<?=$item->op_id?>">
                        <td class="d-none"></td>
                        <td class="font-w600">
                            <?=$item->op_date?>
                        </td>
                        <td class="font-w600">
                            <?php
                            if($item->cus_sup_id != 0){
                                if($item->transaction_type == "income"){
                                    echo $customer->cus_name;
                                }else{
                                    echo $supplier->sup_name;
                                }
                            }
                             ?> <?=$item->op_description?>
                        </td>
                        <td class="font-w600">
                            <?=$account->acc_name?>
                        </td>
                        <td class="font-w600">
                            <?= currencyFormat($item->op_price) ?>
                        </td>
                        <td class="font-w600">
                            <?php
                            if($item->transaction_type == "income"){
                                echo "<span class='badge badge-success'>".trans("income")."</span>";
                            }else{
                                echo "<span class='badge badge-danger'>".trans("expense")."</span>";
                            }
                            ?>
                        </td>
                        <td class="font-w600">
                            <?=trans("$item->op_type")?>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <?php if(permission("forward_transactions", "add")): ?>
                                <a href="<?php echo base_url("forward_transactions/updateForm/$item->op_id")?>" type="button" class="btn btn-sm btn-secondary">
                                    <i class="fa fa-check"></i>
                                </a>
                                <?php endif; ?>
                                <?php if(permission("forward_transactions", "delete")): ?>
                                    <button data-url="<?php echo base_url("forward_transactions/deleteItem/$item->op_id")?>"
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