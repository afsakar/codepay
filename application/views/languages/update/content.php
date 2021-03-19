<div class="content">
    <h2 class="content-heading"><?=$title?> (<?=$item->title?>)
        <a href="<?=base_url("languages")?>" class="btn btn-alt-primary btn-sm pull-right">
            <i class="fa fa-arrow-left"></i> <?=trans("back")?>
        </a>
    </h2>
    <?=$breadcrumbs?>
    <!-- Full Table -->
    <div class="block">
        <div class="block-content">
            <div class="col-md-8 offset-md-2">
                <form action="<?=base_url("languages/updateItem/$item->id")?>" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label><?=trans("language_name")?></label>
                            <input type="text" class="form-control" name="title" value="<?php if (isset($form_error)){ echo set_value('title'); }else{ echo $item->title; } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('title')?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label><?=trans("language_code")?></label>
                            <input type="text" class="form-control" name="code" value="<?php if (isset($form_error)){ echo set_value('code'); }else{ echo $item->code; } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('code')?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label><?=trans("folder_name")?></label>
                            <input type="text" class="form-control" name="folder_name" value="<?php if (isset($form_error)){ echo set_value('folder_name'); }else{ echo $item->folder_name; } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('folder_name')?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <button type="submit" class="btn btn-alt-primary"><i class="si si-refresh"></i> <?=trans("update")?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- END Full Table -->

</div>