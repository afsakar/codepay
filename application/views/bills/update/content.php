<div class="content">
    <h2 class="content-heading d-print-none"><?=$title?> (#<?=$item->bill_number?>)
        <a href="<?=base_url("bills")?>" class="btn btn-alt-primary btn-sm pull-right">
            <i class="fa fa-arrow-left"></i> <?=trans("back")?>
        </a>
    </h2>
    <div class="d-print-none"><?=$breadcrumbs?></div>

    <!-- Full Table -->
    <div class="block repeater" >
        <form action="<?=base_url("bills/updateItem/$item->bill_id")?>" method="post">
            <div class="block-header block-header-default">
                <h3 class="block-title">
                    <input type="text" class="form-control-plaintext" value="<?=$item->bill_number?>" name="bill_number" placeholder="<?=trans("please_entry_bill_number")?>" required>
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
                <!-- bill Info -->
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
                        <div id="supplier-box">
                            <select name="sup_id" id="sup_id" class="form-control js-select2" data-url="<?=base_url("bills/getSupplier")?>" required>
                                <option><?=trans("please_select_product")?></option>
                                <?php foreach ($suppliers as $supplier): ?>
                                    <option value="<?=$supplier->sup_id?>" <?php if($item->sup_id == $supplier->sup_id){ echo "selected"; } ?>>
                                        <?=$supplier->sup_name?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div id="supplier_detail" class="d-none">
                        </div>
                    </div>
                    <!-- END Client Info -->

                </div>
                <!-- END bill Info -->

                <div class="m-20 row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-1 col-form-label"><?=trans("date")?>:</label>
                            <div class="col-11">
                                <input type="text" class="js-datepicker form-control-plaintext" id="example-datepicker1" value="<?=$item->bill_cre_date?>" placeholder="Select date" name="bill_cre_date" data-week-start="1" data-autoclose="true" data-today-highlight="true" data-date-format="yyyy/mm/dd" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-print-none text-right">
                        <a href="javascript:void(0)" data-repeater-create="" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> <?=trans("add_product")?></a>
                    </div>
                </div>

                <!-- Table -->
                <div class="table-responsive push">
                    <table class="table table-bordered table-hover" data-repeater-list="items">
                        <thead>
                        <tr>
                            <th class="text-center" style="width: 100px;"><?=trans("product_code")?></th>
                            <th><?=trans("product_name")?></th>
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
                        <?php foreach ($bill_items as $bill_item): ?>
                        <?php $getProduct = $this->products_model->get(array("pr_id" => $bill_item["pr_id"])); ?>
                        <tbody id="products" data-repeater-item>
                        <tr id="item">
                            <td class="text-center">
                                <input type="text" class="form-control-plaintext text-center pr_code" id="pr_code" name="[pr_code]" value="<?=$bill_item["pr_code"]?>" readonly>
                            </td>
                            <td>
                                <select name="[pr_id]" id="pr_id" class="form-control-plaintext products" data-url="<?=base_url("bills/getProduct")?>" data-placeholder="<?=trans("please_select_product")?>" required>
                                    <option></option>
                                    <?php foreach ($products as $product): ?>
                                        <option value="<?=$product->pr_id?>" <?php if($bill_item["pr_id"] == $product->pr_id){ echo "selected"; }?>>
                                            <?=$product->pr_name?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td class="text-center">
                                <input type="text" class="form-control-plaintext text-center pr_unit" id="pr_unit" name="[pr_unit]" value="<?=$bill_item["pr_unit"]?>" readonly>
                            </td>
                            <td class="text-center">
                                <input type="text" class="form-control-plaintext text-center pr_qnt" id="pr_qnt" name="[pr_qnt]" value="<?=$bill_item["pr_qnt"]?>">
                            </td>
                            <td class="text-center">
                                <input type="text" class="form-control-plaintext text-center pr_amount" id="pr_amount" name="[pr_amount]" value="<?=$getProduct->pr_amount?>" readonly>
                            </td>
                            <td class="text-center">
                                <input type="text" class="form-control-plaintext text-center pr_price" id="pr_price" name="[pr_price]" value="<?=$getProduct->pr_price?>" readonly>
                            </td>
                            <td class="text-center item_tax">
                                <?=$getProduct->pr_tax?>
                            </td>
                            <td class="d-none">
                                <input type="text" class="form-control-plaintext text-center pr_tax" id="pr_tax" name="[pr_tax]" value="<?=$bill_item["pr_qnt"] * $getProduct->pr_price?>" readonly>
                            </td>
                            <td class="text-center item_total">
                                <?php echo $bill_item["pr_qnt"] * $bill_item["pr_amount"]?>
                            </td>
                            <td class="d-print-none"><a href="#" class="btn fa fa-times text-danger" data-repeater-delete></a></td>
                        </tr>
                        </tbody>
                        <?php endforeach; ?>
                        <tfoot>
                        <tr>
                            <td colspan="7" class="font-w600 text-right"><?=trans("amount")?></td>
                            <td class="text-right bill_subtotal">
                                <?php
                                    $productValue = $bill_items;
                                    $totalSub = 0;
                                    foreach ($productValue as $key => $value)      {
                                        $totalSub += $value['pr_qnt'] * $value['pr_amount'];
                                    }
                                    echo sprintf('%0.2f',$totalSub);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="7" class="font-w600 text-right"><?=trans("tax")?></td>
                            <td class="text-right bill_total_tax">
                                <?php
                                $productValue = $bill_items;
                                $totalTax = 0;
                                foreach ($productValue as $key => $value)      {
                                    $totalTax += $value['pr_price'] * $value['pr_qnt'];
                                }
                                echo sprintf('%0.2f',$totalTax);
                                ?>
                            </td>
                        </tr>
                        <tr class="table-warning">
                            <td colspan="7" class="font-w700 text-uppercase text-right">Genel Toplam</td>
                            <td class="font-w700 text-right bill_total">
                                <?php
                                echo sprintf('%0.2f',$totalTax + $totalSub);
                                ?>
                            </td>
                        </tr>
                        <input type="hidden" class="form-control-plaintext text-center bill_total" id="bill_total" name="bill_total" value="" readonly>
                        </tfoot>
                    </table>
                </div>
                <!-- END Table -->

                <!-- Footer -->
                <p class="text-muted text-center">
                <div class="form-group row">
                    <div class="col-md-12">
                        <label class="d-print-none"><?=trans("description")?>:</label>
                        <textarea name="bill_description" class="form-control-plaintext text-center" rows="5" placeholder="<?=trans("description")?>..." required><?=$item->bill_description?></textarea>
                    </div>
                </div>
                </p>
                <!-- END Footer -->
            </div>
        </form>
    </div>
    <!-- END Full Table -->

</div>