$(document).ready(function() {

    //Logout SweetAlert2
    $(".logout").on('click', '.logout-btn', function () {
        var $dataUrl = $(this).data('url');
        var $dataText = $(this).data('text');
        var $dataTitle = $(this).data('title');
        var $dataConfirm = $(this).data('confirm');
        var $dataCancel = $(this).data('cancel');

        Swal.fire({
            title: $dataTitle,
            text: $dataText,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: $dataConfirm,
            cancelButtonText: $dataCancel
        }).then(function (result) {
            if (result.isConfirmed) {
                window.location.href = $dataUrl;
            }
        })

    })

    //Delete SweetAlert2
    $(".table-container, .imageListContainer, .table-email").on('click', '.remove-btn', function () {

        var $dataUrl = $(this).data('url');
        var $dataText = $(this).data('text');
        var $dataTitle = $(this).data('title');
        var $dataConfirm = $(this).data('confirm');
        var $dataCancel = $(this).data('cancel');

        Swal.fire({
            title: $dataTitle,
            text: $dataText,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: $dataConfirm,
            cancelButtonText: $dataCancel
        }).then(function (result) {
            if (result.isConfirmed) {
                window.location.href = $dataUrl;
            }
        })

    })

})