<div class="content">
    <h2 class="content-heading"><?=$title?>
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
                <?php if(settings("table_type") == "normal"): ?>
                    <input type="text" id="search" placeholder="<?=trans("search")?>" class="form-control"></input>
                <?php endif; ?>
                <table class="table table-striped table-vcenter table-hover table-container<?php if(settings("table_type") == "datatable"): ?> js-dataTable-full<?php endif; ?>">
                    <thead>
                    <tr>
                        <th class="text-center" style="width: 100px;"><i class="fa fa-hashtag"></i></th>
                        <th><?=trans("title")?></th>
                        <th><?=trans("url")?></th>
                        <th><?=trans("subject")?></th>
                        <th><?=trans("created_at")?></th>
                        <th class="text-center" style="width: 100px;"><?=trans("actions")?></th>
                    </tr>
                    </thead>
                    <tbody data-url="<?php echo base_url("email_templates/rankSetter")?>">
                    <?php foreach ($items as $item): ?>
                    <tr id="ord-<?=$item->id?>">
                        <td class="text-center">
                            <?=$item->id?>
                        </td>
                        <td class="font-w600">
                            <?=$item->title?>
                        </td>
                        <td class="font-w600">
                            <?=$item->url?>
                        </td>
                        <td class="font-w600">
                            <?=$item->subject?>
                        </td>
                        <td class="font-w600">
                            <?=timeConvert($item->createdAt)?>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <?php if(permission("email_templates", "edit")): ?>
                                <a href="<?php echo base_url("email_templates/updateForm/$item->id")?>" type="button" class="btn btn-sm btn-secondary">
                                    <i class="fa fa-pencil"></i>
                                </a>
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