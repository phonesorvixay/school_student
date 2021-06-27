<?php
include "../services/services.php";
include 'database.controller.php';
class RegisterController
{
    public function __construct()
    {
    }
    public function addRegister($rgt)
    {
        try {
            $db = new DatabaseController();
            date_default_timezone_set("Asia/Vientiane");
            $user_id = $_SESSION["uid"];
            $now_date = date("Y-m-d");

            $sql = "insert into register (student_id,class_id,register_date,year_id,user_id,date_payment)
                    values ('$rgt->student_id','$rgt->class_id','$now_date','$rgt->year_id','$user_id','$rgt->date_payment')";

            // echo $sql;die();
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "add register OK!", 1);
            } else {
                PrintJSON("", "add register failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function registerListAll($get)
    {
        try {
            $db = new DatabaseController();

            if ($get->page == "" && $get->limit == "") {
                $sql = "select register_id,r.student_id,s.name,surname,s.image,gender,birthday,birth_address,address,guardian,tribes,s.remark,s.status,
                        r.class_id,c.class_name,register_date,r.year_id,y.year_name,r.user_id,u.name,date_payment
                        from register as r
                        INNER JOIN student as s ON r.student_id = s.student_id
                        INNER JOIN class as c ON r.class_id = c.class_id
                        INNER JOIN school_year as y ON r.year_id =y.year_id
                        INNER JOIN user as u ON r.user_id = u.user_id
                         order by class_id desc ";
                $doquery = $db->query($sql);
                $list = json_encode($doquery);
                $json = "{\"Data\":$list}";
                echo $json;
            } else {
                $offset = (($get->page - 1) * $get->limit);

                $sql = "select register_id,r.student_id,s.name,surname,s.image,gender,birthday,birth_address,address,guardian,tribes,s.remark,s.status,
                        r.class_id,c.class_name,register_date,r.year_id,y.year_name,r.user_id,u.name,date_payment
                        from register as r
                        INNER JOIN student as s ON r.student_id = s.student_id
                        INNER JOIN class as c ON r.class_id = c.class_id
                        INNER JOIN school_year as y ON r.year_id =y.year_id
                        INNER JOIN user as u ON r.user_id = u.user_id ";
                if (isset($get->keyword) && $get->keyword != "") {
                    $sql .= "where
                        r.student_id like '%$get->keyword%' or
                        register_id like '%$get->keyword%' or
                        s.name like '%$get->keyword%' or
                        s.surname like '%$get->keyword%' or
                        c.class_name like '%$get->keyword%' or
                        register_date like '%$get->keyword%' or
                        year_name like '%$get->keyword%' or
                        u.name like '%$get->keyword%' or
                        date_payment like '%$get->keyword%' or
                        register_id like '%$get->keyword%'
                          ";
                }
                $sql_page = "order by register_id desc limit $get->limit offset $offset  ";
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
    public function registerList($get)
    {
        try {
            $db = new DatabaseController();

            if ($get->page == "" && $get->limit == "") {
                $sql = "select register_id,r.student_id,s.name,surname,s.image,gender,birthday,birth_address,address,guardian,tribes,s.remark,s.status,
                        r.class_id,c.class_name,register_date,r.year_id,y.year_name,r.user_id,(select name from user as u where u.user_id = r.user_id) as name_of_user ,date_payment
                        from register as r
                        INNER JOIN student as s ON r.student_id = s.student_id
                        INNER JOIN class as c ON r.class_id = c.class_id
                        INNER JOIN school_year as y ON r.year_id =y.year_id
                        where r.class_id='$get->class_id' and r.year_id='$get->year_id'
                        order by class_id desc ";
                // echo $sql;die();
                $doquery = $db->query($sql);
                $list = json_encode($doquery);
                $json = "{\"Data\":$list}";
                echo $json;
            } else {
                $offset = (($get->page - 1) * $get->limit);

                $sql = "select register_id,r.student_id,s.name,surname,s.image,gender,birthday,birth_address,address,guardian,tribes,s.remark,s.status,
                        r.class_id,c.class_name,register_date,r.year_id,y.year_name,r.user_id,(select name from user as u where u.user_id = r.user_id) as name_of_user ,date_payment
                        from register as r
                        INNER JOIN student as s ON r.student_id = s.student_id
                        INNER JOIN class as c ON r.class_id = c.class_id
                        INNER JOIN school_year as y ON r.year_id =y.year_id
                        where r.class_id='$get->class_id' and r.year_id='$get->year_id'";
                if (isset($get->keyword) && $get->keyword != "") {
                    $sql .= "and (
                        r.student_id like '%$get->keyword%' or
                        register_id like '%$get->keyword%' or
                        s.name like '%$get->keyword%' or
                        s.surname like '%$get->keyword%' or
                        c.class_name like '%$get->keyword%' or
                        register_date like '%$get->keyword%' or
                        year_name like '%$get->keyword%' or
                        date_payment like '%$get->keyword%' or
                        register_id like '%$get->keyword%'
                          )";
                }
                $sql_page = "order by register_id desc limit $get->limit offset $offset  ";
                // echo $sql . $sql_page;
                // die();
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
    public function countRegisterAll($get)
    {
        try {
            $db = new DatabaseController();

            $sql = "select count(*) as register_all from register  where year_id='$get->year_id' ";
            $sql1 = "select count(*) as female from student as s INNER JOIN register as r ON s.student_id = r.student_id where s.gender=1 and  r.year_id='$get->year_id' ";
            $sql2 = "select count(*) as no_register from student where student_id NOT IN (select student_id from register where year_id ='$get->year_id') ";
            $doquery = $db->query($sql);
            $doquery1 = $db->query($sql1);
            $doquery2 = $db->query($sql2);

            $doquery[0]['female'] = $doquery1[0]['female'];
            $doquery[0]['no_register'] = $doquery2[0]['no_register'];
            $list = json_encode($doquery);

            echo $list;
        } catch (Exception $e) {
            print_r($e);
        }
    }
}
