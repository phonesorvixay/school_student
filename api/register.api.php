<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../controllers/register.controller.php";
include_once "../models/register.model.php";

try {
    Initialization();
    //    getDatabaseName();
    $m = getallheaders()['m'];

    $json = json_decode(file_get_contents('php://input'), true);
    $control = new RegisterController();
    $model = new RegisterModel($json);

    if ($m == "addregister") {
        $model->validateall();
        $control->addRegister($model);
    } else if ($m == "registerlist") {
        $control->registerList($model);
    } else if ($m == "registerlist_all") {
        $control->registerListAll($model);
    } else if ($m == "count_register") {
        $control->countRegisterAll($model);
    } else {
        PrintJSON("", "wrong method!!!", 0);
    }
} catch (Exception $e) {
    print_r($e);
}
