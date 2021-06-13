<?php

class ClassModel
{
    public $class_id;
    public $level_id;
    public $class_name;
    public $teacher_id;
    public $status;
    public $course_id;

    public $page;
    public $limit;
    public $keyword;
    public $year_id;
    public function __construct($object)
    {
        if (!$object) {
            echo '{"message":" data is empty"}';
            die();
        }
        foreach ($object as $property => $value) {
            if (property_exists('ClassModel', $property)) {
                $this->$property = $value;
            }
        }
    }
    public function checkId()
    {
        $db = new DatabaseController();
        $sql = "select * from class where class_id='$this->class_id' ";
        $name = $db->query($sql);
        
        if ($name == 0) {
            PrintJSON(""," class ID: ".$this->cate_id. " is not available!", 0);
            die();
        } 
    }
   
    function validateClass_name()
    {
        if ($this->class_name == "") {
            PrintJSON("", "class name is empty!", 0);
            die();
        }
    }
    function validateCourse_id()
    {
        if ($this->course_id == "") {
            PrintJSON("", "course id is empty!", 0);
            die();
        }
    }
    public function validateTeacher_id()
    {
        $db = new DatabaseController();
        $sql = "select * from teacher where teacher_id='$this->teacher_id' ";
        $name = $db->query($sql);

        if ($name == 0) {
            PrintJSON("", " teacher ID: " . $this->teacher_id . " is not available!", 0);
            die();
        }
    }

}
