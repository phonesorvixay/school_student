<?php

include "../services/services.php";
include 'database.controller.php';

class LoginController
{
    public function __construct()
    {
    }
    public function checkLogin($u)
    {
        $db = new DatabaseController();
        $sql = "select * from user where username='$u->username' and password='$u->password' and status = 1";
        $sql1 = "select user_id,name,username,u.role_id,
                role_name,permission,r.default_department
                from user as u
                INNER JOIN role as r ON u.role_id = r.role_id
                where username='$u->username' and password='$u->password' and u.status = 1";
        $name = $db->query($sql);
        $list = $db->query($sql1);
        $row = $name[0];
        if ($name > 0) {
            echo json_encode(array('status' => "1",
                'token' => registerToken($row),
                'data' => $list[0],
            ));
        } else {
            
            $sql = "select * from user where username='$u->username'";
            $name = $db->query($sql);
            
            $sql1 = "select * from user where password='$u->password'";
            $pass = $db->query($sql1);

            if ($name == 0 && $pass == 0) {
                PrintJSON("", "Wrong username and password!!!", 0);
            } else if ($name > 0 && $pass == 0) {
                PrintJSON("", "Wrong password!!!", 0);
            } else if ($name == 0 && $pass > 0) {
                PrintJSON("", "Wrong username!!!", 0);
            } else if ($name > 0 && $pass > 0) {
                PrintJSON("", "Wrong username or password!!!", 0);
            }
        }
    }
}
