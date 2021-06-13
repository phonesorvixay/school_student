<?php

class RegisterModel
{
    public $register_id;
    public $student_id;
    public $class_id;
    public $year_id;
    public $date_payment;

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
            if (property_exists('RegisterModel', $property)) {
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
            case 'student_id':
                $this->validateStudent_id();
                break;
            case 'class_id':
                $this->validateClass_id();
                break;
            case 'year_id':
                $this->validateYear_id();
                break;
            case 'date_payment':
                $this->validatePayment();
                break;
            
        }
    }
    public function checkID()
    {
        $db = new DatabaseController();
        $sql = "select * from register where register_id='$this->register_id' ";
        $name = $db->query($sql);
        
        if ($name == 0) {
            PrintJSON("", " register ID: " . $this->register_id . " is not available!", 0);
            die();
        }
    }
    public function validateStudent_id()
    {
        $db = new DatabaseController();
        $sql = "select * from student where student_id='$this->student_id'  ";
        $name = $db->query($sql);
        
        $sql1 = "select * from register where student_id='$this->student_id' and year_id='$this->year_id' ";
        $name1 = $db->query($sql1);
        
        if ($name == 0) {
            PrintJSON("", " student ID: " . $this->student_id . " is not available!", 0);
            die();
        }else if($name1 >0){
            PrintJSON("","Student ID: $this->student_id is registered",0 );
            die();
        }
    }
    public function validateClass_id()
    {
        $db = new DatabaseController();
        $sql = "select * from class where class_id='$this->class_id' ";
        $name = $db->query($sql);
        
        if ($name == 0) {
            PrintJSON("", " class ID: ".$this->cate_id. " is not available!", 0);
            die();
        }
    }
    public function validateYear_id()
    {
        $db = new DatabaseController();
        $sql = "select * from school_year where year_id='$this->year_id' ";
        $name = $db->query($sql);
        
        if ($name == 0) {
            PrintJSON("", " year ID: ".$this->year_id. " is not available!", 0);
            die();
        }
    }
    public function validatePayment()
    {
        $dateTime = DateTime::createFromFormat('Y-m-d', $this->date_payment);
        if (!$dateTime) {
            PrintJSON("", "payment date is not Date format", 0);
            die();
        }
    }
}