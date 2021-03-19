<?php $user = get_active_user(); ?>
<div class="content">
    <h2 class="content-heading"><?=$title?>
        <?php if($userRole->user_type == "superadmin"): ?>
            <a href="<?=base_url("users/addForm")?>" class="btn btn-alt-primary btn-sm pull-right">
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
                            <th class="text-center" style="width: 100px;"><i class="fa fa-hashtag"></i></th>
                            <th><?=trans("name_surname")?></th>
                            <th><?=trans("user_name")?></th>
                            <th><?=trans("created_at")?></th>
                            <th><?=trans("permission")?></th>
                            <?php if($userRole->user_type == "superadmin"): ?>
                                <th><?=trans("status")?></th>
                            <?php endif; ?>
                            <th class="text-center" style="width: 100px;"><?=trans("actions")?></th>
                        </tr>
                        </thead>
                        <tbody data-url="<?php echo base_url("users/rankSetter")?>">
                        <?php foreach ($items as $item): ?>
                        <tr>
                            <td class="text-center">
                                <?=$item->id?>
                            </td>
                            <td class="font-w600 nav-users push">
                                <li style="list-style: none;">
                                    <a href="<?php echo base_url("users/updateForm/$item->id")?>">
                                        <img class="img-avatar img-avatar48 clearfix" src="<?=base_url("uploads/$viewFolder/$item->img_url")?>" alt="">
                                        <i class="fa fa-circle <?=$item->isOnline == 1 ? "text-success" : "text-danger"?>"></i> <?=$item->full_name?>
                                        <div class="font-w400 font-size-xs text-muted"><?=$item->email?></div>
                                    </a>
                                </li>
                            </td>
                            <td><?=$item->user_name?></td>
                            <td><?=timeConvert($item->createdAt)?></td>
                            <td><?=$item->user_type?></td>
                            <?php if($userRole->user_type == "superadmin"): ?>
                                <td>
                                    <?php if( $user->user_name != $item->user_name ): ?>
                                        <label class="css-control css-control-sm css-control-primary css-switch">
                                            <input type="checkbox" class="css-control-input isActive" id="block-form-remember-me<?=$item->id?>" data-url="<?php echo base_url("users/isActiveSetter/$item->id")?>" <?=$item->isActive == 1 ? 'checked' : null?>>
                                            <span class="css-control-indicator"></span>
                                        </label>
                                    <?php endif; ?>
                                </td>
                            <?php endif; ?>
                            <td class="text-center">
                                <div class="btn-group">
                                    <a href="<?php echo base_url("users/password/$item->id")?>" type="button" class="btn btn-sm btn-secondary">
                                        <i class="fa fa-key"></i>
                                    </a>
                                    <a href="<?php echo base_url("users/updateForm/$item->id")?>" type="button" class="btn btn-sm btn-secondary">
                                        <i class="fa fa-pencil"></i>
                                    </a>
                                    <?php if($userRole->user_type == "superadmin"): ?>
                                        <?php if($item->id != $userRole->id): ?>
                                            <button data-url="<?php echo base_url("users/deleteItem/$item->id")?>"
                                                    data-title="<?=trans("delete_title")?>"
                                                    data-text="<?=trans("delete_text")?>"
                                                    data-confirm="<?=trans("delete_button_confirm")?>"
                                                    data-cancel="<?=trans("delete_button_cancel")?>"
                                                    type="button" class="btn btn-sm btn-secondary remove-btn">
                                                <i class="fa fa-times"></i>
                                            </button>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php if(settings("table_type") == "normal"): ?>
                        <?=$links?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <!-- END Full Table -->

</div>