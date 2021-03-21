<?php $user = get_active_user(); ?>
<?php $langs = get_language_list(); ?>
<header id="page-header">
    <!-- Header Content -->
    <div class="content-header">
        <!-- Left Section -->
        <div class="content-header-section">
            <!-- Toggle Sidebar -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <button type="button" class="btn btn-circle btn-dual-secondary" data-toggle="layout" data-action="sidebar_toggle">
                <i class="fa fa-navicon"></i>
            </button>
            <!-- END Toggle Sidebar -->
            <!-- Notifications -->
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-notifications" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-flag"></i>
                    <span class="badge badge-primary badge-pill">
                        <?php
                        $code = ($this->session->userdata('site_lang') == '') ? settings("current_language_id") : $this->session->userdata('site_lang');
                        echo get_lang_short_code($code);
                        ?>
                    </span>
                </button>
                <div class="dropdown-menu dropdown-menu-left min-width-150" aria-labelledby="page-header-notifications">
                    <h5 class="h6 text-center py-10 mb-0 border-b text-uppercase"><?=trans("language")?></h5>
                    <ul class="list-unstyled my-20">
                        <?php foreach($langs as $lang):  ?>
                            <?php
                            $code = ($this->session->userdata('site_lang') == '') ? settings("current_language_id") : $this->session->userdata('site_lang');
                            ?>
                        <li>
                            <a class="text-body-color-dark media mb-15" href="<?= base_url('dashboard/site_lang/'.$lang['id']) ?>">
                                <div class="ml-5 mr-15">
                                    <?php if(get_lang_short_code($code) == $lang["code"]): ?>
                                    <i class="fa fa-fw fa-check text-success"></i>
                                    <?php else: ?>
                                    <i class="fa fa-fw fa-times text-danger"></i>
                                    <?php endif; ?>
                                </div>
                                <div class="media-body pr-10">
                                    <p class="mb-0"><?= $lang['title'] ?></p>
                                </div>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
            <!-- END Notifications -->
        </div>
        <!-- END Left Section -->

        <!-- Right Section -->
        <div class="content-header-section">
            <!-- User Dropdown -->
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-rounded btn-dual-secondary" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-user d-sm-none"></i>
                    <span class="d-none d-sm-inline-block"><?=$user->full_name?></span>
                    <i class="fa fa-angle-down ml-5"></i>
                </button>
                <div class="dropdown-menu dropdown-menu-right min-width-200" aria-labelledby="page-header-user-dropdown">
                    <h5 class="h6 text-center py-10 mb-5 border-b text-uppercase"><?=$user->user_name?></h5>
                    <a class="dropdown-item" href="<?=base_url("users/updateForm/$user->id")?>">
                        <i class="si si-user mr-5"></i> <?=trans("profile")?>
                    </a>
                    <a class="dropdown-item" href="<?=base_url("invoices")?>">
                        <i class="si si-note mr-5"></i> <?=trans("invoices")?>
                    </a>
                    <div class="dropdown-divider"></div>

                    <!-- Toggle Side Overlay -->
                    <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                    <a class="dropdown-item" href="<?=base_url("settings")?>">
                        <i class="si si-wrench mr-5"></i> <?=trans("settings")?>
                    </a>
                    <!-- END Side Overlay -->

                    <div class="dropdown-divider"></div>
                    <div class="logout">
                        <button class="dropdown-item logout-btn"
                                data-title="<?=trans("logout_title")?>"
                                data-text="<?=trans("logout_text")?>"
                                data-confirm="<?=trans("logout_button_confirm")?>"
                                data-cancel="<?=trans("logout_button_cancel")?>"
                                data-url="<?=base_url('logout')?>">
                            <i class="si si-logout mr-5"></i> <?=trans("logout")?>
                        </button>
                    </div>
                </div>
            </div>
            <!-- END User Dropdown -->
        </div>
        <!-- END Right Section -->
    </div>
    <!-- END Header Content -->

    <!-- Header Loader -->
    <!-- Please check out the Activity page under Elements category to see examples of showing/hiding it -->
    <div id="page-header-loader" class="overlay-header bg-primary">
        <div class="content-header content-header-fullrow text-center">
            <div class="content-header-item">
                <i class="fa fa-sun-o fa-spin text-white"></i>
            </div>
        </div>
    </div>
    <!-- END Header Loader -->
</header>