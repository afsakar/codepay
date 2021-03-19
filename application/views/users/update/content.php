<?php require APPPATH."views/includes/menu.php"; ?>
<div class="content">
    <h2 class="content-heading"><?=$title?> (<?=$item->user_name?>)
        <a href="<?=base_url("users")?>" class="btn btn-alt-primary btn-sm pull-right">
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
            <?php if($userRole->user_type == "superadmin"): ?>
                <li class="nav-item">
                    <a class="nav-link" href="#permission"><?=trans("permission")?></a>
                </li>
            <?php endif; ?>
        </ul>
        <form action="<?=base_url("users/updateItem/$item->id")?>" method="post" enctype="multipart/form-data">
            <div class="block-content tab-content overflow-hidden">
                <div class="tab-pane fade show active" id="general" role="tabpanel">
                    <div class="col-md-8 offset-md-2">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <img class="img-avatar img-avatar-thumb" src="<?=base_url("uploads/$viewFolder/$item->img_url")?>" alt="">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="img_url" data-toggle="custom-file-input">
                                    <label class="custom-file-label" for="example-file-input-custom"><?=trans("select_image")?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-6">
                                <label><?=trans("user_name")?></label>
                                <input type="text" class="form-control" name="user_name" value="<?php if (isset($form_error)){ echo set_value('user_name'); }else{ echo $item->user_name; } ?>">
                                <?php if(isset($form_error)): ?>
                                    <div class="form-text text-danger"><?=form_error('user_name')?></div>
                                <?php endif; ?>
                            </div>
                            <div class="col-md-6">
                                <label><?=trans("name_surname")?></label>
                                <input type="text" class="form-control" name="full_name" value="<?php if (isset($form_error)){ echo set_value('full_name'); }else{ echo $item->full_name; } ?>">
                                <?php if(isset($form_error)): ?>
                                    <div class="form-text text-danger"><?=form_error('full_name')?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if($userRole->user_type == "superadmin"): ?>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label><?=trans("permission")?></label>
                                    <select class="js-select2 form-control form-control-lg" id="example-select2" name="user_type" style="width: 100%;" data-placeholder="Yetki seçin..">
                                        <option value="user" <?php if(isset($form_error) && set_value('user_type') == "user" || $item->user_type == "user"){echo "selected"; }else{ echo ""; } ?>>Kullanıcı</option>
                                        <option value="admin" <?php if(isset($form_error) && set_value('user_type') == "admin" || $item->user_type == "admin"){echo "selected"; }else{ echo ""; } ?>>Admin</option>
                                        <option value="superadmin" <?php if(isset($form_error) && set_value('user_type') == "superadmin" || $item->user_type == "superadmin"){echo "selected"; }else{ echo ""; } ?>>Superadmin</option>
                                    </select>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label><?=trans("email")?></label>
                                <input type="email" class="form-control" name="email" value="<?php if (isset($form_error)){ echo set_value('email'); }else{ echo $item->email; } ?>">
                                <?php if(isset($form_error)): ?>
                                    <div class="form-text text-danger"><?=form_error('email')?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php if($userRole->user_type == "superadmin"): ?>
                    <div class="tab-pane fade" id="permission" role="tabpanel">
                        <div class="col-md-8 offset-md-2 mb-10">
                            <?php foreach ($menus as $url => $menu): ?>
                                <hr>
                                <div class="font-w700">
                                    <?= $menu['title'] ?>
                                </div>
                                <?php foreach ($menu['permissions'] as $key => $val): ?>
                                    <label class="css-control css-control-primary css-checkbox">
                                        <input <?=(isset($permissions[$menu['url']][$key]) && $permissions[$menu['url']][$key] == "1" ? 'checked' : null)?>
                                                type="checkbox" class="css-control-input"
                                                name="permissions[<?= $menu['url'] ?>][<?= $key ?>]"
                                                value="1">
                                        <span class="css-control-indicator"></span> <?= $val ?>
                                    </label>
                                <?php endforeach; ?>
                                <?php if (isset($menu['submenu'])): ?>
                                    <div class="ml-20 p-10 pb-0" style="border-left: 4px solid #ddd;">
                                        <?php foreach ($menu['submenu'] as $k => $submenu): if (!isset($submenu['permissions'])) continue; ?>
                                            <div class="font-w700">
                                                <?= $submenu['title'] ?>
                                            </div>
                                            <?php foreach ($submenu['permissions'] as $key => $val): ?>
                                                <label class="css-control css-control-warning css-checkbox">
                                                    <input <?= (isset($permissions[$submenu['url']][$key]) && $permissions[$submenu['url']][$key] == "1" ? 'checked' : null) ?>
                                                            type="checkbox" class="css-control-input"
                                                            name="permissions[<?= $submenu['url'] ?>][<?= $key ?>]"
                                                            value="1">
                                                    <span class="css-control-indicator"></span> <?= $val ?>
                                                </label>
                                            <?php endforeach; ?>
                                        <?php endforeach; ?>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>

                        </div>
                    </div>
                <?php endif; ?>
                <div class="col-md-8 offset-md-2">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-alt-primary"><i class="fa fa-save"></i> <?=trans("update")?></button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <!-- END Full Table -->

</div>