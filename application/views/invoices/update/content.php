<div class="content">
    <h2 class="content-heading d-print-none"><?=$title?> (#<?=$item->inv_number?>)
        <a href="<?=base_url("invoices")?>" class="btn btn-alt-primary btn-sm pull-right">
            <i class="fa fa-arrow-left"></i> <?=trans("back")?>
        </a>
    </h2>
    <div class="d-print-none"><?=$breadcrumbs?></div>

    <!-- Full Table -->
    <div class="block repeater" >
        <form action="<?=base_url("invoices/updateItem/$item->inv_id")?>" method="post">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    <input type="text" class="form-control-plaintext" value="<?=$item->inv_number?>" name="inv_number" placeholder="<?=trans("please_entry_invoice_number")?>" required>
                </h3>
                <div class="block-options">
                    <!-- Print Page functionality is initialized in Helpers.print() -->
                    <button type="button" class="btn-block-option" onclick="Codebase.helpers('print-page');">
                        <i class="si si-printer"></i> <?=trans("print")?>
                    </button>
                    <button type="submit" class="btn-block-option" id="saveItem">
                        <i class="fa fa-save"></i> <?=trans("save")?>
                    </button>
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                </div>
            </div>
            <div class="block-content">
                <!-- Invoice Info -->
                <div class="row my-20">
                    <!-- Company Info -->
                    <div class="col-6">
                        <img src="<?=logo("logo")?>" width="250" class="img-fluid-100 mb-20" alt="">
                        <p class="h3"><?=settings("company_name")?></p>
                        <address>
                            <span class="font-weight-bold"><?=trans("address")?>:</span> <?=settings("address")?><br>
                            <span class="font-weight-bold"><?=trans("phone")?>:</span> <?=settings("phone")?><br>
                            <span class="font-weight-bold"><?=trans("tax_office_name")?>:</span> <?=settings("tax_name")?><br>
                            <span class="font-weight-bold"><?=trans("tax_number")?>:</span> <?=settings("tax_number")?><br>
                            <span class="font-weight-bold"><?=trans("email")?>:</span> <?=settings("email")?><br>
                        </address>
                    </div>
                    <!-- END Company Info -->
                    <!-- Client Info -->
                    <div class="col-6 text-right">
                        <div id="customer-box">
                            <select name="cus_id" id="cus_id" class="form-control js-select2" data-url="<?=base_url("invoices/getCustomer")?>" required>
                                <option><?=trans("please_select_service")?></option>
                                <?php foreach ($customers as $customer): ?>
                                    <option value="<?=$customer->cus_id?>" <?php if($item->cus_id == $customer->cus_id){ echo "selected"; } ?>>
                                        <?=$customer->cus_name?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div id="customer_detail" class="d-none">
                        </div>
                    </div>
                    <!-- END Client Info -->

                </div>
                <!-- END Invoice Info -->

                <div class="m-20 row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-1 col-form-label"><?=trans("date")?>:</label>
                            <div class="col-11">
                                <input type="text" class="js-datepicker form-control-plaintext" id="example-datepicker1" value="<?=$item->inv_cre_date?>" placeholder="Select date" name="inv_cre_date" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="yyyy/mm/dd" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-print-none text-right">
                        <a href="javascript:void(0)" data-repeater-create="" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> <?=trans("add_service")?></a>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive push">
                    <table class="table table-bordered table-hover" data-repeater-list="items">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 100px;"><?=trans("product_code")?></th>
                            <th><?=trans("service_name")?></th>
                            <th class="text-center" style="width: 90px;"><?=trans("unit")?></th>
                            <th class="text-center" style="width: 90px;"><?=trans("quantity")?></th>
                            <th class="text-center" style="width: 120px;"><?=trans("amount")?></th>
                            <th class="text-center" style="width: 120px;"><?=trans("tax")?></th>
                            <th class="text-center" style="width: 90px;"><?=trans("tax_rate")?></th>
                            <th class="d-none" style="width: 90px;">KDV Tutarı</th>
                            <th class="text-center" style="width: 120px;"><?=trans("base_amount")?></th>
                            <th class="d-print-none" width="50"></th>
                        </tr>
                        </thead>
                        <?php foreach ($inv_items as $inv_item): ?>
                        <?php $getService = $this->services_model->get(array("sr_id" => $inv_item["sr_id"])); ?>
                        <tbody id="products" data-repeater-item>
                        <tr id="item">
                            <td class="text-center">
                                <input type="text" class="form-control-plaintext text-center sr_code" id="sr_code" name="[sr_code]" value="<?=$inv_item["sr_code"]?>" readonly>
                            </td>
                            <td>
                                <select name="[sr_id]" id="sr_id" class="form-control-plaintext services" data-url="<?=base_url("invoices/getService")?>" data-placeholder="<?=trans("please_select_service")?>" required>
                                    <option></option>
                                    <?php foreach ($services as $service): ?>
                                        <option value="<?=$service->sr_id?>" <?php if($inv_item["sr_id"] == $service->sr_id){ echo "selected"; }?>>
                                            <?=$service->sr_name?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td class="text-center">
                                <input type="text" class="form-control-plaintext text-center sr_unit" id="sr_unit" name="[sr_unit]" value="<?=$inv_item["sr_unit"]?>" readonly>
                            </td>
                            <td class="text-center">
                                <input type="text" class="form-control-plaintext text-center sr_qnt" id="sr_qnt" name="[sr_qnt]" value="<?=$inv_item["sr_qnt"]?>">
                            </td>
                            <td class="text-center">
                                <input type="text" class="form-control-plaintext text-center sr_amount" id="sr_amount" name="[sr_amount]" value="<?=$getService->sr_amount?>" readonly>
                            </td>
                            <td class="text-center">
                                <input type="text" class="form-control-plaintext text-center sr_price" id="sr_price" name="[sr_price]" value="<?=$getService->sr_price?>" readonly>
                            </td>
                            <td class="text-center item_tax">
                                <?=$getService->sr_tax?>
                            </td>
                            <td class="d-none">
                                <input type="text" class="form-control-plaintext text-center sr_tax" id="sr_tax" name="[sr_tax]" value="<?=$inv_item["sr_qnt"] * $getService->sr_price?>" readonly>
                            </td>
                            <td class="text-center item_total">
                                <?php echo $inv_item["sr_qnt"] * $inv_item["sr_amount"]?>
                            </td>
                            <td class="d-print-none"><a href="#" class="btn fa fa-times text-danger" data-repeater-delete></a></td>
                        </tr>
                        </tbody>
                        <?php endforeach; ?>
                        <tfoot>
                        <tr>
                            <td colspan="7" class="font-w600 text-right"><?=trans("amount")?></td>
                            <td class="text-right inv_subtotal">
                                <?php
                                    $serviceValue = $inv_items;
                                    $totalSub = 0;
                                    foreach ($serviceValue as $key => $value)      {
                                        $totalSub += $value['sr_qnt'] * $value['sr_amount'];
                                    }
                                    echo sprintf('%0.2f',$totalSub);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7" class="font-w600 text-right"><?=trans("tax")?></td>
                            <td class="text-right inv_total_tax">
                                <?php
                                $serviceValue = $inv_items;
                                $totalTax = 0;
                                foreach ($serviceValue as $key => $value)      {
                                    $totalTax += $value['sr_price'] * $value['sr_qnt'];
                                }
                                echo sprintf('%0.2f',$totalTax);
                                ?>
                            </td>
                        </tr>
                        <tr class="table-warning">
                            <td colspan="7" class="font-w700 text-uppercase text-right">Genel Toplam</td>
                            <td class="font-w700 text-right inv_total">
                                <?php
                                echo sprintf('%0.2f',$totalTax + $totalSub);
                                ?>
                            </td>
                        </tr>
                        <input type="hidden" class="form-control-plaintext text-center inv_total" id="inv_total" name="inv_total" value="" readonly>
                        </tfoot>
                    </table>
                </div>
                <!-- END Table -->

                <!-- Footer -->
                <p class="text-muted text-center">
                <div class="form-group row">
                    <div class="col-md-12">
                        <label class="d-print-none"><?=trans("description")?>:</label>
                        <textarea name="inv_description" class="form-control-plaintext text-center" rows="5" placeholder="<?=trans("description")?>..." required><?=$item->inv_description?></textarea>
                    </div>
                </div>
                </p>
                <!-- END Footer -->
            </div>
        </form>
    </div>
    <!-- END Full Table -->

</div>