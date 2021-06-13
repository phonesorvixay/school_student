<?php
include "../services/services.php";
include 'database.controller.php';
class ClassController
{
    public function __construct()
    {
    }
    public function addClass($class)
    {
        try {
            $db = new DatabaseController();
            $sql = "insert into class (level_id,class_name,status,teacher_id,course_id) values ('$class->level_id','$class->class_name','$class->status','$class->teacher_id','$class->course_id')";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "add class OK!", 1);
            } else {
                PrintJSON("", "add class failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function updateClass($class)
    {
        try {
            $db = new DatabaseController();
            $sql = "update class set level_id='$class->level_id',class_name='$class->class_name',status='$class->status',teacher_id='$class->teacher_id',course_id='$class->course_id' where class_id='$class->class_id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "udpate class OK!", 1);
            } else {
                PrintJSON("", "update class failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function deleteClass($class)
    {
        try {
            $db = new DatabaseController();
            $sql = "delete from class where class_id='$class->class_id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "class ID: " . $class->class_id . " delete Ok", 1);
            } else {
                PrintJSON("", "delete class failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function classList($get)
    {
        try {
            $db = new DatabaseController();

            if ($get->page == "" && $get->limit == "") {
                $sql = "select class_id,class_name,c.status,c.level_id,level_name,t.teacher_id,name,surname,course_id
                        from class as c
                        INNER JOIN level as l ON c.level_id = l.level_id
                        INNER JOIN teacher as t ON c.teacher_id=t.teacher_id  order by level_name desc ";
                $doquery = $db->query($sql);
                $list = json_encode($doquery);
                $json = "{\"Data\":$list}";
                echo $json;
            } else {
                $offset = (($get->page - 1) * $get->limit);

                $sql = "select class_id,class_name,c.status,c.level_id,level_name,t.teacher_id,name,surname,course_id
                        from class as c
                        INNER JOIN level as l ON c.level_id = l.level_id
                        INNER JOIN teacher as t ON c.teacher_id=t.teacher_id ";
                if (isset($get->keyword) && $get->keyword != "") {
                    $sql .= "where
                        level_name like '%$get->keyword%' or
                        c.level_id like '%$get->keyword%' or
                        t.teacher_id like '%$get->keyword%' or
                        t.name like '%$get->keyword%' or
                        class_name like '%$get->keyword%'
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
    public function classListActive($get)
    {
        try {
            $db = new DatabaseController();

            if ($get->page == "" && $get->limit == "") {
                $sql = "select class_id,class_name,c.status,c.level_id,level_name,t.teacher_id,name,surname,course_id
                        from class as c
                        INNER JOIN level as l ON c.level_id = l.level_id
                        INNER JOIN teacher as t ON c.teacher_id=t.teacher_id
                        where c.status =1  order by level_name desc ";
                $doquery = $db->query($sql);
                $list = json_encode($doquery);
                $json = "{\"Data\":$list}";
                echo $json;
            } else {
                $offset = (($get->page - 1) * $get->limit);

                $sql = "select class_id,class_name,c.status,c.level_id,level_name,t.teacher_id,name,surname,course_id
                        from class as c
                        INNER JOIN level as l ON c.level_id = l.level_id
                        INNER JOIN teacher as t ON c.teacher_id=t.teacher_id
                        where c.status =1 ";
                if (isset($get->keyword) && $get->keyword != "") {
                    $sql .= "and(
                        level_name like '%$get->keyword%' or
                        c.level_id like '%$get->keyword%' or
                        t.teacher_id like '%$get->keyword%' or
                        t.name like '%$get->keyword%' or
                        class_name like '%$get->keyword%'
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
    public function classListCountRegister($get)
    {
        try {
            $db = new DatabaseController();
            if ($get->page == "" && $get->limit == "") {
                $sql = "select class_id,class_name,c.status,c.level_id,level_name,t.teacher_id,name,surname,(select count(*) from register as r where r.class_id = c.class_id and r.year_id ='$get->year_id') as register,
                        c.course_id,co.course_name
                        from class as c
                        INNER JOIN level as l ON c.level_id = l.level_id
                        INNER JOIN teacher as t ON c.teacher_id=t.teacher_id
                        INNER JOIN course as co ON c.course_id = co.course_id
                        where c.status =1  order by level_name desc ";
                $doquery = $db->query($sql);
                $list = json_encode($doquery);
                $json = "{\"Data\":$list}";
                echo $json;
            } else {
                $offset = (($get->page - 1) * $get->limit);

                $sql = "select class_id,class_name,c.status,c.level_id,level_name,t.teacher_id,name,surname,(select count(*) from register as r where r.class_id = c.class_id and r.year_id ='$get->year_id') as register,
                        c.course_id,co.course_name
                        from class as c
                        INNER JOIN level as l ON c.level_id = l.level_id
                        INNER JOIN teacher as t ON c.teacher_id=t.teacher_id
                        INNER JOIN course as co ON c.course_id = co.course_id
                        where c.status =1 ";
                if (isset($get->keyword) && $get->keyword != "") {
                    $sql .= "and(
                        level_name like '%$get->keyword%' or
                        c.level_id like '%$get->keyword%' or
                        t.teacher_id like '%$get->keyword%' or
                        t.name like '%$get->keyword%' or
                        class_name like '%$get->keyword%'
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
