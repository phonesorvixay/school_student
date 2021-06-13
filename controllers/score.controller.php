<?php

include "../services/services.php";
include 'database.controller.php';
include "databasePDO.controller.php";
class ScoreController
{
    public function __construct()
    {
    }
    public function addScore($sc)
    {
        try {
            $db = new PDODBController();
            $db->beginTran();

            for ($i = 0; $i < count($sc); $i++) {
                $score_number = $sc[$i]['score_number'];
                $register_id = $sc[$i]['register_id'];
                $month_id = $sc[$i]['month_id'];
                $subject_id = $sc[$i]['subject_id'];
                @$score_id = isset($sc[$i]['score_id']) && !empty($sc[$i]['score_id']) ? $sc[$i]['score_id'] : "";
                if (empty($score_id)) {
                    $sql = "insert into score (score_number,register_id,month_id,subject_id)
                    values('$score_number','$register_id','$month_id','$subject_id')";
                    $db->query($sql);
                } else {
                    $sql = "update score set score_number='$score_number',register_id='$register_id',
                    month_id='$month_id',subject_id='$subject_id' where score_id='$score_id'";
                    $db->query($sql);
                }
            }
            $db->commit();
            PrintJSON("", "add score OK!", 1);
        } catch (Exception $e) {
            PrintJSON("", "add score failed! ", 0);
        }
    }
    public function getStudent($get)
    {
        $db = new DatabaseController();
        $sql = "select register_id,r.student_id,s.name,surname,s.image,gender,birthday,birth_address,address,guardian,tribes,s.remark,s.status,
                r.class_id,c.class_name,register_date,r.year_id,y.year_name,r.user_id,u.name,date_payment
                from register as r
                INNER JOIN student as s ON r.student_id = s.student_id
                INNER JOIN class as c ON r.class_id = c.class_id
                INNER JOIN school_year as y ON r.year_id =y.year_id
                INNER JOIN user as u ON r.user_id = u.user_id
                where r.class_id='$get->class_id' and r.year_id='$get->year_id'
                order by class_id desc ";
        // echo $sql;die();
        $doquery = $db->query($sql);
        $count = $doquery > 0 ? count($doquery) : "";
        for ($i = 0; $i < $count; $i++) {
            $register_id = $doquery[$i]['register_id'];
            $sql = "select score_id,score_number from score 
                    where register_id='$register_id' and subject_id = '$get->subject_id'
                    and month_id='$get->month_id' ";
            $data = $db->query($sql);
            $doquery[$i]['score_id'] = $data[0]['score_id'];
            $doquery[$i]['score_number'] = $data[0]['score_number'];
        }
        $list = json_encode($doquery);
        $json = "{\"Data\":$list}";
        echo $json;
    }
    public function scoreList($get)
    {
        $db = new DatabaseController();
        $sql1 = "select register_id,r.student_id,s.name,surname,s.image,gender,birthday,birth_address,address,guardian,tribes,s.remark,s.status,
                r.class_id,c.class_name,c.course_id,register_date,r.year_id,y.year_name,r.user_id,u.name,date_payment
                from register as r
                INNER JOIN student as s ON r.student_id = s.student_id
                INNER JOIN class as c ON r.class_id = c.class_id
                INNER JOIN school_year as y ON r.year_id =y.year_id
                INNER JOIN user as u ON r.user_id = u.user_id
                where r.class_id='$get->class_id' and r.year_id='$get->year_id'
                order by class_id desc ";
        // echo $sql;die();
        $data1 = $db->query($sql1);
        $count = $data1 > 0 ? count($data1) : ""; 
        for ($i = 0; $i < $count; $i++) { 
            $course_id = $data1[$i]['course_id']; 
            $register_id = $data1[$i]['register_id']; 
            $sql2 = "select d.subject_id,subject_name 
                    from course_detail as d 
                    INNER JOIN subject as s ON d.subject_id = s.subject_id
                    where course_id = '$course_id' order by detail_number asc";
            $data2 = $db->query($sql2);

            $count2 = $data2 > 0 ? count($data2) : "";
            for ($a = 0; $a < $count2; $a++) {
                $subject_id = $data2[$a]['subject_id'];
                $sql3 = "select score_number from score 
                        where subject_id = '$subject_id' and register_id='$register_id' and month_id='$get->month_id'";
                        $data3 = $db->query($sql3);
                $data2[$a]['score'] = $data3[0]['score_number'];
            }
            $data1[$i]['subject'] = $data2;
        }
        $list = json_encode($data1);
        echo $list;
    }
    public function scoreListTerm($get)
    {
        $db = new DatabaseController();
        $sql1 = "select register_id,r.student_id,s.name,surname,s.image,gender,birthday,birth_address,address,guardian,tribes,s.remark,s.status,
                r.class_id,c.class_name,c.course_id,register_date,r.year_id,y.year_name,r.user_id,u.name,date_payment
                from register as r
                INNER JOIN student as s ON r.student_id = s.student_id
                INNER JOIN class as c ON r.class_id = c.class_id
                INNER JOIN school_year as y ON r.year_id =y.year_id
                INNER JOIN user as u ON r.user_id = u.user_id
                where r.class_id='$get->class_id' and r.year_id='$get->year_id'
                order by class_id desc ";
        // echo $sql;die();
        $data1 = $db->query($sql1);
        $count = $data1 > 0 ? count($data1) : "";
        for ($i = 0; $i < $count; $i++) {
            $course_id = $data1[$i]['course_id'];
            $register_id = $data1[$i]['register_id'];
            $sql2 = "select d.subject_id,subject_name 
                    from course_detail as d
                    INNER JOIN subject as s ON d.subject_id = s.subject_id
                    where course_id = '$course_id' order by detail_number asc";
            $data2 = $db->query($sql2);

            $count2 = $data2 > 0 ? count($data2) : "";
            for ($a = 0; $a < $count2; $a++) {
                $subject_id = $data2[$a]['subject_id'];
                $sql3 = "select score_number,s.month_id,month_name
                        from score as s
                        INNER JOIN month as m ON s.month_id = m.month_id
                        where subject_id = '$subject_id' and register_id='$register_id' and m.month_parent='$get->month_parent' or s.month_id='$get->month_id' ";
                        $data3 = $db->query($sql3);
                $data2[$a]['score'] = $data3;
            }
            $data1[$i]['subject'] = $data2;
        }
        $list = json_encode($data1);
        echo $list;
    }
}
