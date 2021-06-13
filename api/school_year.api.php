<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../controllers/school_year.controller.php";
include_once "../models/school_year.model.php";

try {
    Initialization();
    //    getDatabaseName();
    $m = getallheaders()['m'];

    $json = json_decode(file_get_contents('php://input'), true);

    $control = new School_yearController();
    $model = new School_yearModel($json);

    if ($m == "addyear") {
        $model->validateYear_name();
        $control->addSchool_year($model);
    } else if ($m == "updateyear") {
        $model->checkId();
        $model->validateYear_name();
        $control->updateSchool_year($model);
    } else if ($m == "yearlist") {
        $control->School_yearList($model);
    } else if ($m == "yearlist_active") {
        $control->School_yearListActive($model);
    } else {
        PrintJSON("", "wrong method!!!", 0);
    }
} catch (Exception $e) {
    print_r($e);
}
