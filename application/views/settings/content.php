<?php $langs = get_language_list(); ?>
<div class="content">
    <h2 class="content-heading"><?=$title?>
        <?php if(permission("settings", "edit")): ?>
            <a href="<?=base_url("settings/dbexport")?>" class="btn btn-alt-primary btn-sm pull-right">
                <i class="fa fa-database"></i> <?=trans("backup_database")?>
            </a>
        <?php endif; ?>
    </h2>
    <?=$breadcrumbs?>
    <!-- Full Table -->
    <div class="block">
        <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" href="#general"><?=trans("general")?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#company"><?=trans("company")?></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#theme"><?=trans("theme")?></a>
            </li>
        </ul>
        <form action="<?=base_url("settings/updateSetting")?>" method="post" enctype="multipart/form-data">
            <div class="block-content tab-content overflow-hidden">
                <div class="tab-pane fade show active" id="general" role="tabpanel">
                    <div class="col-md-10 offset-md-1">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label><?=trans("application_name")?></label>
                                <input type="text" class="form-control" name="settings[title]" value="<?=isset($form_error) ? set_value('settings[title]') : settings('title')?>">
                                <?php if(isset($form_error)): ?>
                                    <div class="form-text text-danger"><?=form_error('settings[title]')?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label><?=trans("current_language")?></label>
                                <select class="js-select2 form-control form-control-lg" id="current_language_id" name="settings[current_language_id]" style="width: 100%;">
                                    <?php foreach($langs as $lang):  ?>
                                    <option value="<?=$lang["id"]?>" <?php if(isset($form_error) && set_value('settings[current_language_id]') == $lang["id"] || settings("current_language_id") == $lang["id"]){echo "selected"; }else{ echo ""; } ?>><?=$lang["title"]?></option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if(isset($form_error)): ?>
                                    <div class="form-text text-danger"><?=form_error('settings[currency]')?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label><?=trans("currency")?></label>
                                <input type="text" class="form-control" name="settings[currency]" value="<?php if (isset($form_error)){ echo set_value('settings[currency]'); }else{ echo settings("currency"); } ?>">
                                <?php if(isset($form_error)): ?>
                                    <div class="form-text text-danger"><?=form_error('settings[currency]')?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label><?=trans("money_status")?></label>
                                <select class="js-select2 form-control form-control-lg" id="money_status" name="settings[money_status]" style="width: 100%;">
                                    <option value="before" <?php if(isset($form_error) && set_value('settings[money_status]') == "before" || settings("money_status") == "before"){echo "selected"; }else{ echo ""; } ?>><?=trans("before")?></option>
                                    <option value="after" <?php if(isset($form_error) && set_value('settings[money_status]') == "after" || settings("money_status") == "after"){echo "selected"; }else{ echo ""; } ?>><?=trans("after")?></option>
                                </select>
                                <?php if(isset($form_error)): ?>
                                    <div class="form-text text-danger"><?=form_error('settings[money_status]')?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label><?=trans("copyright")?></label>
                                <textarea name="settings[footer_text]" class="form-control" rows="5"><?php if (isset($form_error)){ echo set_value('settings[footer_text]'); }else{ echo settings("footer_text"); } ?></textarea>
                                <?php if(isset($form_error)): ?>
                                    <div class="form-text text-danger"><?=form_error('settings[footer_text]')?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="company" role="tabpanel">
                    <div class="col-md-10 offset-md-1">
                        <div class="form-group row">
                        <div class="col-md-6">
                            <label><?=trans("company_name")?></label>
                            <input type="text" class="form-control" name="settings[company_name]" value="<?php if (isset($form_error)){ echo set_value('settings[company_name]'); }else{ echo settings("company_name"); } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('settings[company_name]')?></div>
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6">
                            <label><?=trans("author_name")?></label>
                            <input type="text" class="form-control" name="settings[author_name]" value="<?php if (isset($form_error)){ echo set_value('settings[author_name]'); }else{ echo settings("author_name"); } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('settings[author_name]')?></div>
                            <?php endif; ?>
                        </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label><?=trans("phone")?></label>
                                <input type="tel" class="form-control" name="settings[phone]" value="<?php if (isset($form_error)){ echo set_value('settings[phone]'); }else{ echo settings("phone"); } ?>">
                                <?php if(isset($form_error)): ?>
                                    <div class="form-text text-danger"><?=form_error('settings[phone]')?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label><?=trans("fax")?></label>
                                <input type="tel" class="form-control" name="settings[fax]" value="<?php if (isset($form_error)){ echo set_value('settings[fax]'); }else{ echo settings("fax"); } ?>">
                                <?php if(isset($form_error)): ?>
                                    <div class="form-text text-danger"><?=form_error('settings[fax]')?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label><?=trans("gsm")?></label>
                                <input type="tel" class="form-control" name="settings[gsm]" value="<?php if (isset($form_error)){ echo set_value('settings[gsm]'); }else{ echo settings("gsm"); } ?>">
                                <?php if(isset($form_error)): ?>
                                    <div class="form-text text-danger"><?=form_error('settings[gsm]')?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label><?=trans("email")?></label>
                                <input type="email" class="form-control" name="settings[email]" value="<?php if (isset($form_error)){ echo set_value('settings[email]'); }else{ echo settings("email"); } ?>">
                                <?php if(isset($form_error)): ?>
                                    <div class="form-text text-danger"><?=form_error('settings[email]')?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label><?=trans("tax_office_name")?></label>
                                <input type="text" class="form-control" name="settings[tax_name]" value="<?php if (isset($form_error)){ echo set_value('settings[tax_name]'); }else{ echo settings("tax_name"); } ?>">
                                <?php if(isset($form_error)): ?>
                                    <div class="form-text text-danger"><?=form_error('settings[tax_name]')?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label><?=trans("tax_number")?></label>
                                <input type="text" class="form-control" name="settings[tax_number]" value="<?php if (isset($form_error)){ echo set_value('settings[tax_number]'); }else{ echo settings("tax_number"); } ?>">
                                <?php if(isset($form_error)): ?>
                                    <div class="form-text text-danger"><?=form_error('settings[tax_number]')?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label><?=trans("address")?></label>
                                <textarea name="settings[address]" rows="5" class="form-control"><?php if (isset($form_error)){ echo set_value('settings[address]'); }else{ echo settings("address"); } ?></textarea>
                                <?php if(isset($form_error)): ?>
                                    <div class="form-text text-danger"><?=form_error('settings[address]')?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="theme" role="tabpanel">
                    <div class="col-md-10 offset-md-1">
                        <div class="form-group row">
                            <div class="col-md-6 mb-20">
                                <img class="img-fluid-100 mb-10" height="50" src="<?=logo("logo")?>" alt="">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="logo" data-toggle="custom-file-input">
                                    <label class="custom-file-label" for="example-file-input-custom"><?=trans("logo_select")?></label>
                                </div>
                            </div>
                            <div class="col-md-6 mb-20">
                                <img class="img-fluid-100 mb-10" height="50" src="<?=logo("favicon")?>" alt="">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="favicon" data-toggle="custom-file-input">
                                    <label class="custom-file-label" for="example-file-input-custom"><?=trans("favicon_select")?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label><?=trans("dark_mode")?></label>
                                <select class="js-select2 form-control form-control-lg" id="menubar_mode" name="settings[dark_mode]" style="width: 100%;">
                                    <option value="open" <?php if(isset($form_error) && set_value('settings[dark_mode]') == "open" || settings("dark_mode") == "open"){echo "selected"; }else{ echo ""; } ?>><?=trans("open")?></option>
                                    <option value="close" <?php if(isset($form_error) && set_value('settings[dark_mode]') == "close" || settings("dark_mode") == "close"){echo "selected"; }else{ echo ""; } ?>><?=trans("close")?></option>
                                </select>
                                <?php if(isset($form_error)): ?>
                                    <div class="form-text text-danger"><?=form_error('settings[dark_mode]')?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label><?=trans("table_type")?></label>
                                <select class="js-select2 form-control form-control-lg" id="table_type" name="settings[table_type]" style="width: 100%;">
                                    <option value="datatable" <?php if(isset($form_error) && set_value('settings[table_type]') == "datatable" || settings("table_type") == "datatable"){echo "selected"; }else{ echo ""; } ?>>DataTable</option>
                                    <option value="normal" <?php if(isset($form_error) && set_value('settings[table_type]') == "normal" || settings("table_type") == "normal"){echo "selected"; }else{ echo ""; } ?>>Normal</option>
                                </select>
                                <?php if(isset($form_error)): ?>
                                    <div class="form-text text-danger"><?=form_error('settings[table_type]')?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label><?=trans("header_status")?></label>
                                <select class="js-select2 form-control form-control-lg" id="header_status" name="settings[header_status]" style="width: 100%;">
                                    <option value="fixed" <?php if(isset($form_error) && set_value('settings[header_status]') == "fixed" || settings("header_status") == "fixed"){echo "selected"; }else{ echo ""; } ?>><?=trans("fixed")?></option>
                                    <option value="unfixed" <?php if(isset($form_error) && set_value('settings[header_status]') == "unfixed" || settings("header_status") == "unfixed"){echo "selected"; }else{ echo ""; } ?>><?=trans("unfixed")?></option>
                                </select>
                                <?php if(isset($form_error)): ?>
                                    <div class="form-text text-danger"><?=form_error('settings[header_status]')?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label><?=trans("header_style")?></label>
                                <select class="js-select2 form-control form-control-lg" id="header_style" name="settings[header_style]" style="width: 100%;">
                                    <option value="classic" <?php if(isset($form_error) && set_value('settings[header_style]') == "classic" || settings("header_style") == "classic"){echo "selected"; }else{ echo ""; } ?>><?=trans("classic")?></option>
                                    <option value="transparent" <?php if(isset($form_error) && set_value('settings[header_style]') == "transparent" || settings("header_style") == "transparent"){echo "selected"; }else{ echo ""; } ?>><?=trans("transparent")?></option>
                                </select>
                                <?php if(isset($form_error)): ?>
                                    <div class="form-text text-danger"><?=form_error('settings[header_style]')?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label>Item</label>
                                <textarea name="settings[item]" class="js-summernote"><?php if (isset($form_error)){ echo set_value('settings[item]'); }else{ echo settings("item"); } ?></textarea>
                                <?php if(isset($form_error)): ?>
                                    <div class="form-text text-danger"><?=form_error('settings[item]')?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if(permission("settings", "edit")): ?>
                <div class="form-group row">
                    <div class="col-md-10 offset-md-1">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-alt-primary"><i class="si si-refresh"></i> <?=trans("update")?></button>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </form>
    </div>
    <!-- END Full Table -->
</div>