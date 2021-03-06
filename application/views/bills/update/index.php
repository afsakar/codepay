<!doctype html>
<html lang="tr" class="no-focus">
<head>
    <?php $this->load->view('includes/head'); ?>
    <title><?=$title?> | <?=settings("title")?></title>
    <?php $this->load->view('includes/form_style'); ?>
    <style>
        select {
            -webkit-appearance: none;
            -moz-appearance: none;
            text-indent: 1px;
        }
    </style>
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
main-content-narrow">
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
<?php $this->load->view('includes/form_scripts'); ?>
<?php $this->load->view("includes/alert.php"); ?>
<script src="<?=base_url("assets")?>/js/jquery.repeater.js"></script>
<script>
    var selector = "body";
    if ($(selector + " .repeater").length) {
        var $dragAndDrop = $("body .repeater tbody").sortable({
            handle: '.sort-handler'
        });
        var $repeater = $(selector + ' .repeater').repeater({
            initEmpty: false,
            defaultValues: {
                'items[pr_id]': 0,
                'status': 1
            },
            show: function () {
                $(this).slideDown();
                $('.js-select2').select2();
            },
            hide: function (deleteElement) {
                Swal.fire({
                    title: 'Emin misiniz?',
                    text: "Silinen kay??t geri al??namaz!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Evet, sil!',
                    cancelButtonText: '??ptal'
                }).then(function (result) {
                    if (result.isConfirmed) {
                        $(this).slideUp(deleteElement);
                        $(this).remove();

                        //Total amount
                        var inputs = $(".item_total");
                        var subTotal = 0;
                        var subLength = (inputs.length) - 1;
                        for (var i = 0; i < subLength; i++) {
                            subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
                        }
                        $('.bill_subtotal').html(subTotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));

                        //Total tax
                        //taxTotal = (pr_price * pr_tax / 100);
                        var totalItemTaxPrice = 0;
                        var itemTaxPriceInput = $('.pr_tax');
                        var taxLength = (itemTaxPriceInput.length) - 1;
                        for (var j = 0; j < taxLength; j++) {
                            totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
                        }
                        $('.bill_total_tax').html(totalItemTaxPrice.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                        $('.bill_total').html((parseFloat(subTotal) + parseFloat(totalItemTaxPrice)).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    }
                })
            },
            ready: function (setIndexes) {
                $dragAndDrop.on('drop', setIndexes);
            },
            isFirstItemUndeletable: true
        });
        var value = $(selector + " .repeater").attr('data-value');
        if (typeof value != 'undefined' && value.length != 0) {
            value = JSON.parse(value);
            $repeater.setList(value);
        }


    }
</script>
<script>


    function yuvarla(sonuc, basamak) {
        return Number(Math.round(sonuc+'e'+basamak)+'e-'+basamak);
    }

    $(document).on('change', '#sup_id', function () {
        $('#supplier_detail').removeClass('d-none');
        $('#supplier_detail').addClass('d-block');
        $('#supplier-box').removeClass('d-block');
        $('#supplier-box').addClass('d-none');
        var id = $(this).val();
        var url = $(this).data('url');
        $.ajax({
            url: url,
            type: 'POST',
            dataType:'text',
            data: {'sup_id' : id},
            cache: false,
            success: function (response) {
                $('#supplier_detail').html(response);
            },
            error: function (errorThrown) {
                alert(errorThrown);
            }
        })
    });

    $(document).on('click', '#remove', function () {
        $('#supplier-box').removeClass('d-none');
        $('#supplier-box').addClass('d-block');
        $('#supplier_detail').removeClass('d-block');
        $('#supplier_detail').addClass('d-none');
    });
</script>
<script>

    $(document).on('keyup', '.pr_qnt', function () {
        var el = $(this);
        var $pr_amount = $(el.parent().parent().find('.pr_amount')).val();
        var $pr_taxprice = $(el.parent().parent().find('.pr_price')).val();
        var $pr_qnt = $(this).val();
        var $total = parseFloat($pr_qnt * ($pr_amount)).toFixed(2);
        $(el.parent().parent().find( ".item_total" )).html($total);

        var totalItemPrice = ($pr_qnt * $pr_amount);
        var amount = (totalItemPrice);
        $(el.find('.item_total')).html(amount);

        var totalItemTaxRate = $(el.parent().parent().find('.item_tax')).html();
        var itemTaxPrice = parseFloat($pr_qnt * $pr_taxprice);
        $(el.parent().parent().find('.pr_tax')).val(itemTaxPrice.toFixed(2));


        var totalItemTaxPrice = 0;
        var itemTaxPriceInput = $('.pr_tax');
        for (var j = 0; j < itemTaxPriceInput.length; j++) {
            totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
        }

        //Total amount
        var inputs = $(".item_total");
        var subTotal = 0;
        for (var i = 0; i < inputs.length; i++) {
            subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
        }
        $('.bill_subtotal').html(subTotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));

        //Total tax
        //taxTotal = (pr_price * pr_tax / 100);
        var totalItemTaxPrice = 0;
        var itemTaxPriceInput = $('.pr_tax');
        for (var j = 0; j < itemTaxPriceInput.length; j++) {
            totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
        }
        $('.bill_total_tax').html(totalItemTaxPrice.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('.bill_total').html((parseFloat(subTotal) + parseFloat(totalItemTaxPrice)).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
        $('#bill_total').val((parseFloat(subTotal) + parseFloat(totalItemTaxPrice)).toFixed(2));

    });

    $(document).ready(function(){
        $(document).on('change', '.products', function () {

            var el = $(this);
            var id = $(this).val();
            var url = $(this).data('url');

            $.ajax({
                url: url,
                type: 'POST',
                dataType:'text',
                data: {'pr_id' : id},
                cache: false,
                success: function (response) {
                    var item = JSON.parse(response);

                    var pr_code = item['pr_code'];
                    var pr_amount = item['pr_amount'];
                    var pr_taxprice = item['pr_price'];
                    var pr_qnt = 0;
                    var pr_tax = item['pr_tax'];
                    var pr_unit = item['pr_unit'];

                    var itemTaxPrice  = parseFloat(pr_qnt * pr_amount * pr_tax / 100);
                    $(el.parent().parent().find( ".pr_code" )).val(pr_code);
                    $(el.parent().parent().find( ".pr_amount" )).val(pr_amount);
                    $(el.parent().parent().find( ".pr_price" )).val(pr_taxprice);
                    $(el.parent().parent().find( ".pr_qnt" )).val(pr_qnt);
                    $(el.parent().parent().find( ".item_tax" )).html(pr_tax);
                    $(el.parent().parent().find( ".pr_tax" )).val(itemTaxPrice );
                    $(el.parent().parent().find( ".pr_unit" )).val(pr_unit);

                    var $total = parseFloat(pr_qnt * pr_amount).toFixed(2);
                    $(el.parent().parent().find( ".item_total" )).html($total);


                    //Total amount
                    var inputs = $(".item_total");
                    var subTotal = 0;
                    for (var i = 0; i < inputs.length; i++) {
                        subTotal = parseFloat(subTotal) + parseFloat($(inputs[i]).html());
                    }
                    $('.bill_subtotal').html(subTotal.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));

                    //Total tax
                    //taxTotal = (pr_amount * pr_tax / 100);
                    var totalItemTaxPrice = 0;
                    var itemTaxPriceInput = $('.pr_tax');
                    for (var j = 0; j < itemTaxPriceInput.length; j++) {
                        totalItemTaxPrice += parseFloat(itemTaxPriceInput[j].value);
                    }
                    $('.bill_total_tax').html(totalItemTaxPrice.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    $('.bill_total').html((parseFloat(subTotal) + parseFloat(totalItemTaxPrice)).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,'));
                    $('#bill_total').val((parseFloat(subTotal) + parseFloat(totalItemTaxPrice)).toFixed(2));
                },
                error: function (errorThrown) {
                    alert(errorThrown);
                }
            })

        });
    });
    $(document).on('click', '[data-repeater-create]', function () {
        $('.item :selected').each(function () {
            var id = $(this).val();
            $(".item option[value=" + id + "]").prop("disabled", true);
        });
    });
</script>
</body>
</html>