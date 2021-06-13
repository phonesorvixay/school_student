<?php

class CourseDetailModel
{
    public $detail_id;
    public $course_id;
    public $subject_id;
    public $teacher_id;
    public $detail_number;
    public $remark;

    public $page;
    public $limit;
    public $keyword;
    public function __construct($object)
    {
        if (!$object) {
            echo '{"message":" data is empty"}';
            die();
        }
        foreach ($object as $property => $value) {
            if (property_exists('CourseDetailModel', $property)) {
                $this->$property = $value;
            }
        }
    }
    public function checkId()
    {
        $db = new DatabaseController();
        $sql = "select * from course_detail where detail_id='$this->detail_id' ";
        $name = $db->query($sql);
        
        if ($name == 0) {
            PrintJSON(""," course detail ID: ".$this->detail_id. " is not available!", 0);
            die();
        } 
    }
    public function validateCourse_id()
    {
        $db = new DatabaseController();
        $sql = "select * from course where course_id='$this->course_id' ";
        $name = $db->query($sql);
        
        if ($name == 0) {
            PrintJSON(""," course ID: ".$this->course_id. " is not available!", 0);
            die();
        } 
    }    public function validateSubject_id()
    {
        $db = new DatabaseController();
        $sql = "select * from subject where subject_id='$this->subject_id' ";
        $name = $db->query($sql);
        
        if ($name == 0) {
            PrintJSON(""," suject ID: ".$this->subject_id. " is not available!", 0);
            die();
        } 
    }
    public function validateTeacher_id()
    {
        if (!is_numeric($this->teacher_id)) {
            PrintJSON("", "teacher ID is number only!", 0);
            die();
        }
    }
    
}
