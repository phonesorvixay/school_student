<?php
include "../services/services.php";
include 'database.controller.php';
class TeacherController
{
    public function __construct()
    {
    }
    public function addTeacher($std)
    {
        try {
            $db = new DatabaseController();
            if (isset($std->image) && $std->image != "") {
                $rand = rand();
                $type = explode('/', explode(';', $std->image)[0])[1];
                $p = preg_replace('#^data:image/\w+;base64,#i', '', $std->image);
                $name_image = "student-$rand-$std->birthday.$type";
                $name = MY_PATH . $name_image;
                $images = base64_to_jpeg($p, $name);
            } else {
                $name_image = "";
            }


            $sql = "insert into teacher (name,surname,gender,birthday,address,phonenumber,status,image) 
            values ('$std->name','$std->surname','$std->gender','$std->birthday','$std->address','$std->phonenumber','$std->status','$name_image')";

            // echo $sql;die();
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "add teacher OK!", 1);
            } else {
                PrintJSON("", "add teacher failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function udpateTeacher($std)
    {
        try {
            $db = new DatabaseController();

            if (isset($std->image) && $std->image != "") {
                $rand = rand();
                $type = explode('/', explode(';', $std->image)[0])[1];
                $p = preg_replace('#^data:image/\w+;base64,#i', '', $std->image);
                $name_image = "student-$rand-$std->birthday.$type";
                $name = MY_PATH . $name_image;
                $images = base64_to_jpeg($p, $name);
            } else {
                $name_image = "";
            }


            $sql = "update teacher set name='$std->name',surname='$std->surname',gender='$std->gender',birthday='$std->birthday',address='$std->address',phonenumber='$std->phonenumber',
                    status='$std->status',image='$name_image' where teacher_id='$std->teacher_id';";

            $data = $db->query($sql);
            // echo $sql;die();
            if ($data) {
                PrintJSON("", "udpate teacher OK!", 1);
            } else {
                PrintJSON("", "update teacher failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function deleteTeacher($std)
    {
        try {
            $db = new DatabaseController();

            $sql = "delete from teacher where teacher_id='$std->teacher_id'";
            // echo $sql;die();
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", " delete teacher Ok", 1);
            } else {
                PrintJSON("", "delete teacher failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function teacherList($get)
    {
        try {
            $db = new DatabaseController();

            if ($get->page == "" && $get->limit == "") {
                $sql = "select * from teacher order by teacher_id desc ";
                $doquery = $db->query($sql);
                $list = json_encode($doquery);
                $json = "{\"Data\":$list}";
                echo $json;
            } else {
                $offset = (($get->page - 1) * $get->limit);

                $sql = "select * from teacher ";
                if (isset($get->keyword) && $get->keyword != "") {
                    $sql .= "where
                        teacher_id like '%$get->keyword%' or
                        name like '%$get->keyword%' or
                        surname like '%$get->keyword%' or
                        gender like '%$get->keyword%' or
                        birthday like '%$get->keyword%' or
                        address like '%$get->keyword%' or
                        phonenumber like '%$get->keyword%' 
                          ";
                }
                $sql_page = "order by teacher_id desc limit $get->limit offset $offset  ";
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
    public function getTeacher($get)
    {
        try {
            $db = new DatabaseController();

            $sql = "select teacher_id,name,surname from teacher";
            $doquery = $db->query($sql);
            $list = json_encode($doquery);
            $json = "{\"Data\":$list}";
            echo $json;
        } catch (Exception $e) {
            print_r($e);
        }
    }
}
