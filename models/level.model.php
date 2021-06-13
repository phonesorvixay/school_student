<?php

class LevelModel
{
    public $level_id;
    public $level_name;
    public $status;

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
            if (property_exists('LevelModel', $property)) {
                $this->$property = $value;
            }
        }
    }
    public function checkIdupdate()
    {
        $db = new DatabaseController();
        $sql = "select * from level where level_id='$this->level_id' ";
        $name = $db->query($sql);
        
        if ($name == 0) {
            PrintJSON(""," level ID: ".$this->level_id. " is not available!", 0);
            die();
        } 
    }
    public function checkIddelete()
    {
        $db = new DatabaseController();
        $sql = "select * from level where level_id='$this->level_id' ";
        $name = $db->query($sql);
                
        $sql1 = "select * from class where level_id='$this->level_id' ";
        $name1 = $db->query($sql1);
        
        if ($name == 0) {
            PrintJSON(""," level ID: ".$this->level_id. " is not available!", 0);
            die();
        }else if($name1 > 0 ){
            PrintJSON("","level ID: " .$this->level_id. " has foreign key in class",0);
            die();
        } 
    }
    function validateLevel_name()
    {
        $db = new DatabaseController();
        $sql = "select * from level where level_name='$this->level_name' and level_id !='$this->level_id' ";
         $name = $db->query($sql);
        
        if ($name == 0) {
            PrintJSON("", " level name: " . $this->level_name . " already exist", 0);
            die();
        }
        if ($this->level_name == "") {
            PrintJSON("", "level name is empty!", 0);
            die();
        }
    }

}
