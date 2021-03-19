<?php require APPPATH . "language/$item->folder_name/site_lang.php"; ?>
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
            <div class="col-md-10 offset-md-1">
                <div class="form-group row">
                    <div class="col-md-12">
                        <input type="text" id="search" placeholder="<?=trans("search")?>" class="form-control"></input>
                    </div>
                </div>
                <form action="<?=base_url("languages/updateWords/$item->id")?>" method="post" enctype="multipart/form-data">
                    <div class="table-responsive">
                        <table class="table table-vcenter table-hover table-container js-dataTable-full">
                            <thead>
                                <tr>
                                    <th class="text-center w-50"><?=trans("reference")?></th>
                                    <th class="text-center w-50"><?=trans("value")?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($lang as $key => $value): ?>
                                    <tr>
                                        <td class="text-center">
                                            <span class="d-none"><?=$key?></span>
                                            <input type="text" class="form-control" value="<?=$key?>" disabled>
                                        </td>
                                        <td class="text-center">
                                            <span class="d-none"><?=$value?></span>
                                            <input type="text" name="lang[<?=$key?>]" class="form-control" value="<?=$value?>">
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
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