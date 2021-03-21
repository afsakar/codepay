<script>
    <?php $data = $this->db->get("calendar")->result(); ?>

    $('#calendar').fullCalendar({
        header: {
            left: 'prev, next, today',
            center: 'title',
            right: 'month, basicWeek, basicDay'
        },
        editable: true,
        eventLimit: true,
        navLinks: true,
        lang: 'tr',
        events: [
            <?php foreach ($data as $key => $datum): ?>
            {
                id: '<?=$datum->id?>',
                title: '<?=$datum->title?>',
                <?php if($datum->start_date != $datum->end_date): ?>
                start: '<?=$datum->start_date?> 12:00:00',
                end: '<?=$datum->end_date?> 12:00:00',
                <?php else: ?>
                start: '<?=$datum->start_date?> 12:00:00',
                end: '<?=$datum->end_date?> 23:00:00',
                <?php endif; ?>
                color: '<?=$datum->bgColor?>',
                textColor: '<?=$datum->textColor?>',
                fwId: '<?=$datum->fw_id?>'
            },
            <?php endforeach; ?>
        ],
        eventDrop: function (event, delta) {
            var title = event.title;
            var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
            var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
            var itemID = event.id;
            $.ajax({
                url: '<?=base_url("dashboard/updateItem")?>',
                data: 'title=' + title + '&start=' + start + '&end=' + end + '&id=' + itemID,
                type: "POST",
                success: function (response) {
                    toastr["success"]('<?=trans("success_update")?>', '<?=trans("has_success")?>')
                }
            });
        },
        eventClick: function (event) {
            Swal.fire({
                title: '<?=trans("delete_title")?>',
                text: '<?=trans("delete_text")?>',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: '<?=trans("delete_button_confirm")?>',
                cancelButtonText: '<?=trans("delete_button_cancel")?>'
            }).then(function (result) {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: '<?=base_url("dashboard/deleteItem")?>',
                        data: "&id=" + event.id + "&title=" + event.title + "&fw_id=" +event.fwId,
                        success: function (response) {
                            $('#calendar').fullCalendar('removeEvents', event.id);
                            $('#calendar').fullCalendar('rerenderEvents' );
                            toastr['success']('<?=trans("success_delete")?>', '<?=trans("has_success")?>');
                        }
                    });

                }
            })

        }
    });

</script>
<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            datasets: [{
                label: '# of Votes',
                data: [12, 19, 3, 5, 2, 3],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
</script>