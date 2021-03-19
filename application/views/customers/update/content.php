<div class="content">
    <h2 class="content-heading"><?=$title?> (<?=$item->cus_name?>)
        <a href="<?=base_url("customers")?>" class="btn btn-alt-primary btn-sm pull-right">
            <i class="fa fa-arrow-left"></i> <?=trans("back")?>
        </a>
    </h2>
    <?=$breadcrumbs?>
    <!-- Full Table -->
    <div class="block">
        <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" href="#general"><?=trans("general")?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#notes"><?=trans("notes")?></a>
            </li>
        </ul>
        <div class="block-content">
            <div class="col-md-8 offset-md-2">
                <form action="<?=base_url("customers/updateItem/$item->cus_id")?>" method="post" enctype="multipart/form-data">
                    <div class="block-content tab-content overflow-hidden">
                        <div class="tab-pane fade show active" id="general" role="tabpanel">
                            <div class="form-group row">
                                <div class="col-md-12 mb-20">
                                    <label><?=trans("logo")?></label>
                                    <div>
                                        <img class="mb-3 mt-3" src="<?=base_url("uploads/$viewFolder/$item->cus_logo")?>" width="150" alt="">
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="cus_logo" data-toggle="custom-file-input">
                                        <label class="custom-file-label" for="customers-file-input-custom"><?=trans("select_image")?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label><?=trans("customer_name")?></label>
                                    <input type="text" class="form-control" name="cus_name" value="<?php if (isset($form_error)){ echo set_value('cus_name'); }else{ echo $item->cus_name; } ?>">
                                    <?php if(isset($form_error)): ?>
                                        <div class="form-text text-danger"><?=form_error('cus_name')?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label><?=trans("customer_owner")?></label>
                                    <input type="text" class="form-control" name="cus_owner" value="<?php if (isset($form_error)){ echo set_value('cus_owner'); }else{ echo $item->cus_owner; } ?>">
                                    <?php if(isset($form_error)): ?>
                                        <div class="form-text text-danger"><?=form_error('cus_owner')?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <label><?=trans("customer_owner_phone")?></label>
                                    <input type="text" class="js-masked-phone form-control" id="customers-masked-phone" name="cus_owner_phone" placeholder="(999) 999-9999" value="<?php if (isset($form_error)){ echo set_value('cus_owner_phone'); }else{ echo $item->cus_owner_phone; } ?>">
                                    <?php if(isset($form_error)): ?>
                                        <div class="form-text text-danger"><?=form_error('cus_owner_phone')?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label><?=trans("phone")?></label>
                                    <input type="text" class="js-masked-phone form-control" id="customers-masked-phone" name="cus_phone" placeholder="(999) 999-9999" value="<?php if (isset($form_error)){ echo set_value('cus_phone'); }else{ echo $item->cus_phone; } ?>">
                                    <?php if(isset($form_error)): ?>
                                        <div class="form-text text-danger"><?=form_error('cus_phone')?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <label><?=trans("fax")?></label>
                                    <input type="text" class="js-masked-phone form-control" id="customers-masked-phone" name="cus_fax" placeholder="(999) 999-9999" value="<?php if (isset($form_error)){ echo set_value('cus_fax'); }else{ echo $item->cus_fax; } ?>">
                                    <?php if(isset($form_error)): ?>
                                        <div class="form-text text-danger"><?=form_error('cus_fax')?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label><?=trans("gsm")?></label>
                                    <input type="text" class="js-masked-phone form-control" id="customers-masked-phone" name="cus_gsm" placeholder="(999) 999-9999" value="<?php if (isset($form_error)){ echo set_value('cus_gsm'); }else{ echo $item->cus_gsm; } ?>">
                                    <?php if(isset($form_error)): ?>
                                        <div class="form-text text-danger"><?=form_error('cus_gsm')?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <label><?=trans("email")?></label>
                                    <input type="email" class="form-control" name="cus_email" value="<?php if (isset($form_error)){ echo set_value('cus_email'); }else{ echo $item->cus_email; } ?>">
                                    <?php if(isset($form_error)): ?>
                                        <div class="form-text text-danger"><?=form_error('cus_email')?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label><?=trans("tax_office_name")?></label>
                                    <input type="text" class="form-control" name="cus_tax_office" value="<?php if (isset($form_error)){ echo set_value('cus_tax_office'); }else{ echo $item->cus_tax_office; } ?>">
                                    <?php if(isset($form_error)): ?>
                                        <div class="form-text text-danger"><?=form_error('cus_tax_office')?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <label><?=trans("tax_number")?></label>
                                    <input type="text" class="form-control" name="cus_tax_number" value="<?php if (isset($form_error)){ echo set_value('cus_tax_number'); }else{ echo $item->cus_tax_number; } ?>">
                                    <?php if(isset($form_error)): ?>
                                        <div class="form-text text-danger"><?=form_error('cus_tax_number')?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label><?=trans("address")?></label>
                                    <textarea name="cus_address" rows="5" class="form-control"><?php if (isset($form_error)){ echo set_value('cus_address'); }else{ echo $item->cus_address; } ?></textarea>
                                    <?php if(isset($form_error)): ?>
                                        <div class="form-text text-danger"><?=form_error('cus_address')?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label><?=trans("debit")?></label>
                                    <input type="text" class="form-control" name="cus_debit" value="<?php if (isset($form_error)){ echo set_value('cus_debit'); }else{ echo $item->cus_debit; } ?>">
                                    <?php if(isset($form_error)): ?>
                                        <div class="form-text text-danger"><?=form_error('cus_debit')?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <label><?=trans("credit")?></label>
                                    <input type="text" class="form-control" name="cus_credit" value="<?php if (isset($form_error)){ echo set_value('cus_credit'); }else{ echo $item->cus_credit; } ?>">
                                    <?php if(isset($form_error)): ?>
                                        <div class="form-text text-danger"><?=form_error('cus_credit')?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="notes" role="tabpanel">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label><?=trans("company_notes")?></label>
                                    <textarea name="cus_info" class="js-summernote"><?php if (isset($form_error)){ echo set_value('cus_info'); }else{ echo $item->cus_info; }?></textarea>
                                    <?php if(isset($form_error)): ?>
                                        <div class="form-text text-danger"><?=form_error('cus_info')?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-alt-primary"><i class="fa fa-save"></i> <?=trans("update")?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END Full Table -->

</div>