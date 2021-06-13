<?php
include "../services/services.php";
include 'database.controller.php';
require_once "databasePDO.controller.php";
class CourseDetailController
{
    public function __construct()
    {
    }
    public function addCourseDetail($course)
    {
        try {
            $db = new DatabaseController();

            $subsql = "insert into course_detail (course_id,subject_id,teacher_id,detail_number,remark) values ('$course->course_id','$course->subject_id','$course->teacher_id','$course->detail_number','$course->remark')";
            $data = $db->query($subsql);

            if ($data) {
                PrintJSON("", "add course detail OK!", 1);
            } else {
                PrintJSON("", "add course detail failed!", 0);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function updateCourseDetail($course)
    {
        try {
            $db = new DatabaseController();

            $subsql2 = "update course_detail set course_id='$course->course_id', subject_id='$course->subject_id',teacher_id='$course->teacher_id',
                        detail_number='$course->detail_number',remark='$course->remark' where detail_id='$course->detail_id' ";
            $data = $db->query($subsql2);

            if ($data) {
                PrintJSON("", "update course detail OK!", 1);
            } else {
                PrintJSON("", "update course detail failed!", 0);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function deleteCourseDetail($course)
    {
        try {
            $db = new DatabaseController();

            $sql1 = "delete from course_detail where detail_id='$course->detail_id' ";
            $data = $db->query($sql1);

            if ($data) {
                PrintJSON("", "delete course detail OK!", 1);
            } else {
                PrintJSON("", "delete course detail failed!", 0);
            }
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }
    public function courseDetailList($get)
    {
        try {
            $db = new DatabaseController();

            if ($get->page == "" && $get->limit == "") {
                $sql = "select detail_id,d.course_id,course_name,d.subject_id,subject_name,d.remark,detail_number,
                        name,surname
                        from course_detail as d
                        INNER JOIN course as c ON d.course_id = c.course_id
                        INNER JOIN subject as s ON d.subject_id = s.subject_id 
                        INNER JOIN teacher as t ON d.teacher_id = t.teacher_id order by d.course_id desc,detail_number asc ";
                $doquery = $db->query($sql);
                $list = json_encode($doquery);
                $json = "{\"Data\":$list}";
                echo $json;
            } else {
                $offset = (($get->page - 1) * $get->limit);
                $sql = "select detail_id,d.course_id,course_name,d.subject_id,subject_name,d.remark,detail_number,
                        d.teacher_id,name,surname
                        from course_detail as d
                        INNER JOIN course as c ON d.course_id = c.course_id
                        INNER JOIN subject as s ON d.subject_id = s.subject_id 
                        INNER JOIN teacher as t ON d.teacher_id = t.teacher_id ";
                if (isset($get->keyword) && $get->keyword != "") {
                    $sql .= "where
                        d.course_id like '%$get->keyword%' or
                        d.subject_id like '%$get->keyword%' or
                        course_name like '%$get->keyword%' or
                        subject_name like '%$get->keyword%' or 
                        d.teacher_id like '%$get->keyword%' or 
                        t.name like '%$get->keyword%'
                          ";
                }
                $sql_page = "order by d.course_id desc,detail_number asc limit $get->limit offset $offset  ";
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
    public function getCourseDetail($cs)
    {
        try {
            $db = new DatabaseController();
            $sql1 = "select detail_id,d.course_id,course_name,d.subject_id,subject_name,d.remark,detail_number
                    name,surname
                    from course_detail as d
                    INNER JOIN course as c ON d.course_id = c.course_id
                    INNER JOIN subject as s ON d.subject_id = s.subject_id 
                    INNER JOIN teacher as t ON d.teacher_id = t.teacher_id
                    where detail_id='$cs->detail_id' ";
            $data1 = $db->query($sql1);
            echo json_encode($data1[0]);

        } catch (Exception $e) {
            print_r($e);
        }
    }
}
