<div class="content">
    <h2 class="content-heading"><?=$title?> (<?=$item->title?>)
        <a href="<?=base_url("email_templates")?>" class="btn btn-alt-primary btn-sm pull-right">
            <i class="fa fa-arrow-left"></i> <?=trans("back")?>
        </a>
    </h2>
    <?=$breadcrumbs?>
    <!-- Full Table -->
    <div class="block">
        <div class="block-content">
            <div class="col-md-8 offset-md-2">
                <form action="<?=base_url("email_templates/updateItem/$item->id")?>" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label><?=trans("title")?></label>
                            <input type="text" class="form-control" name="title" value="<?php if (isset($form_error)){ echo set_value('title'); }else{ echo $item->title; } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('title')?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12">
                            <textarea name="body" class="js-summernote-air"><?php if (isset($form_error)){ echo set_value('body'); }else{ echo $item->body; }?></textarea>
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('body')?></div>
                            <?php endif; ?>
                        </div>
                    </div>
                    <?php if($veriables): ?>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label><?=trans("veriables")?></label>
                                <input type="text" class="form-control" disabled value="<?php foreach ($veriables as $veriable): ?><?=$veriable->veriable_name." "?><?php endforeach; ?>">
                                <small><?=trans("veriable_helper")?></small>
                                <?php if(isset($form_error)): ?>
                                    <div class="form-text text-danger"><?=form_error('veriable_name')?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endif; ?>
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