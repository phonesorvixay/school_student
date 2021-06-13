<?php

class RoleModel
{
    public $role_id;
    public $role_name;
    public $permission;
    public $default_department;

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
            if (property_exists('RoleModel', $property)) {
                $this->$property = $value;
            }
        }
    }
    public function checkId()
    {
        $db = new DatabaseController();
        $sql = "select * from role where role_id='$this->role_id' ";
        $name = $db->query($sql);

        if ($name == 0) {
            PrintJSON("", " role ID: " . $this->role_id . " is not available!", 0);
            die();
        }
    }
    public function checkdelete()
    {
        $db = new DatabaseController();
        $sql = "select * from user where role_id='$this->role_id' ";
        $name = $db->query($sql);
        
        if ($name > 0) {
            PrintJSON("", " role ID: " . $this->role_id . " have foreign key in user", 0);
            die();
        }
    }
    public function validateRole_name()
    {
        $db = new DatabaseController();
        $sql = "select * from role where role_name='$this->role_name' and role_id!='$this->role_id' ";
        $name = $db->query($sql);

        if ($name > 0) {
            PrintJSON("", " role name: " . $this->role_name . " already exist!", 0);
            die();
        }
        if(empty($this->role_name)){
            PrintJSON("","role name is empty!",0);
            die();
        }
    }
    public function validatePermission(){
        if(empty($this->permission)){
            PrintJSON("","permission is empty",0);
            die();
        }
    }

}
