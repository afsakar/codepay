<!doctype html>
<html lang="tr" class="no-focus">
<head>
    <?php $this->load->view('includes/head'); ?>
    <title><?=$title?> | <?=settings("title")?></title>
</head>
<body>

<!-- Page Container -->
<!--
    Available classes for #page-container:

GENERIC

    'enable-cookies'                            Remembers active color theme between pages (when set through color theme helper Template._uiHandleTheme())

SIDEBAR & SIDE OVERLAY

    'sidebar-r'                                 Right Sidebar and left Side Overlay (default is left Sidebar and right Side Overlay)
    'sidebar-mini'                              Mini hoverable Sidebar (screen width > 991px)
    'sidebar-o'                                 Visible Sidebar by default (screen width > 991px)
    'sidebar-o-xs'                              Visible Sidebar by default (screen width < 992px)
    'sidebar-inverse'                           Dark themed sidebar

    'side-overlay-hover'                        Hoverable Side Overlay (screen width > 991px)
    'side-overlay-o'                            Visible Side Overlay by default

    'enable-page-overlay'                       Enables a visible clickable Page Overlay (closes Side Overlay on click) when Side Overlay opens

    'side-scroll'                               Enables custom scrolling on Sidebar and Side Overlay instead of native scrolling (screen width > 991px)

HEADER

    ''                                          Static Header if no class is added
    'page-header-fixed'                         Fixed Header

HEADER STYLE

    ''                                          Classic Header style if no class is added
    'page-header-modern'                        Modern Header style
    'page-header-inverse'                       Dark themed Header (works only with classic Header style)
    'page-header-glass'                         Light themed Header with transparency by default
                                                (absolute position, perfect for light images underneath - solid light background on scroll if the Header is also set as fixed)
    'page-header-glass page-header-inverse'     Dark themed Header with transparency by default
                                                (absolute position, perfect for dark images underneath - solid dark background on scroll if the Header is also set as fixed)

MAIN CONTENT LAYOUT

    ''                                          Full width Main Content if no class is added
    'main-content-boxed'                        Full width Main Content with a specific maximum width (screen width > 1200px)
    'main-content-narrow'                       Full width Main Content with a percentage width (screen width > 1200px)
-->
<div id="page-container" class="enable-cookies sidebar-o enable-page-overlay side-scroll
<?php if(settings("header_style") == "classic"){echo " "; }else{ echo " page-header-modern "; } ?>
<?php if(settings("header_status") == "unfixed"){echo " "; }else{ echo " page-header-fixed "; } ?>
<?php if(settings("dark_mode") == "open"){echo " sidebar-inverse "; }else{ echo " "; } ?>
<?php if(settings("dark_mode") == "open" && settings("header_style") == "classic"){echo " page-header-inverse "; }else{ echo " "; } ?>
main-content-boxed">
    <!-- Side Overlay-->

    <!-- END Side Overlay -->
    <?php $this->load->view('includes/side-overlay'); ?>
    <!-- Sidebar -->
    <!--
        Helper classes

        Adding .sidebar-mini-hide to an element will make it invisible (opacity: 0) when the sidebar is in mini mode
        Adding .sidebar-mini-show to an element will make it visible (opacity: 1) when the sidebar is in mini mode
            If you would like to disable the transition, just add the .sidebar-mini-notrans along with one of the previous 2 classes

        Adding .sidebar-mini-hidden to an element will hide it when the sidebar is in mini mode
        Adding .sidebar-mini-visible to an element will show it only when the sidebar is in mini mode
            - use .sidebar-mini-visible-b if you would like to be a block when visible (display: block)
    -->

    <!-- END Sidebar -->
    <?php $this->load->view('includes/navbar'); ?>
    <!-- Header -->
    <?php $this->load->view('includes/header'); ?>
    <!-- END Header -->

    <!-- Main Container -->
    <main id="main-container">

        <!-- Page Content -->
        <?php $this->load->view("$viewFolder/$subViewFolder/content"); ?>
        <!-- END Page Content -->

    </main>
    <!-- END Main Container -->

    <!-- Footer -->
    <?php $this->load->view('includes/footer'); ?>
    <!-- END Footer -->
</div>
<!-- END Page Container -->

<!-- Onboarding Modal functionality is initialized in js/pages/be_pages_dashboard.min.js which was auto compiled from _es6/pages/be_pages_dashboard.js -->
<?php //$this->load->view("$viewFolder/page_includes/modal"); ?>
<!-- END Onboarding Modal -->


<?php $this->load->view('includes/include_script'); ?>
<?php $this->load->view("includes/alert.php"); ?>
<script>jQuery(function(){ Codebase.helpers('content-filter'); });</script>
<script>
    $.fn.dataTable.ext.errMode = 'none';
    var dataTabelLang = {
        paginate: {previous: "<?=trans("table_previous")?>", next: "<?=trans("table_next")?>"},
        lengthMenu: "<?=trans("table_show")?>",
        zeroRecords: "<?=trans("table_no_data")?>",
        info: "<?=trans("table_start_end")?>",
        infoEmpty: " ",
        search: "<?=trans("search")?>:"
    }

    if ($('.table-container').length) {
        $(".table-container").dataTable({
            language: dataTabelLang,
        })
    }
</script>
</body>
</html>