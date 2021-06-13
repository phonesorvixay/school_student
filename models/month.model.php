<?php

class MonthModel
{
    public $month_id;
    public $month_name;
    public $month_parent;
    public $month_number;

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
            if (property_exists('MonthModel', $property)) {
                $this->$property = $value;
            }
        }
    }
    public function validateall()
    {
        foreach ($this as $property => $value) {
            $this->validate($property);
        }
    }
    public function validate($p)
    {
        switch ($p) {
            case 'month_name':
                $this->validateMonth_name();
                break;
            case 'month_parent':
                $this->validateMonth_parent();
                break;
        }
    }
    public function checkID()
    {
        $db = new DatabaseController();
        $sql = "select * from month where month_id='$this->month_id' ";
        $name = $db->query($sql);
        
        if ($name == 0) {
            PrintJSON("", " month ID: " . $this->month_id . " is not available!", 0);
            die();
        }
    }
    public function validateMonth_name(){
        if(empty($this->month_name)){
            PrintJSON("","month name is empty!",0);
            die();
        }
    }
    public function validateMonth_parent(){
        if($this->month_parent == ""){
            PrintJSON("","month parent is empty!",0);
            die();
        }
    }
}