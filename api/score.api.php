<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../controllers/score.controller.php";
include_once "../models/score.model.php";

try {
    Initialization();
    //    getDatabaseName();
    $m = getallheaders()['m'];

    $json = json_decode(file_get_contents('php://input'), true);
    $control = new ScoreController();

    if ($m == "addscore") {
        validateScore($json);
        $control->addScore($json);
    } else if ($m == "getstudent") {
        $model = (object) $json;
        $control->getStudent($model);
    } else if ($m == "scorelist") {
        $model = (object) $json;
        $control->scoreList($model);
    } else if ($m == "scorelist_term") {
        $model = (object) $json;
        $control->scoreListTerm($model);
    } else {
        PrintJSON("", "wrong method!!!", 0);
    }
} catch (Exception $e) {
    print_r($e);
}
