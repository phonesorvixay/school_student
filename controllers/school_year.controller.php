<?php
include "../services/services.php";
include 'database.controller.php';
class School_yearController
{
    public function __construct()
    {
    }
    public function addSchool_year($year)
    {
        try {
            $db = new DatabaseController();
            $sql = "insert into school_year (year_name,status,remark) values ('$year->year_name','$year->status','$year->remark')";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "add school year OK!", 1);
            } else {
                PrintJSON("", "add school year failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function updateSchool_year($year)
    {
        try {
            $db = new DatabaseController();
            $sql = "update school_year set year_name='$year->year_name',status='$year->status',remark='$year->remark' where year_id='$year->year_id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "udpate school year OK!", 1);
            } else {
                PrintJSON("", "update school year failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function School_yearList($get)
    {
        try {
            $db = new DatabaseController();

            if ($get->page == "" && $get->limit == "") {
                $sql = "select * from school_year order by year_id desc ";
                $doquery = $db->query($sql);
                $list = json_encode($doquery);
                $json = "{\"Data\":$list}";
                echo $json;
            } else {
                $offset = (($get->page - 1) * $get->limit);

                $sql = "select * from school_year ";
                if (isset($get->keyword) && $get->keyword != "") {
                    $sql .= "where
                        year_id like '%$get->keyword%' or
                        year_name like '%$get->keyword%'
                          ";
                }
                $sql_page = "order by year_id desc limit $get->limit offset $offset  ";
                // echo $sql.$sql_page;die();
                $doquery = $db->query($sql);
                if ($doquery > 0) {
                    $count = sizeof($doquery);
                    if ($count > 0) {
                        $data = $db->query($sql . $sql_page);
                        $list1 = json_encode($data);
                    }
                } else {
                    $list1 = json_encode([]);
                    $count = 0;
                }

                $number_count = $count;
                $total_page = ceil($number_count / $get->limit);
                $list3 = json_encode($total_page);
                $json = "{  \"Data\":$list1,
                        \"Page\":$get->page,
                        \"Pagetotal\":$list3,
                        \"Datatotal\":$number_count
                    }";
                echo $json;
            }
        } catch (Exception $e) {
            print_r($e);
        }

    }
    public function School_yearListActive($get)
    {
        try {
            $db = new DatabaseController();

            if ($get->page == "" && $get->limit == "") {
                $sql = "select * from school_year where year_id=(select max(year_id) from school_year where status=1) order by year_id desc ";
                $doquery = $db->query($sql);
                $list = json_encode($doquery);
                $json = "{\"Data\":$list}";
                echo $json;
            } else {
                $offset = (($get->page - 1) * $get->limit);

                $sql = "select * from school_year where year_id=(select max(year_id) from school_year where status=1) ";
                if (isset($get->keyword) && $get->keyword != "") {
                    $sql .= "and (
                        year_id like '%$get->keyword%' or
                        year_name like '%$get->keyword%'
                    )";
                }
                $sql_page = "order by year_id desc limit $get->limit offset $offset  ";
                // echo $sql.$sql_page;die();
                $doquery = $db->query($sql);
                if ($doquery > 0) {
                    $count = sizeof($doquery);
                    if ($count > 0) {
                        $data = $db->query($sql . $sql_page);
                        $list1 = json_encode($data);
                    }
                } else {
                    $list1 = json_encode([]);
                    $count = 0;
                }

                $number_count = $count;
                $total_page = ceil($number_count / $get->limit);
                $list3 = json_encode($total_page);
                $json = "{  \"Data\":$list1,
                        \"Page\":$get->page,
                        \"Pagetotal\":$list3,
                        \"Datatotal\":$number_count
                    }";
                echo $json;
            }
        } catch (Exception $e) {
            print_r($e);
        }

    }
}
