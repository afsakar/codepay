<div class="content">
    <h2 class="content-heading"><?=$title?> (<?=$item->inc_title?>)
        <a href="<?=base_url("income_category")?>" class="btn btn-alt-primary btn-sm pull-right">
            <i class="fa fa-arrow-left"></i> <?=trans("back")?>
        </a>
    </h2>
    <?=$breadcrumbs?>
    <!-- Full Table -->
    <div class="block">
        <div class="block-content">
            <div class="col-md-8 offset-md-2">
                <form action="<?=base_url("incomes/editCategory/$item->inc_id")?>" method="post" enctype="multipart/form-data">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <label><?=trans("title")?></label>
                            <input type="text" class="form-control" name="inc_title" value="<?php if (isset($form_error)){ echo set_value('inc_title'); }else{ echo $item->inc_title; } ?>">
                            <?php if(isset($form_error)): ?>
                                <div class="form-text text-danger"><?=form_error('inc_title')?></div>
                            <?php endif; ?>
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