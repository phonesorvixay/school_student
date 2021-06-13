<?php

class SubjectModel
{
    public $subject_id;
    public $subject_name;
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
            if (property_exists('SubjectModel', $property)) {
                $this->$property = $value;
            }
        }
    }
    public function checkId()
    {
        $db = new DatabaseController();
        $sql = "select * from subject where subject_id='$this->subject_id' ";
        $name = $db->query($sql);
        
        if ($name == 0) {
            PrintJSON(""," subject ID: ".$this->subject_id. " is not available!", 0);
            die();
        } 
    }
   
    function validateSubject_name()
    {
        $db = new DatabaseController();
        $sql = "select * from subject where subject_name='$this->subject_name' and subject_id !='$this->subject_id' ";
        $name = $db->query($sql);
        
        if ($name > 0) {
            PrintJSON("", " subject name: " . $this->subject_name . " already exist", 0);
            die();
        }
        if ($this->subject_name == "") {
            PrintJSON("", "subject name is empty!", 0);
            die();
        }
    }

}
