<?php

class CourseModel
{
    public $course_id;
    public $course_name;
    public $status;
    // public $block;

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
            if (property_exists('CourseModel', $property)) {
                $this->$property = $value;
            }
        }
    }
    public function checkId()
    {
        $db = new DatabaseController();
        $sql = "select * from course where course_id='$this->course_id' ";
        $name = $db->query($sql);
        
        if ($name == 0) {
            PrintJSON(""," course ID: ".$this->course_id. " is not available!", 0);
            die();
        } 
    }
   
    function validateCourse_name()
    {
        $db = new DatabaseController();
        $sql = "select * from course where course_name='$this->course_name' and course_id !='$this->course_id' ";
        $name = $db->query($sql);
        
        if ($name > 0) {
            PrintJSON("", " course name: " . $this->course_name . " already exist", 0);
            die();
        }
        if (empty($this->course_name)) {
            PrintJSON("", "course name is empty!", 0);
            die();
        }
    }

}
