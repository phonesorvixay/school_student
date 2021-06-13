<?php

class UserModel
{
    public $user_id;
    public $name;
    public $username;
    public $password;   
    public $new_password;
    public $status;
    public $remark;
    public $role_id;

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
            if (property_exists('UserModel', $property)) {
                $this->$property = $value;
            }
        }
    }
    public function checkId()
    {
        $db = new DatabaseController();
        $sql = "select * from user where user_id='$this->user_id' ";
        $name = $db->query($sql);

        if ($name == 0) {
            PrintJSON("", " user ID: " . $this->user_id . " is not available!", 0);
            die();
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
            case 'username':
                $this->validateUserName();
                break;
            case 'name':
                $this->validatename();
                break;
        }
    }
    public function validatename()
    {
        if (strlen($this->name) < 2) {
            PrintJSON("", "  name is short ", 0);
            die();
        }
    }
    public function validateUsername()
    {
        $db = new DatabaseController();
        $sql = "select * from user where username='$this->username' and user_id !='$this->user_id' ";
        $name = $db->query($sql);
        if ($name > 0) {
            PrintJSON("", " username: " . $this->username . " already exist", 0);
            die();
        }
        if (strlen($this->username) < 3) {
            PrintJSON("", "username is short ", 0);
            die();
        }
    }public function validatePass()
    {
        // $db = new DatabaseController();
        // $sql = "select * from user where password='$this->password' and user_id !='$this->user_id' ";
        // $name = $db->query($sql);
        // if (sizeof($name) > 0) {
        //     PrintJSON("", " password: " . $this->password . " already exist", 0);
        //     die();
        // }
        if (strlen($this->password) < 6) {
            PrintJSON("", "password is short ", 0);
            die();
        }
    }
    public function validatePassword()
    {
        $db = new DatabaseController();
        $user_id = $_SESSION['uid'];
        $sql = "select * from user where password='$this->password' and user_id='$user_id' ";
        $name = $db->query($sql);

        $sql1 = "select * from user where password='$this->new_password' and user_id !='$user_id' ";
        $name1 = $db->query($sql1);

        if ($name == 0) {
            PrintJSON("", "old password: " . $this->password . " is not available!", 0);
            die();
        } else if ($name1 > 0) {
            PrintJSON("", "new password: " . $this->new_password . " already exist", 0);
            die();
        } else if (strlen($this->password) < 3) {
            PrintJSON("", "password is short ", 0);
            die();
        }
    }

}
