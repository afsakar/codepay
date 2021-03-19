<?php $user = get_active_user()?>
<?php require "menu.php"; ?>
<nav id="sidebar">
    <!-- Sidebar Content -->
    <div class="sidebar-content">
        <!-- Side Header -->
        <div class="content-header content-header-fullrow px-15">
            <!-- Mini Mode -->
            <div class="content-header-section sidebar-mini-visible-b">
                <!-- Logo -->
                <span class="content-header-item font-w700 font-size-xl float-left animated fadeIn">
                    <span class="text-dual-primary-dark">c</span><span class="text-primary">p</span>
                </span>
                <!-- END Logo -->
            </div>
            <!-- END Mini Mode -->

            <!-- Normal Mode -->
            <div class="content-header-section text-center align-parent sidebar-mini-hidden">
                <!-- Close Sidebar, Visible only on mobile screens -->
                <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
                <button type="button" class="btn btn-circle btn-dual-secondary d-lg-none align-v-r" data-toggle="layout" data-action="sidebar_close">
                    <i class="fa fa-times text-danger"></i>
                </button>
                <!-- END Close Sidebar -->

                <!-- Logo -->
                <div class="content-header-item">
                    <a class="link-effect font-w700" href="<?=base_url()?>">
                        <i class="si si-wallet text-primary"></i>
                        <span class="font-size-xl text-dual-primary-dark">code</span><span class="font-size-xl text-primary">pay</span>
                    </a>
                </div>
                <!-- END Logo -->
            </div>
            <!-- END Normal Mode -->
        </div>
        <!-- END Side Header -->

        <!-- Side User -->
        <div class="content-side content-side-full content-side-user px-10 align-parent">
            <!-- Visible only in mini mode -->
            <div class="sidebar-mini-visible-b align-v animated fadeIn">
                <img class="img-avatar img-avatar32" src="<?=base_url("uploads/users/$user->img_url")?>" alt="">
            </div>
            <!-- END Visible only in mini mode -->

            <!-- Visible only in normal mode -->
            <div class="sidebar-mini-hidden-b text-center">
                <a class="img-link" href="<?=base_url("users/updateForm/$user->id")?>">
                    <img class="img-avatar" src="<?=base_url("uploads/users/$user->img_url")?>" alt="">
                </a>
                <ul class="list-inline mt-10">
                    <li class="list-inline-item">
                        <a class="link-effect text-dual-primary-dark font-size-sm font-w600 text-uppercase" href="<?=base_url("users/updateForm/$user->id")?>"><?=$user->user_name?></a>
                    </li>
                </ul>
            </div>
            <!-- END Visible only in normal mode -->
        </div>
        <!-- END Side User -->

        <!-- Side Navigation -->
        <div class="content-side content-side-full">
            <ul class="nav-main">
                <?php foreach ($menus as $mainUrl => $menu): if(!permission($menu['url'], 'show', false)) continue;?>
                    <li class="<?=$this->uri->segment(1) == $menu['url'] || (isset($menu['submenu']) && array_search($this->uri->segment(1), array_column($menu['submenu'], 'url')) !== false) ? 'open' : null?>">
                        <a href="<?=(isset($menu["submenu"]) ? "javascript:void(0)" : base_url($menu["url"]))?>"
                           class="<?php if (isset($menu['submenu'])): ?> nav-submenu <?php endif; ?> <?=$this->uri->segment(1) == $menu['url'] ? 'active' : null?>"
                            <?php if (isset($menu['submenu'])): ?> data-toggle="nav-submenu" <?php endif; ?>>
                            <i class="<?=$menu['icon'];?>"></i><span class="sidebar-mini-hide"><?=$menu['title'];?></span>
                        </a>
                        <?php if(isset($menu["submenu"])): ?>
                            <ul>
                                <?php foreach ($menu['submenu'] as $k => $submenu): if(!permission($submenu['url'], 'show', false)) continue;?>
                                    <li>
                                        <a href="<?=base_url($submenu['url'])?>" class="<?=$this->uri->segment(1) == $submenu['url'] ? 'active' : null?>"><?=$submenu['title'];?></a>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
        <!-- END Side Navigation -->
    </div>
    <!-- Sidebar Content -->
</nav>