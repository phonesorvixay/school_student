<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../controllers/subject.controller.php";
include_once "../models/subject.model.php";

try {
    Initialization();
    //    getDatabaseName();
    $m = getallheaders()['m'];

    $json = json_decode(file_get_contents('php://input'), true);

    $control = new SubjectController();
    $model = new SubjectModel($json);

    if ($m == "addsubject") {
        $model->validateSubject_name();
        $control->addSubject($model);
    } else if ($m == "updatesubject") {
        $model->checkId();
        $model->validateSubject_name();
        $control->updateSubject($model);
    } else if ($m == "deletesubject") {
        $model->checkId();
        $control->deleteSubject($model);
    } else if ($m == "subjectlist") {
        $control->subjectList($model);
    } else {
        PrintJSON("", "wrong method!!!", 0);
    }
} catch (Exception $e) {
    print_r($e);
}
