<?php
include "../services/services.php";
include 'database.controller.php';
require_once "databasePDO.controller.php";
class CourseController
{
    public function __construct()
    {
    }
    public function addCourse($course)
    {
        try {
            $db = new DatabaseController();

            $sql = "insert into course (course_name,status) values ('$course->course_name','$course->status')";

            $data = $db->query($sql);

            if ($data) {
                PrintJSON("", "add course OK!", 1);
            } else {
                PrintJSON("", "add course failed!", 0);
            }
        } catch (Exception $e) {
            PrintJSON("", "add invoice fail error: " . $e->getMessage(), 0);
        }
    }
    public function updateCourse($course)
    {
        try {
            $db = new DatabaseController();


            $subsql = "update course set course_name='$course->course_name',status='$course->status' where course_id ='$course->course_id' ";
            $data = $db->query($subsql);

            if ($data) {
                PrintJSON("", "update course OK!", 1);
            } else {
                PrintJSON("", "update course failed!", 0);
            }
        } catch (Exception $e) {
            PrintJSON("", "update course fail error: " . $e->getMessage(), 0);
        }
    }
    public function deleteCourse($course)
    {
        try {
            $db = new DatabaseController();


            $sql = "delete from course where course_id='$course->course_id'";
            $data = $db->query($sql);

            if ($data) {
                PrintJSON("", "delete course OK!", 1);
            } else {
                PrintJSON("", "delete course failed!", 0);
            }
        } catch (Exception $e) {
            PrintJSON("", "delete course fail error: " . $e->getMessage(), 0);
        }
    }
    public function courseList($get)
    {
        try {
            $db = new DatabaseController();

            if ($get->page == "" && $get->limit == "") {
                $sql = "select * from course order by course_id desc ";
                $doquery = $db->query($sql);
                $list = json_encode($doquery);
                $json = "{\"Data\":$list}";
                echo $json;
            } else {
                $offset = (($get->page - 1) * $get->limit);

                $sql = "select * from course ";
                if (isset($get->keyword) && $get->keyword != "") {
                    $sql .= "where
                        course_id like '%$get->keyword%' or
                        course_name like '%$get->keyword%'
                          ";
                }
                $sql_page = "order by course_id desc limit $get->limit offset $offset  ";
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
    public function getCourse($cs)
    {
        try {
            $db = new DatabaseController();
            $sql1 = "select * from course where course_id='$cs->course_id' ";
            $data1 = $db->query($sql1);
            
            $list1 = json_encode($data1[0]);

            $sql2 = "select detail_id,d.course_id,course_name,d.subject_id,subject_name,d.remark,detail_number,
                    d.teacher_id,name,surname
                    from course_detail as d
                    INNER JOIN course as c ON d.course_id = c.course_id
                    INNER JOIN subject as s ON d.subject_id = s.subject_id 
                    INNER JOIN teacher as t ON d.teacher_id = t.teacher_id
                    where d.course_id = '$cs->course_id' order by detail_number asc";
            $data2 = $db->query($sql2);
            $list2 = json_encode($data2);

            $json = "{ \"course\":$list1,
                      \"course_detail\":$list2
                      }";
            echo $json;

        } catch (Exception $e) {
            print_r($e);
        }
    }
}
