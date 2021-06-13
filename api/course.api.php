<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../controllers/course.controller.php";
include_once "../models/course.model.php";

try {
    Initialization();
    //    getDatabaseName();
    $m = getallheaders()['m'];

    $json = json_decode(file_get_contents('php://input'), true);

    $control = new CourseController();
    $model = new CourseModel($json);

    if ($m == "addcourse") {
        $model->validateCourse_name();
        $control->addCourse($model);
    } else if ($m == "updatecourse") {
        $model->checkId();
        $model->validateCourse_name();
        $control->updateCourse($model);
    } else if ($m == "deletecourse") {
        $model->checkId();
        $control->deleteCourse($model);
    } else if ($m == "courselist") {
        $control->courseList($model);
    } else if ($m == "getcourse") {
        $control->getCourse($model);
    } else {
        PrintJSON("", "wrong method!!!", 0);
    }
} catch (Exception $e) {
    print_r($e);
}
