<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../controllers/level.controller.php";
include_once "../models/level.model.php";

try {
    Initialization();
    //    getDatabaseName();
    $m = getallheaders()['m'];

    $json = json_decode(file_get_contents('php://input'), true);

    $control = new LevelController();
    $model = new LevelModel($json);

    if ($m == "addlevel") {
        $model->validateLevel_name();
        $control->addLevel($model);
    } else if ($m == "updatelevel") {
        $model->checkIdupdate();
        $model->validateLevel_name();
        $control->updateLevel($model);
    } else if ($m == "deletelevel") {
        $model->checkIddelete();
        $control->deleteLevel($model);
    } else if ($m == "levellist") {
        $control->levelList($model);
    } else if ($m == "levellist_active") {
        $control->levelListActive($model);
    } else {
        PrintJSON("", "wrong method!!!", 0);
    }
} catch (Exception $e) {
    print_r($e);
}
