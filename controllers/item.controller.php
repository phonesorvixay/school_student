<?php
include "../services/services.php";
include 'database.controller.php';
class ItemController
{
    public function __construct()
    {
    }
    public function addItem($item)
    {
        try {
            $db = new DatabaseController();
            $sql = "insert into item (item_name,price,next_month,remark) values ('$item->item_name','$item->price','$item->next_mont','$item->remark')";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "add item OK!", 1);
            } else {
                PrintJSON("", "add item failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function updateItem($item)
    {
        try {
            $db = new DatabaseController();
            $sql = "update item set item_name='$item->item_name',price='$item->price',next_month='$item->next_month',remark='$item->remark' where item_id='$item->item_id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "udpate item OK!", 1);
            } else {
                PrintJSON("", "update item failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function deleteItem($item)
    {
        try {
            $db = new DatabaseController();
            $sql = "delete from Item where item_id='$item->item_id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "item ID: " . $item->item_id . " delete Ok", 1);
            } else {
                PrintJSON("", "delete item failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function itemList($get)
    {
        try {
            $db = new DatabaseController();

            if ($get->page == "" && $get->limit == "") {
                $sql = "select * from item order by item_id desc ";
                $doquery = $db->query($sql);
                $list = json_encode($doquery);
                $json = "{\"Data\":$list}";
                echo $json;
            } else {
                $offset = (($get->page - 1) * $get->limit);

                $sql = "select * from item ";
                if (isset($get->keyword) && $get->keyword != "") {
                    $sql .= "where
                        item_id like '%$get->keyword%' or
                        item_name like '%$get->keyword%' or
                        price like '%$get->keyword%' or
                        next_month like '%$get->keyword%' 
                          ";
                }
                $sql_page = "order by item_id desc limit $get->limit offset $offset  ";
                $doquery = $db->query($sql);
                if ($doquery > 0) {
                    $count = sizeof($doquery);
                    if ($count > 0) {
                        $data = $db->query($sql . $sql_page);
                        $list1 = json_encode($data);
                    }
                } else {
                    $list1 = json_encode([]);
                    $count = 0;
                }

                $number_count = $count;
                $total_page = ceil($number_count / $get->limit);
                $list3 = json_encode($total_page);
                $json = "{  \"Data\":$list1,
                        \"Page\":$get->page,
                        \"Pagetotal\":$list3,
                        \"Datatotal\":$number_count
                    }";
                echo $json;
            }
        } catch (Exception $e) {
            print_r($e);
        }

    }
}
