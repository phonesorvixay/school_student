<?php

class School_yearModel
{
    public $year_id;
    public $year_name;
    public $status;
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
            if (property_exists('School_yearModel', $property)) {
                $this->$property = $value;
            }
        }
    }
    public function checkId()
    {
        $db = new DatabaseController();
        $sql = "select * from school_year where year_id='$this->year_id' ";
        $name = $db->query($sql);
        
        if ($name == 0) {
            PrintJSON(""," year ID: ".$this->year_id. " is not available!", 0);
            die();
        } 
    }
   
    function validateYear_name()
    {
        $db = new DatabaseController();
        $sql = "select * from school_year where year_name='$this->year_name' and year_id !='$this->year_id' ";
        $name = $db->query($sql);
        
        if ($name > 0) {
            PrintJSON("", " year name: " . $this->year_name . " already exist", 0);
            die();
        }
        if (strlen($this->year_name) == "") {
            PrintJSON("", "year name is empty!", 0);
            die();
        }
    }

}
