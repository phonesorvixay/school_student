<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../controllers/item.controller.php";
include_once "../models/item.model.php";

try {
    Initialization();
    //    getDatabaseName();
    $m = getallheaders()['m'];

    $json = json_decode(file_get_contents('php://input'), true);
    $control = new ItemController();
    $model = new ItemModel($json);

    if ($m == "additem") {
        $model->validateItem_name();
        $model->validatePrice();
        $control->addItem($model);
    } else if ($m == "updateitem") {
        $model->checkId();
        $model->validateItem_name();
        $model->validatePrice();
        $control->updateItem($model);
    } else if ($m == "deleteitem") {
        $model->checkId();
        $control->deleteItem($model);
    } else if ($m == "itemlist") {
        $control->itemList($model);
    } else {
        PrintJSON("", "wrong method!!!", 0);
    }
} catch (Exception $e) {
    print_r($e);
}
