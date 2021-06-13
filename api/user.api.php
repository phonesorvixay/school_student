<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);

include "../controllers/user.controller.php";
include_once "../models/user.model.php";

try {
    Initialization();
    $m = getallheaders()['m'];

    //    getDatabaseName();

    $json = json_decode(file_get_contents('php://input'), true);
    $control = new UserController();
    $model = new UserModel($json);

    if ($m == "adduser") {
        $model->validateall();
        $model->validatePass();
        $control->addUser($model);
    } else if ($m == "updateuser") {
        $model->checkId();
        $model->validateall();
        $control->updateUser($model);
    } else if ($m == "deleteuser") {
        $model->checkId();
        $control->deleteUser($model);
    } else if ($m == "changepassword") {
        $model->validatePassword();
        $control->changePassword($model);
    } else if ($m == "userlist") {
        $control->userList($model);
    } else if ($m == "resetpassword") {
        $model = new UserModel($json);
        $control->resetPassword();
    } else if ($m == "getuser") {
        $control->getuser($model);
    } else {
        PrintJSON("", "wrong method!!!", 0);
    }
} catch (Exception $e) {
    print_r($e);
}
