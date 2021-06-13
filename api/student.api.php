<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../controllers/student.controller.php";
include_once "../models/student.model.php";

try {
    Initialization();
    //    getDatabaseName();
    $m = getallheaders()['m'];

    $json = json_decode(file_get_contents('php://input'), true);
    $control = new StudentController();
    $model = new StudentModel($json);

    if ($m == "addstudent") {
        $model->validateall();
        $control->addStudent($model);
    } else if ($m == "updatestudent") {
        $model->checkID();
        $model->validateall();
        $control->udpatestudent($model);
    } else if ($m == "deletestudent") {
        $model->checkID();
        $control->deleteStudent($model);
    } else if ($m == "studentlist") {
        $control->studentList($model);
    } else if ($m == "studentlist_not_register") {
        $control->studentNotRegister($model);
    } else {
        PrintJSON("", "wrong method!!!", 0);
    }
} catch (Exception $e) {
    print_r($e);
}
