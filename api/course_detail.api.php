<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../controllers/course_detail.controller.php";
include_once "../models/course_detail.model.php";

try {
    Initialization();
    //    getDatabaseName();
    $m = getallheaders()['m'];

    $json = json_decode(file_get_contents('php://input'), true);

    $control = new CourseDetailController();
    $model = new CourseDetailModel($json);

    if ($m == "addcourse_detail") {
        $model->validateCourse_id();
        $model->validateSubject_id();
        $model->validateTeacher_id();
        $control->addCourseDetail($model);
    } else if ($m == "updatecourse_detail") {
        $model->checkId();
        $model->validateCourse_id();
        $model->validateSubject_id();
        $model->validateTeacher_id();
        $control->updateCourseDetail($model);
    } else if ($m == "deletecourse_detail") {
        $model->checkId();
        $control->deleteCourseDetail($model);
    } else if ($m == "course_detail_list") {
        $control->courseDetailList($model);
    } else if ($m == "get_course_detail") {
        $control->getCourseDetail($model);
    } else {
        PrintJSON("", "wrong method!!!", 0);
    }
} catch (Exception $e) {
    print_r($e);
}
