<?php

class StudentModel
{
    public $student_id;
    public $name;
    public $surname;
    public $gender;
    public $birthday;
    public $birth_address;
    public $address;
    public $guardian;
    public $tribes;
    public $remark;
    public $image;

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
            if (property_exists('StudentModel', $property)) {
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
            case 'birth_address':
                $this->validateBirth_Address();
                break;
            case 'address':
                $this->validateAddress();
                break;
            case 'guardian':
                $this->validateGuardian();
                break;
            case 'tribes':
                $this->validateTribes();
                break;
            // case 'image':
            //     $this->validateImage();
            //     break;
        }
    }
    public function checkID()
    {
        $db = new DatabaseController();
        $sql = "select * from student where student_id='$this->student_id' ";
        $name = $db->query($sql);
        
        if ($name == 0) {
            PrintJSON("", " student ID: " . $this->student_id . " is not available!", 0);
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
    public function validateBirth_Address()
    {
        if ($this->birth_address == "") {
            PrintJSON("", "birth address is empty ", 0);
            die();
        }
    }
    public function validateGuardian()
    {
        if ($this->guardian == "") {
            PrintJSON("", "guardian is empty ", 0);
            die();
        }
    }
    public function validateTribes()
    {
        if ($this->tribes == "") {
            PrintJSON("", "tribes is empty ", 0);
            die();
        }
    }
    // public function validateImage()
    // {
    //     if ($this->image == "") {
    //         PrintJSON("", "image is empty ", 0);
    //         die();
    //     }
    // }
}
