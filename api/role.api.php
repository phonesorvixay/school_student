<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

include "../controllers/role.controller.php";
include_once "../models/role.model.php";

try {
    Initialization();
    $m = getallheaders()['m'];
    //    getDatabaseName();

    $json = json_decode(file_get_contents('php://input'), true);
    $control = new RoleController();
    $model = new RoleModel($json);

    if ($m == "addrole") {
        $model->validateRole_name();
        $model->validatePermission();
        $control->addRole($model);
    } else if ($m == "updaterole") {
        $model->checkId();
        $model->validateRole_name();
        $model->validatePermission();
        $control->updateRole($model);
    } else if ($m == "deleterole") {
        $model->checkdelete();
        $control->deleteRole($model);
    } else if ($m == "rolelist") {
        $control->roleList($model);
    } else if ($m == "getrole") {
        $control->getrole($model);
    } else {
        PrintJSON("", "wrong method!!!", 0);
    }
} catch (Exception $e) {
    print_r($e);
}
