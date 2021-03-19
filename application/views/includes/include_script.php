<?php
$code = ($this->session->userdata('site_lang') == '') ? settings("current_language_id") : $this->session->userdata('site_lang');
?>
<!--
    Codebase JS Core

    Vital libraries and plugins used in all pages. You can choose to not include this file if you would like
    to handle those dependencies through webpack. Please check out <?=base_url("assets")?>/_es6/main/bootstrap.js for more info.

    If you like, you could also include them separately directly from the <?=base_url("assets")?>/js/core folder in the following
    order. That can come in handy if you would like to include a few of them (eg jQuery) from a CDN.

    <?=base_url("assets")?>/js/core/jquery.min.js
    <?=base_url("assets")?>/js/core/bootstrap.bundle.min.js
    <?=base_url("assets")?>/js/core/simplebar.min.js
    <?=base_url("assets")?>/js/core/jquery-scrollLock.min.js
    <?=base_url("assets")?>/js/core/jquery.appear.min.js
    <?=base_url("assets")?>/js/core/jquery.countTo.min.js
    <?=base_url("assets")?>/js/core/js.cookie.min.js
-->
<script src="<?=base_url("assets")?>/js/codebase.core.min.js"></script>

<!--
    Codebase JS

    Custom functionality including Blocks/Layout API as well as other vital and optional helpers
    webpack is putting everything together at <?=base_url("assets")?>/_es6/main/app.js
-->
<script src="<?=base_url("assets")?>/js/codebase.app.min.js"></script>

<!-- Page JS Plugins -->
<script src="<?=base_url("assets")?>/js/plugins/chartjs/Chart.bundle.min.js"></script>
<script src="<?=base_url("assets")?>/js/plugins/slick/slick.min.js"></script>

<!-- Sweet Alert -->
<script src="<?=base_url("assets")?>/js/plugins/sweetalert2/sweetalert2.all.js"></script>
<!-- Switchery -->
<script src="<?=base_url("assets")?>/js/plugins/switchery/switchery.js"></script>
<script src="<?=base_url("assets")?>/js/plugins/bootstrap-notify/bootstrap-notify.min.js"></script>
<script src="<?=base_url("assets")?>/js/pages/be_pages_dashboard.min.js"></script>
<script src="<?=base_url("assets")?>/js/page_scripts.js"></script>
<script src="<?=base_url("assets")?>/js/alert.js"></script>
<script src="<?=base_url("assets")?>/js/isActive.js"></script>
<script src="<?=base_url("assets")?>/js/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
<script src="<?=base_url("assets")?>/js/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="<?=base_url("assets")?>/js/plugins/datatables/dataTables.bootstrap4.min.js"></script>
<script src="<?=base_url("assets")?>/js/pages/be_tables_datatables.min.js"></script>
<script src="<?=base_url("assets")?>/js/plugins/jquery-ui/jquery-ui.min.js"></script>
<script src="<?=base_url("assets")?>/js/plugins/moment/moment.min.js"></script>
<script src="<?=base_url("assets")?>/js/plugins/fullcalendar/fullcalendar.min.js"></script>
<script src="<?=base_url("assets")?>/js/plugins/fullcalendar/locale/<?=get_lang_short_code($code)?>.js"></script>
<!--<script src="--><?//=base_url("assets")?><!--/js/pages/be_comp_calendar.min.js"></script>-->

<!-- Page JS Helpers (Magnific Popup plugin) -->
<script>jQuery(function(){ Codebase.helpers('magnific-popup'); });</script>

