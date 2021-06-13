<?php

class TeacherModel
{
    public $teacher_id;
    public $name;
    public $surname;
    public $gender;
    public $birthday;
    public $address;
    public $phonenumber;
    public $status;
    public $image;

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
            if (property_exists('TeacherModel', $property)) {
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
            case 'name':
                $this->validateName();
                break;
            case 'surname':
                $this->validateSurname();
                break;
            case 'gender':
                $this->validateGender();
                break;
            case 'birthday':
                $this->validateBirthday();
                break;
            case 'address':
                $this->validateAddress();
                break;
            case 'phonenumber':
                $this->validatePhonenumber();
                break;
            case 'image':
                $this->validateSurname();
                break;
        }
    }
    public function checkID()
    {
        $db = new DatabaseController();
        $sql = "select * from teacher where teacher_id='$this->teacher_id' ";
        $name = $db->query($sql);
        
        if ($name == 0) {
            PrintJSON("", " teacher ID: " . $this->teacher_id . " is not available!", 0);
            die();
        }
    }
    public function validateName()
    {
        if (strlen($this->name) < 2) {
            PrintJSON("", "name is short ", 0);
            die();
        } elseif ($this->name == "") {
            PrintJSON("", "name is empty ", 0);
            die();
        }
    }
    public function validateSurname()
    {
        if (strlen($this->surname) < 2) {
            PrintJSON("", "  surname is short ", 0);
            die();
        } elseif ($this->surname == "") {
            PrintJSON("", "surname is empty ", 0);
            die();
        }
    }
    public function validateGender()
    {
        if ($this->gender == "") {
            PrintJSON("", "gender is empty ", 0);
            die();
        }
    }
    public function validateBirthday()
    {
        $dateTime = DateTime::createFromFormat('Y-m-d', $this->birthday);
        if (!$dateTime) {
            PrintJSON("", "birthday is not Date format", 0);
            die();
        }
    }
    public function validateAddress()
    {
        if ($this->address == "") {
            PrintJSON("", "address is empty ", 0);
            die();
        }
    }
    public function validatePhonenumber()
    {
        if ($this->phonenumber == "") {
            PrintJSON("", "phonenumber is empty ", 0);
            die();
        }
    }
    public function validateImage()
    {
        if ($this->image == "") {
            PrintJSON("", "image is empty ", 0);
            die();
        }
    }
}
