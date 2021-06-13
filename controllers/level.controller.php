<?php
include "../services/services.php";
include 'database.controller.php';
class LevelController
{
    public function __construct()
    {
    }
    public function addLevel($level)
    {
        try {
            $db = new DatabaseController();
            $sql = "insert into level (level_name,status) values ('$level->level_name','$level->status')";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "add level OK!", 1);
            } else {
                PrintJSON("", "add level failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function updateLevel($level)
    {
        try {
            $db = new DatabaseController();
            $sql = "update level set level_name='$level->level_name',status='$level->status' where level_id='$level->level_id'";
            $data = $db->query($sql);
            // print_r($data);
            if ($data) {
                PrintJSON("", "udpate level OK!", 1);
            } else {
                PrintJSON("", "update level failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function deleteLevel($level)
    {
        try {
            $db = new DatabaseController();
            $sql = "delete from level where level_id='$level->level_id'";
            $data = $db->query($sql);
            // print_r($data);
            if ($data) {
                PrintJSON("", "level ID: " . $level->level_id . " delete Ok", 1);
            } else {
                PrintJSON("", "delete level failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function levelList($get)
    {
        try {
            $db = new DatabaseController();

            if ($get->page == "" && $get->limit == "") {
                $sql = "select * from level order by level_name desc ";
                $doquery = $db->query($sql);
                $list = json_encode($doquery);
                $json = "{\"Data\":$list}";
                echo $json;
            } else {
                $offset = (($get->page - 1) * $get->limit);

                $sql = "select * from level ";
                if (isset($get->keyword) && $get->keyword != "") {
                    $sql .= "where
                        level_id like '%$get->keyword%' or
                        level_name like '%$get->keyword%'
                          ";
                }
                $sql_page = "order by level_name desc limit $get->limit offset $offset  ";
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
    public function levelListActive($get)
    {
        try {
            $db = new DatabaseController();

            if ($get->page == "" && $get->limit == "") {
                $sql = "select * from level  where status=1 order by level_name desc ";
                $doquery = $db->query($sql);
                $list = json_encode($doquery);
                $json = "{\"Data\":$list}";
                echo $json;
            } else {
                $offset = (($get->page - 1) * $get->limit);

                $sql = "select * from level where status =1 ";
                if (isset($get->keyword) && $get->keyword != "") {
                    $sql .= "and (
                        level_id like '%$get->keyword%' or
                        level_name like '%$get->keyword%'
                          )";
                }
                $sql_page = "order by level_name desc limit $get->limit offset $offset  ";
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
}
