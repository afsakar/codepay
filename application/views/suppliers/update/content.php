<div class="content">
    <h2 class="content-heading"><?=$title?> (<?=$item->sup_name?>)
        <a href="<?=base_url("suppliers")?>" class="btn btn-alt-primary btn-sm pull-right">
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
                <form action="<?=base_url("suppliers/updateItem/$item->sup_id")?>" method="post" enctype="multipart/form-data">
                    <div class="block-content tab-content overflow-hidden">
                        <div class="tab-pane fade show active" id="general" role="tabpanel">
                            <div class="form-group row">
                                <div class="col-md-12 mb-20">
                                    <label><?=trans("logo")?></label>
                                    <div>
                                        <img class="mb-3 mt-3" src="<?=base_url("uploads/$viewFolder/$item->sup_logo")?>" width="150" alt="">
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" name="sup_logo" data-toggle="custom-file-input">
                                        <label class="custom-file-label" for="suppliers-file-input-custom"><?=trans("select_image")?></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label><?=trans("supplier_name")?></label>
                                    <input type="text" class="form-control" name="sup_name" value="<?php if (isset($form_error)){ echo set_value('sup_name'); }else{ echo $item->sup_name; } ?>">
                                    <?php if(isset($form_error)): ?>
                                        <div class="form-text text-danger"><?=form_error('sup_name')?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label><?=trans("supplier_owner")?></label>
                                    <input type="text" class="form-control" name="sup_owner" value="<?php if (isset($form_error)){ echo set_value('sup_owner'); }else{ echo $item->sup_owner; } ?>">
                                    <?php if(isset($form_error)): ?>
                                        <div class="form-text text-danger"><?=form_error('sup_owner')?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <label><?=trans("supplier_owner_phone")?></label>
                                    <input type="text" class="js-masked-phone form-control" id="suppliers-masked-phone" name="sup_owner_phone" placeholder="(999) 999-9999" value="<?php if (isset($form_error)){ echo set_value('sup_owner_phone'); }else{ echo $item->sup_owner_phone; } ?>">
                                    <?php if(isset($form_error)): ?>
                                        <div class="form-text text-danger"><?=form_error('sup_owner_phone')?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label><?=trans("phone")?></label>
                                    <input type="text" class="js-masked-phone form-control" id="suppliers-masked-phone" name="sup_phone" placeholder="(999) 999-9999" value="<?php if (isset($form_error)){ echo set_value('sup_phone'); }else{ echo $item->sup_phone; } ?>">
                                    <?php if(isset($form_error)): ?>
                                        <div class="form-text text-danger"><?=form_error('sup_phone')?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <label><?=trans("fax")?></label>
                                    <input type="text" class="js-masked-phone form-control" id="suppliers-masked-phone" name="sup_fax" placeholder="(999) 999-9999" value="<?php if (isset($form_error)){ echo set_value('sup_fax'); }else{ echo $item->sup_fax; } ?>">
                                    <?php if(isset($form_error)): ?>
                                        <div class="form-text text-danger"><?=form_error('sup_fax')?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label><?=trans("gsm")?></label>
                                    <input type="text" class="js-masked-phone form-control" id="suppliers-masked-phone" name="sup_gsm" placeholder="(999) 999-9999" value="<?php if (isset($form_error)){ echo set_value('sup_gsm'); }else{ echo $item->sup_gsm; } ?>">
                                    <?php if(isset($form_error)): ?>
                                        <div class="form-text text-danger"><?=form_error('sup_gsm')?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <label><?=trans("email")?></label>
                                    <input type="email" class="form-control" name="sup_email" value="<?php if (isset($form_error)){ echo set_value('sup_email'); }else{ echo $item->sup_email; } ?>">
                                    <?php if(isset($form_error)): ?>
                                        <div class="form-text text-danger"><?=form_error('sup_email')?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label><?=trans("tax_office_name")?></label>
                                    <input type="text" class="form-control" name="sup_tax_office" value="<?php if (isset($form_error)){ echo set_value('sup_tax_office'); }else{ echo $item->sup_tax_office; } ?>">
                                    <?php if(isset($form_error)): ?>
                                        <div class="form-text text-danger"><?=form_error('sup_tax_office')?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <label><?=trans("tax_number")?></label>
                                    <input type="text" class="form-control" name="sup_tax_number" value="<?php if (isset($form_error)){ echo set_value('sup_tax_number'); }else{ echo $item->sup_tax_number; } ?>">
                                    <?php if(isset($form_error)): ?>
                                        <div class="form-text text-danger"><?=form_error('sup_tax_number')?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label><?=trans("address")?></label>
                                    <textarea name="sup_address" rows="5" class="form-control"><?php if (isset($form_error)){ echo set_value('sup_address'); }else{ echo $item->sup_address; } ?></textarea>
                                    <?php if(isset($form_error)): ?>
                                        <div class="form-text text-danger"><?=form_error('sup_address')?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <label><?=trans("debit")?></label>
                                    <input type="text" class="form-control" name="sup_debit" value="<?php if (isset($form_error)){ echo set_value('sup_debit'); }else{ echo $item->sup_debit; } ?>">
                                    <?php if(isset($form_error)): ?>
                                        <div class="form-text text-danger"><?=form_error('sup_debit')?></div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-6">
                                    <label><?=trans("credit")?></label>
                                    <input type="text" class="form-control" name="sup_credit" value="<?php if (isset($form_error)){ echo set_value('sup_credit'); }else{ echo $item->sup_credit; } ?>">
                                    <?php if(isset($form_error)): ?>
                                        <div class="form-text text-danger"><?=form_error('sup_credit')?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="notes" role="tabpanel">
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label><?=trans("company_notes")?></label>
                                    <textarea name="sup_info" class="js-summernote"><?php if (isset($form_error)){ echo set_value('sup_info'); }else{ echo $item->sup_info; }?></textarea>
                                    <?php if(isset($form_error)): ?>
                                        <div class="form-text text-danger"><?=form_error('sup_info')?></div>
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