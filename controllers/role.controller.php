<?php
include "../services/services.php";
include 'database.controller.php';
class RoleController
{
    public function __construct()
    {
    }
    public function addRole($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "insert into role (role_name,permission,default_department) values ('$get->role_name','$get->permission','$get->default_department')";
            $data = $db->query($sql);   
            if ($data) {
                PrintJSON("", "add role OK!", 1);
            } else {
                PrintJSON("", "add role failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function updateRole($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "update role set role_name='$get->role_name',permission='$get->permission', default_department='$get->default_department' where role_id='$get->role_id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "update role OK!", 1);
            } else {
                PrintJSON("", "update role failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function deleteRole($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "delete from role where role_id='$get->role_id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "role ID: " . $get->role_id. " delete Ok", 1);
            } else {
                PrintJSON("", "delete role failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function roleList($get)
    {
        try {
            $db = new DatabaseController();

            if ($get->page == "" && $get->limit == "") {
                $sql = "select * from role  order by role_id desc ";
                $doquery = $db->query($sql);
                $list = json_encode($doquery);
                $json = "{\"Data\":$list}";
                echo $json;
            } else {
                $offset = (($get->page - 1) * $get->limit);

                $sql = "select * from role  ";
                if (isset($get->keyword) && $get->keyword != "") {
                    $sql .= "where
                        role_id like '%$get->keyword%' or
                        role_name like '%$get->keyword%' 
                          ";
                }
                $sql_page = "order by role_id desc limit $get->limit offset $offset  ";
                // echo $sql.$sql_page;die();
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
    public function getrole($get)
    {
        try {
            $db = new DatabaseController();

                $sql = "select * from role  where role_id ='$get->role_id' ";
                $data = $db->query($sql);
                $list = json_encode($data);
                echo $list;
            
        } catch (Exception $e) {
            print_r($e);
        }

    }
}
