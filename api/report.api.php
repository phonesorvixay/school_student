<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../controllers/report.controller.php";

try {
    Initialization();
    //    getDatabaseName();
    $m = getallheaders()['m'];

    $json = json_decode(file_get_contents('php://input'), true);
    $model = (object) $json;
    $control = new ReportController();

    if ($m == "report_payment") {
        $control->reportPayment($model);
    } else if ($m == "report_no_payment") {
        $control->reportNoPayment($model);
    } else if ($m == "report_register") {
        $control->reportStudentRegister($model);
    } else if ($m == "report_no_register") {
        $control->reportStudentNoRegister($model);
    } else if ($m == "report_assess_leaning_by_class") {
        $control->reportAssessLeaningByClass($model);
    } else {
        PrintJSON("", "wrong method!!!", 0);
    }
} catch (Exception $e) {
    print_r($e);
}
