<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../controllers/month.controller.php";
include_once "../models/month.model.php";

try {
    Initialization();
    //    getDatabaseName();
    $m = getallheaders()['m'];

    $json = json_decode(file_get_contents('php://input'), true);
    $control = new MonthController();
    $model = new MonthModel($json);

    if ($m == "addmonth") {
        $model->validateall();
        $control->addMonth($model);
    } else if ($m == "updatemonth") {
        $model->checkId();
        $model->validateall();
        $control->updateMonth($model);
    } else if ($m == "deletemonth") {
        $model->checkId();
        $control->deleteMonth($model);
    } else if ($m == "monthlist") {
        $control->MonthList($model);
    } else if ($m == "month_by_parent") {
        $control->monthListByParent($model);
    } else if ($m == "month_tree") {
        $control->MonthTree($model);
    } else {
        PrintJSON("", "wrong method!!!", 0);
    }
} catch (Exception $e) {
    print_r($e);
}
