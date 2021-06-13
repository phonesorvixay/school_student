<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../controllers/invoice.controller.php";
include_once "../models/invoice.model.php";
include_once "../models/invoice_order.model.php";
try {

    Initialization();
    //    getDatabaseName();
    $m = GetMethod();

    $json = json_decode(file_get_contents('php://input'), true);

    $control = new InvoiceController();

    if ($m == "addinvoice") {
        $inv = new InvoiceModel($json['invoice']);
        $inv->checkAllProperties();
        validateInvoice_order($json['invoice_detail']);
        $control->addInvoice($inv, $json['invoice_detail']);
    } else if ($m == "payment") {
        $inv = new InvoiceModel($json);
        $inv->checkId();
        $control->payment($inv);
    } else if ($m == "cancel") {
        $inv = new InvoiceModel($json);
        $inv->checkId();
        $control->cancel($inv);
    } else if ($m == "invoicelist") {
        $inv = (object) $json;
        $control->invoiceList($inv);
    } else if ($m == "getinvoice") {
        $inv = (object) $json;
        $control->getInvoice($inv);
    } else {
        PrintJSON("", "method not provided", 0);
    }
} catch (Exception $e) {
    print_r($e);
}
