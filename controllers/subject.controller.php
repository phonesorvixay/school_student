<?php
include "../services/services.php";
include 'database.controller.php';
class SubjectController
{
    public function __construct()
    {
    }
    public function addSubject($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "insert into subject (subject_name,status) values ('$get->subject_name','$get->status')";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "add subject OK!", 1);
            } else {
                PrintJSON("", "add subject failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function updateSubject($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "update subject set subject_name='$get->subject_name',status='$get->status' where subject_id='$get->subject_id'";
            $data = $db->query($sql);
            // print_r($data);
            if ($data) {
                PrintJSON("", "udpate subject OK!", 1);
            } else {
                PrintJSON("", "update subject failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function deleteSubject($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "delete from subject where subject_id='$get->subject_id'";
            $data = $db->query($sql);
            // print_r($data);
            if ($data) {
                PrintJSON("", "subject ID: " . $get->subject_id . " delete Ok", 1);
            } else {
                PrintJSON("", "delete subject failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function subjectList($get)
    {
        try {
            $db = new DatabaseController();

            if ($get->page == "" && $get->limit == "") {
                $sql = "select * from subject order by subject_id desc ";
                $doquery = $db->query($sql);
                $list = json_encode($doquery);
                $json = "{\"Data\":$list}";
                echo $json;
            } else {
                $offset = (($get->page - 1) * $get->limit);

                $sql = "select * from subject ";
                if (isset($get->keyword) && $get->keyword != "") {
                    $sql .= "where
                        subject_id like '%$get->keyword%' or
                        subject_name like '%$get->keyword%'
                          ";
                }
                $sql_page = "order by subject_id desc limit $get->limit offset $offset  ";
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
