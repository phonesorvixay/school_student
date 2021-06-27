<?php
include "../services/services.php";
include 'database.controller.php';
class ReportController
{
    public function __construct()
    {
    }

    public function reportPayment($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "select invoice_id,i.register_id,s.name,s.surname,i.year_id,y.year_name,invoice_date,username,i.status,amount,tax, discount,total,i.remark,
                    r.class_id,class_name,c.level_id,level_name                          
                    from invoice as i
                    INNER JOIN register as r ON i.register_id = r.register_id
                    INNER JOIN class as c ON r.class_id = c.class_id
                    INNER JOIN level as l ON c.level_id = l.level_id
                    INNER JOIN student as s ON r.student_id = s.student_id
                    INNER JOIN school_year as y ON i.year_id = y.year_id 
                    where invoice_date between '$get->first_date' and '$get->last_date' order by invoice_id desc  ";
            $doquery = $db->query($sql);
            $list = json_encode($doquery);
            $json = "{\"Data\":$list}";
            echo $json;
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function reportNoPayment($get)
    {
        try {
            $db = new DatabaseController();

            $sql = "select register_id,r.student_id,s.name,surname,s.image,gender,birthday,birth_address,address,guardian,tribes,s.remark,s.status,
                        r.class_id,c.class_name,register_date,r.year_id,y.year_name,r.user_id,u.name,date_payment
                        from register as r
                        INNER JOIN student as s ON r.student_id = s.student_id
                        INNER JOIN class as c ON r.class_id = c.class_id
                        INNER JOIN school_year as y ON r.year_id =y.year_id
                        INNER JOIN user as u ON r.user_id = u.user_id
                        where register_id NOT IN (select register_id from invoice where invoice_date > date(curdate()))
                        and r.year_id='$get->year_id'";

            if (isset($get->class_id) && !empty($get->class_id)) {
                $sql .= " and r.class_id='$get->class_id'";
            }

            $sql .= " order by class_id desc ";
            $doquery = $db->query($sql);
            $list = json_encode($doquery);
            $json = "{\"Data\":$list}";
            echo $json;
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function reportStudentRegister($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "select register_id,r.student_id,s.name,surname,s.image,gender,birthday,birth_address,address,guardian,tribes,s.remark,s.status,
                        r.class_id,c.class_name,register_date,r.year_id,y.year_name,r.user_id,u.name,date_payment
                        from register as r
                        INNER JOIN student as s ON r.student_id = s.student_id
                        INNER JOIN class as c ON r.class_id = c.class_id
                        INNER JOIN school_year as y ON r.year_id =y.year_id
                        INNER JOIN user as u ON r.user_id = u.user_id
                        where r.year_id='$get->year_id'
                        order by class_id desc ";
            $doquery = $db->query($sql);
            $list = json_encode($doquery);
            $json = "{\"Data\":$list}";
            echo $json;
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function reportStudentNoRegister($get)
    {
        try {
            $db = new DatabaseController();
            $sql = "select * from student where student_id NOT IN (select student_id from register where year_id='$get->year_id') order by student_id desc ";
            $doquery = $db->query($sql);
            $list = json_encode($doquery);
            $json = "{\"Data\":$list}";
            echo $json;
        } catch (Exception $e) {
            print_r($e);
        }
    }

    public function reportAssessLeaningByClass($get)
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
                        where subject_id = '$subject_id' and register_id='$register_id'";
                $data3 = $db->query($sql3);
                $data2[$a]['score'] = $data3;
            }
            $data1[$i]['subject'] = $data2;
        }
        $list = json_encode($data1);
        echo $list;
    }

    public function reportAssessLeaningYear($get)
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
                        where subject_id = '$subject_id' and register_id='$register_id'";
                $data3 = $db->query($sql3);
                $data2[$a]['score'] = $data3;
            }
            $data1[$i]['subject'] = $data2;
        }
        $list = json_encode($data1);
        echo $list;
    }
}
