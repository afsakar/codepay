<?php

function chart($chartName, $title, $type, array $data, $labelColumn, $dataColumn, $lineName, $color)
{
    echo "<div id='$chartName' style='width: 100%; height: auto'></div>";
    echo "<script type=\"text/javascript\">";
           echo "google.charts.load('current', {'packages':['corechart']});
                google.charts.setOnLoadCallback(drawChart);

                function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    ['".trans("date")."', '".$lineName."'],";
                    foreach ($data as $item){
                       echo "['".$item->$labelColumn."',".$item->$dataColumn."],";
                    }
                echo "]);

                var options = {
                    title: '$title',
                    colors: ['$color'],
                    curveType: 'function',
                    legend: { position: 'bottom' }
                };

                var chart = new google.visualization.".$type."Chart(document.getElementById('$chartName'));

                chart.draw(data, options);
                }";
    echo "</script>";
}