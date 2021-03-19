<?php
$user = get_active_user();
?>
<aside id="side-overlay">
    <!-- Side Header -->
    <div class="content-header content-header-fullrow">
        <div class="content-header-section align-parent">
            <!-- Close Side Overlay -->
            <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
            <button type="button" class="btn btn-circle btn-dual-secondary align-v-r" data-toggle="layout" data-action="side_overlay_close">
                <i class="fa fa-times text-danger"></i>
            </button>
            <!-- END Close Side Overlay -->

            <!-- User Info -->
            <div class="content-header-item">
                <a class="img-link mr-5" href="<?=base_url("users/updateForm/$user->id")?>">
                    <img class="img-avatar img-avatar32" src="<?=base_url("uploads/users/$user->img_url")?>" alt="">
                </a>
                <a class="align-middle link-effect text-primary-dark font-w600" href="<?=base_url("users/updateForm/$user->id")?>"><?=$user->full_name?></a>
            </div>
            <!-- END User Info -->
        </div>
    </div>
    <!-- END Side Header -->

    <!-- Side Content -->
    <div class="content-side">
        <!-- Settings -->
        <div class="block pull-r-l">
            <div class="block-header bg-body-light">
                <h3 class="block-title">
                    <i class="fa fa-fw fa-wrench font-size-default mr-5"></i><?=trans("quick_settings")?>
                </h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
                </div>
            </div>
            <div class="block-content">
                <div class="row gutters-tiny">
                    <h6 class="dropdown-header"><?=trans("theme_color")?></h6>
                    <div class="row no-gutters text-center col-12 mb-5">
                        <div class="col-2">
                            <a class="text-default" data-toggle="theme" data-theme="default" href="javascript:void(0)">
                                <i class="fa fa-2x fa-circle"></i>
                            </a>
                        </div>
                        <div class="col-2">
                            <a class="text-elegance" data-toggle="theme" data-theme="<?=base_url("assets")?>/css/themes/elegance.min.css" href="javascript:void(0)">
                                <i class="fa fa-2x fa-circle"></i>
                            </a>
                        </div>
                        <div class="col-2">
                            <a class="text-pulse" data-toggle="theme" data-theme="<?=base_url("assets")?>/css/themes/pulse.min.css" href="javascript:void(0)">
                                <i class="fa fa-2x fa-circle"></i>
                            </a>
                        </div>
                        <div class="col-2">
                            <a class="text-flat" data-toggle="theme" data-theme="<?=base_url("assets")?>/css/themes/flat.min.css" href="javascript:void(0)">
                                <i class="fa fa-2x fa-circle"></i>
                            </a>
                        </div>
                        <div class="col-2">
                            <a class="text-corporate" data-toggle="theme" data-theme="<?=base_url("assets")?>/css/themes/corporate.min.css" href="javascript:void(0)">
                                <i class="fa fa-2x fa-circle"></i>
                            </a>
                        </div>
                        <div class="col-2">
                            <a class="text-earth" data-toggle="theme" data-theme="<?=base_url("assets")?>/css/themes/earth.min.css" href="javascript:void(0)">
                                <i class="fa fa-2x fa-circle"></i>
                            </a>
                        </div>
                    </div>
                    <h6 class="dropdown-header"><?=trans("header")?></h6>
                    <div class="row no-gutters text-center col-12 mb-5">
                        <div class="col-6 pr-10">
                            <button type="button" class="btn btn-sm btn-block btn-alt-secondary" data-toggle="layout" data-action="header_fixed_toggle">Sabit</button>
                        </div>
                        <div class="col-6 pr-10">
                            <button type="button" class="btn btn-sm btn-block btn-alt-secondary d-none d-lg-block mb-10" data-toggle="layout" data-action="header_style_classic">Klasik Stil</button>
                        </div>
                        <div class="col-6 pr-10">
                            <button type="button" class="btn btn-sm btn-block btn-alt-secondary mb-10" data-toggle="layout" data-action="header_style_inverse_off">Açık</button>
                        </div>
                        <div class="col-6 pr-10">
                            <button type="button" class="btn btn-sm btn-block btn-alt-secondary mb-10" data-toggle="layout" data-action="header_style_inverse_on">Koyu</button>
                        </div>
                    </div>
                    <h6 class="dropdown-header"><?=trans("menubar")?></h6>
                    <div class="row no-gutters text-center col-12 mb-5">
                        <div class="col-6 pr-10">
                            <button type="button" class="btn btn-sm btn-block btn-alt-secondary mb-10" data-toggle="layout" data-action="sidebar_style_inverse_off">Açık</button>
                        </div>
                        <div class="col-6 pr-10">
                            <button type="button" class="btn btn-sm btn-block btn-alt-secondary mb-10" data-toggle="layout" data-action="sidebar_style_inverse_on">Koyu</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Settings -->

        <!-- Mini Stats -->
        <div class="block pull-r-l">
            <div class="block-content block-content-full block-content-sm bg-body-light">
                <div class="row">
                    <div class="col-4">
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Clients</div>
                        <div class="font-size-h4">460</div>
                    </div>
                    <div class="col-4">
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Sales</div>
                        <div class="font-size-h4">728</div>
                    </div>
                    <div class="col-4">
                        <div class="font-size-sm font-w600 text-uppercase text-muted">Earnings</div>
                        <div class="font-size-h4">$7,860</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END Mini Stats -->

        <!-- Friends -->
        <div class="block pull-r-l">
            <div class="block-header bg-body-light">
                <h3 class="block-title"><i class="fa fa-fw fa-users font-size-default mr-5"></i>Friends</h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                        <i class="si si-refresh"></i>
                    </button>
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
                </div>
            </div>
            <div class="block-content">
                <ul class="nav-users push">
                    <li>
                        <a href="be_pages_generic_profile.html">
                            <img class="img-avatar" src="<?=base_url("assets")?>/media/avatars/avatar2.jpg" alt="">
                            <i class="fa fa-circle text-success"></i> Judy Ford
                            <div class="font-w400 font-size-xs text-muted">Photographer</div>
                        </a>
                    </li>
                    <li>
                        <a href="be_pages_generic_profile.html">
                            <img class="img-avatar" src="<?=base_url("assets")?>/media/avatars/avatar11.jpg" alt="">
                            <i class="fa fa-circle text-success"></i> Jose Wagner
                            <div class="font-w400 font-size-xs text-muted">Web Designer</div>
                        </a>
                    </li>
                    <li>
                        <a href="be_pages_generic_profile.html">
                            <img class="img-avatar" src="<?=base_url("assets")?>/media/avatars/avatar1.jpg" alt="">
                            <i class="fa fa-circle text-warning"></i> Megan Fuller
                            <div class="font-w400 font-size-xs text-muted">UI Designer</div>
                        </a>
                    </li>
                    <li>
                        <a href="be_pages_generic_profile.html">
                            <img class="img-avatar" src="<?=base_url("assets")?>/media/avatars/avatar13.jpg" alt="">
                            <i class="fa fa-circle text-danger"></i> Albert Ray
                            <div class="font-w400 font-size-xs text-muted">Copywriter</div>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- END Friends -->

        <!-- Activity -->
        <div class="block pull-r-l">
            <div class="block-header bg-body-light">
                <h3 class="block-title">
                    <i class="fa fa-fw fa-clock-o font-size-default mr-5"></i>Activity
                </h3>
                <div class="block-options">
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                        <i class="si si-refresh"></i>
                    </button>
                    <button type="button" class="btn-block-option" data-toggle="block-option" data-action="content_toggle"></button>
                </div>
            </div>
            <div class="block-content">
                <ul class="list list-activity">
                    <li>
                        <i class="si si-wallet text-success"></i>
                        <div class="font-w600">+$29 New sale</div>
                        <div>
                            <a href="javascript:void(0)">Admin Template</a>
                        </div>
                        <div class="font-size-xs text-muted">5 min ago</div>
                    </li>
                    <li>
                        <i class="si si-close text-danger"></i>
                        <div class="font-w600">Project removed</div>
                        <div>
                            <a href="javascript:void(0)">Best Icon Set</a>
                        </div>
                        <div class="font-size-xs text-muted">26 min ago</div>
                    </li>
                    <li>
                        <i class="si si-pencil text-info"></i>
                        <div class="font-w600">You edited the file</div>
                        <div>
                            <a href="javascript:void(0)">
                                <i class="fa fa-file-text-o"></i> Docs.doc
                            </a>
                        </div>
                        <div class="font-size-xs text-muted">3 hours ago</div>
                    </li>
                    <li>
                        <i class="si si-plus text-success"></i>
                        <div class="font-w600">New user</div>
                        <div>
                            <a href="javascript:void(0)">StudioWeb - View Profile</a>
                        </div>
                        <div class="font-size-xs text-muted">5 hours ago</div>
                    </li>
                    <li>
                        <i class="si si-wrench text-warning"></i>
                        <div class="font-w600">App v5.5 is available</div>
                        <div>
                            <a href="javascript:void(0)">Update now</a>
                        </div>
                        <div class="font-size-xs text-muted">8 hours ago</div>
                    </li>
                    <li>
                        <i class="si si-user-follow text-pulse"></i>
                        <div class="font-w600">+1 Friend Request</div>
                        <div>
                            <a href="javascript:void(0)">Accept</a>
                        </div>
                        <div class="font-size-xs text-muted">1 day ago</div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- END Activity -->
    </div>
    <!-- END Side Content -->
</aside>