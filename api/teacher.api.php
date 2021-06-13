<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../controllers/teacher.controller.php";
include_once "../models/teacher.model.php";

try {
    Initialization();
    //    getDatabaseName();
    $m = getallheaders()['m'];

    $json = json_decode(file_get_contents('php://input'), true);
    $control = new TeacherController();
    $model = new TeacherModel($json);

    if ($m == "addteacher") {
        $model->validateall();
        $control->addTeacher($model);
    } else if ($m == "updateteacher") {
        $model->checkID();
        $model->validateall();
        $control->udpateTeacher($model);
    } else if ($m == "deleteteacher") {
        $model->checkID();
        $control->deleteTeacher($model);
    } else if ($m == "teacherlist") {
        $control->teacherList($model);
    } else if ($m == "getteacher") {
        $control->getTeacher($model);
    } else {
        PrintJSON("", "wrong method!!!", 0);
    }
} catch (Exception $e) {
    print_r($e);
}
