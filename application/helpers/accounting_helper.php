<?php

function currencyFormat($price)
{

    if (settings("money_status") == "after") {
        $format = number_format($price, 2) . " " . settings("currency");
    } else {
        $format = settings("currency") . " " . number_format($price, 2);
    }
    return $format;
}

function getSum($array, $column)
{

    $invoiceTotal = "";
    foreach ($array as $invoice) {
        $invoiceTotal .= $invoice->$column;
    }
    echo $invoiceTotal ? currencyFormat($invoiceTotal) : currencyFormat(0);

}