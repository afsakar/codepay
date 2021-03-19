<!doctype html>
<html lang="tr" class="no-focus">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title><?=trans("login")?> | <?=settings("title")?></title>

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="<?=base_url("assets")?>/media/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="<?=base_url("assets")?>/media/favicons/favicon-192x192.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?=base_url("assets")?>/media/favicons/apple-touch-icon-180x180.png">
    <!-- END Icons -->

    <!-- Stylesheets -->

    <!-- Fonts and Codebase framework -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700&display=swap">
    <link rel="stylesheet" id="css-main" href="<?=base_url("assets")?>/css/codebase.min.css">
    <link rel="stylesheet" href="<?=base_url("assets")?>/js/plugins/sweetalert2/sweetalert2.min.css">
    <link rel="stylesheet" href="<?=base_url("assets")?>/css/toastr.min.css">

    <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
    <!-- <link rel="stylesheet" id="css-theme" href="<?=base_url("assets")?>/css/themes/flat.min.css"> -->
    <!-- END Stylesheets -->
</head>
<body>

<!-- Page Container -->
<div id="page-container" class="main-content-boxed">

    <!-- Main Container -->
    <main id="main-container">

        <?php $this->load->view("$viewFolder/$subViewFolder/content"); ?>

    </main>
    <!-- END Main Container -->
</div>
<!-- END Page Container -->

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
<script src="<?=base_url("assets")?>/js/plugins/jquery-validation/jquery.validate.min.js"></script>

<!-- Page JS Code -->
<script src="<?=base_url("assets")?>/js/pages/op_auth_signin.min.js"></script>
<script src="<?=base_url("assets")?>/js/plugins/bootstrap-notify/bootstrap-notify.min.js"></script>
<script src="<?=base_url("assets")?>/js/plugins/es6-promise/es6-promise.auto.min.js"></script>
<script src="<?=base_url("assets")?>/js/plugins/sweetalert2/sweetalert2.min.js"></script>
<script src="<?=base_url("assets")?>/js/pages/be_ui_activity.min.js"></script>
<script src="<?=base_url("assets")?>/js/page_scripts.js"></script>
<script src="<?=base_url("assets")?>/js/alert.js"></script>
<script src="<?=base_url("assets")?>/js/toastr.min.js"></script>
<script>jQuery(function(){ Codebase.helpers('notify'); });</script>
<?php $this->load->view("includes/alert.php"); ?>
</body>
</html>