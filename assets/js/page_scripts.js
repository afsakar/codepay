$(document).ready(function () {

    /* Table search start */

    $(".dontShow").click(function () {

        var $url = $(this).data("url");

        $.post($url, [], function () {
        })
    })

    $("#search").keyup(function () {
        var value = this.value.toLowerCase().trim();

        $("table tr").each(function (index) {
            if (!index) return;
            $(this).find("td").each(function () {
                var id = $(this).text().toLowerCase().trim();
                var not_found = (id.indexOf(value) == -1);
                $(this).closest('tr').toggle(!not_found);
                return not_found;
            });
        });
        $(".sortable").sortable();
    });
    /* Table search start */

    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-center",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "2000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }

    $(".sortable").sortable();

    //Yorum Aktif-Pasif
    $(".table-container, .imageListContainer, .table-email").on('change', '.isComment', function () {
        var $data = $(this).prop("checked");
        var $data_url = $(this).data("url");
        if (typeof $data !== 'undefined' && typeof $data_url !== 'undefined') {
            $.post($data_url, {data: $data}, function (response) {
                toastr["success"]("Durum değişikliği başarıyla yapıldı.", "İşlem başarılı!")
            })
        }

    })

    //Aktif-Pasif
    $(".table-container, .imageListContainer, .table-email").on('change', '.isActive', function () {
        var $data = $(this).prop("checked");
        var $data_url = $(this).data("url");

        if (typeof $data !== 'undefined' && typeof $data_url !== 'undefined') {
            $.post($data_url, {data: $data}, function (response) {
                // toastr["success"]("Durum değişikliği başarıyla yapıldı.", "İşlem başarılı!")
            })
        }

    })

    //Sıralama
    $(".table-container, .imageListContainer").on("sortupdate", '.sortable', function (event, ui) {

        var $data = $(this).sortable("serialize");
        var $data_url = $(this).data("url");

        $.post($data_url, {data: $data}, function (response) {
            //toastr["success"]("Sıralama işlemi başarıyla yapıldı.")
        })

    })

    //Dropzone
    Dropzone.autoDiscover = false;
    var uploadSection = Dropzone.forElement("#dropzone");

    uploadSection.on("complete", function (file) {

        var $data_url = $("#dropzone").data("url");

        $.post($data_url, {}, function (response) {
            $(".imageListContainer").html(response);
            $(".table").dataTable();
            $('[data-switchery]').each(function () {
                var $this = $(this),
                    color = $this.attr('data-color') || '#188ae2',
                    jackColor = $this.attr('data-jackColor') || '#ffffff',
                    size = $this.attr('data-size') || 'default'

                new Switchery(this, {
                    color: color,
                    size: size,
                    jackColor: jackColor
                });
            });
            $(".sortable").sortable();
        })

    })

    //Kapak Fotoğrafı Aktif-Pasif
    $(".imageListContainer").on('change', '.isCover', function () {
        var $data = $(this).prop("checked");
        var $data_url = $(this).data("url");

        if (typeof $data !== 'undefined' && typeof $data_url !== 'undefined') {
            $.post($data_url, {data: $data}, function (response) {
                $(".imageListContainer").html(response);

                $('[data-switchery]').each(function () {
                    var $this = $(this),
                        color = $this.attr('data-color') || '#188ae2',
                        jackColor = $this.attr('data-jackColor') || '#ffffff',
                        size = $this.attr('data-size') || 'default'

                    new Switchery(this, {
                        color: color,
                        size: size,
                        jackColor: jackColor
                    });
                });

                $(".sortable").sortable();

                toastr["success"]("Kapak fotoğrafı başarıyla değiştirildi.", "İşlem başarılı!")
            })
        }

    })

    $('.datepicker').datepicker({
        format: "dd/mm/yyyy",
        todayBtn: "linked",
        language: "tr"
    });

})
