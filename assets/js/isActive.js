/*$(document).ready(function() {

    $(".table-container, .imageListContainer, .table-email").on('change', '.isActive', function () {
        var $data = $(this).prop("checked");
        var $data_url = $(this).data("url");
        if (typeof $data !== 'undefined' && typeof $data_url !== 'undefined') {
            $.post($data_url, {data: $data}, function (response) {
                Codebase.helpers('notify', {
                    align: 'center',             // 'right', 'left', 'center'
                    from: 'top',                // 'top', 'bottom'
                    type: 'success',               // 'info', 'success', 'warning', 'danger'
                    icon: 'fa fa-check-circle',    // Icon class
                    message: '<b>İşlem Başarılı!</b> <br>Durum değişikliği başarıyla yapıldı!'
                });
            })
        }

    })
})*/