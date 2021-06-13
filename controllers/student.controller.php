<?php
include "../services/services.php";
include 'database.controller.php';
class StudentController
{
    public function __construct()
    {
    }
    public function addStudent($std)
    {
        try {
            $db = new DatabaseController();

            if (!isset($std->image) || $std->image == "") {
                $name_image = "";
            } else {
                $type = explode('/', explode(';', $std->image)[0])[1];
                $p = preg_replace('#^data:image/\w+;base64,#i', '', $std->image);
                $name_image = "student-$std->name-$std->surname-$std->birthday.$type";
                $name = MY_PATH . $name_image;
                $image = base64_to_jpeg($p, $name);
            }

            $sql = "insert into student (name,surname,gender,birthday,birth_address,address,guardian,tribes,remark,image)
                    values ('$std->name','$std->surname','$std->gender','$std->birthday','$std->birth_address','$std->address','$std->guardian','$std->tribes','$std->remark','$name_image')";

            // echo $sql;die();
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "add student OK!", 1);
            } else {
                PrintJSON("", "add student failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function udpateStudent($std)
    {
        try {
            $db = new DatabaseController();

            if (!isset($std->image) || $std->image == "") {
                $name_image = "";
            } else {
                $type = explode('/', explode(';', $std->image)[0])[1];
                $p = preg_replace('#^data:image/\w+;base64,#i', '', $std->image);
                $name_image = "student-$std->name-$std->surname-$std->birthday.$type";
                $name = MY_PATH . $name_image;
                $image = base64_to_jpeg($p, $name);
            }

            $sql = "update student set name='$std->name',surname='$std->surname',gender='$std->gender',birthday='$std->birthday',birth_address='$std->birth_address',address='$std->address',guardian='$std->guardian',
                    tribes='$std->tribes',remark='$std->remark',image='$name_image' where student_id='$std->student_id';";

            $data = $db->query($sql);

            // echo $sql;die();
            if ($data) {
                PrintJSON("", "udpate student OK!", 1);
            } else {
                PrintJSON("", "update student failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function deleteStudent($std)
    {
        try {
            $db = new DatabaseController();

            $sql = "delete from student where student_id='$std->student_id'";
            // echo $sql;die();
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "student ID: " . $std->stduent_id . " delete Ok", 1);
            } else {
                PrintJSON("", "delete user failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function studentList($get)
    {
        try {
            $db = new DatabaseController();

            if ($get->page == "" && $get->limit == "") {
                $sql = "select * from student order by class_id desc ";
                $doquery = $db->query($sql);
                $list = json_encode($doquery);
                $json = "{\"Data\":$list}";
                echo $json;
            } else {
                $offset = (($get->page - 1) * $get->limit);

                $sql = "select * from student ";
                if (isset($get->keyword) && $get->keyword != "") {
                    $sql .= "where
                        student_id like '%$get->keyword%' or
                        name like '%$get->keyword%' or
                        surname like '%$get->keyword%' or
                        gender like '%$get->keyword%' or
                        birthday like '%$get->keyword%' or
                        address like '%$get->keyword%' or
                        guardian like '%$get->keyword%' or
                        tribes like '%$get->keyword%'
                          ";
                }
                $sql_page = "order by student_id desc limit $get->limit offset $offset  ";
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
    public function studentNotRegister($get)
    {
        try {
            $db = new DatabaseController();

            if ($get->page == "" && $get->limit == "") {
                $sql = "select * from student where student_id NOT IN (select student_id from register where year_id='$get->year_id') order by student_id desc ";
                $doquery = $db->query($sql);
                $list = json_encode($doquery);
                $json = "{\"Data\":$list}";
                echo $json;
            } else {
                $offset = (($get->page - 1) * $get->limit);

                $sql = "select * from student where student_id NOT IN (select student_id from register where year_id='$get->year_id')";
                if (isset($get->keyword) && $get->keyword != "") {
                    $sql .= "and (
                        student_id like '%$get->keyword%' or
                        name like '%$get->keyword%' or
                        surname like '%$get->keyword%' or
                        gender like '%$get->keyword%' or
                        birthday like '%$get->keyword%' or
                        address like '%$get->keyword%' or
                        guardian like '%$get->keyword%' or
                        tribes like '%$get->keyword%'
                          )";
                }
                $sql_page = "order by student_id desc limit $get->limit offset $offset  ";
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
