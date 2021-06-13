<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../controllers/class.controller.php";
include_once "../models/class.model.php";

try {
    Initialization();
    //    getDatabaseName();
    $m = getallheaders()['m'];

    $json = json_decode(file_get_contents('php://input'), true);
    $control = new ClassController();
    $model = new ClassModel($json);

    if ($m == "addclass") {
        $model->validateClass_name();
        $model->validateCourse_id();
        $model->validateTeacher_id();
        $control->addClass($model);
    } else if ($m == "updateclass") {
        $model->checkId();
        $model->validateClass_name();
        $model->validateCourse_id();
        $model->validateTeacher_id();
        $control->updateClass($model);
    } else if ($m == "deleteclass") {
        $model->checkId();
        $control->deleteClass($model);
    } else if ($m == "classlist") {
        $control->classList($model);
    } else if ($m == "classlist_active") {
        $control->classListActive($model);
    } else if ($m == "classlist_count") {
        // $aa = (object) $json;
        $control->classListCountRegister($model);
    } else {
        PrintJSON("", "wrong method!!!", 0);
    }
} catch (Exception $e) {
    print_r($e);
}
