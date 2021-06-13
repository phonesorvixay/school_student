<?php
include "../services/services.php";
include 'database.controller.php';
class MonthController
{
    public function __construct()
    {
    }
    public function addMonth($m)
    {
        try {
            $db = new DatabaseController();
            $sql = "insert into month (month_name,month_parent,month_number) values ('$m->month_name','$m->month_parent','$m->month_number')";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "add month OK!", 1);
            } else {
                PrintJSON("", "add month failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function updateMonth($m)
    {
        try {
            $db = new DatabaseController();
            $sql = "update month set month_name='$m->month_name',month_parent='$m->month_parent',month_number='$m->month_number' where month_id='$m->month_id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "udpate month OK!", 1);
            } else {
                PrintJSON("", "update month failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function deleteMonth($m)
    {
        try {
            $db = new DatabaseController();
            $sql = "delete from month where month_id='$m->month_id' ";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "month ID: " . $m->month_id . " delete Ok", 1);
            } else {
                PrintJSON("", "delete class failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function MonthList($get)
    {
        try {
            $db = new DatabaseController();

            if ($get->page == "" && $get->limit == "") {
                $sql = "select * from month order by month_number asc ";
                $doquery = $db->query($sql);
                $list = json_encode($doquery);
                $json = "{\"Data\":$list}";
                echo $json;
            } else {
                $offset = (($get->page - 1) * $get->limit);

                $sql = "select * from month ";
                if (isset($get->keyword) && $get->keyword != "") {
                    $sql .= "where
                        month_id like '%$get->keyword%' or
                        month_name like '%$get->keyword%' or
                        month_parent like '%$get->keyword%'
                          ";
                }
                $sql_page = "order by month_number asc  limit $get->limit offset $offset  ";
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
    public function monthListByParent($get)
    {
        try {
            $db = new DatabaseController();

            $sql = "select * from month where month_parent='$get->month_parent' order by month_number asc ";
            $doquery = $db->query($sql);
            $json = json_encode($doquery);
            echo $json;
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function MonthTree()
    {
        try {

            $db = new DatabaseController();
            $sql = "select * from month order by month_parent asc, month_id asc";
            $data = $db->query($sql);
            $json = $this->createMonthTree($data);
            echo $json;
        } catch (Exception $e) {
            print_r($e);
        }
    }
      
    public function createMonthTree($data){
        $itemsByReference = array();

        foreach($data as $key => &$item) {
            // print_r($item);sss
            $itemsByReference[$item['month_id']] = &$item;
            // Children array:
            $itemsByReference[$item['month_id']]['children'] = array();
            // Empty data class (so that json_encode adds "data: {}" ) 
            // $itemsByReference[$item['group_id']]['data'] = new StdClass();
         }
         
         // Set items as children of the relevant parent item.
         foreach($data as $key => &$item)
            if($item['month_parent'] && isset($itemsByReference[$item['month_parent']]))
               $itemsByReference [$item['month_parent']]['children'][] = &$item;
         
         // Remove items that were added to parents elsewhere:
         foreach($data as $key => &$item) {
            if($item['month_id'] && isset($itemsByReference[$item['month_parent']]))
               unset($data[$key]);
         }
         // Encode:
         $json = json_encode($data);
         return $json;
    }
}
