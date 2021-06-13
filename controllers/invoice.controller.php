
<?php

include "../services/services.php";
include 'database.controller.php';
require_once "databasePDO.controller.php";

class InvoiceController
{

    public function __construct()
    {
    }
    public function addInvoice($iv, $dt)
    {
        // print_r($iv);die();
        try {
            $db = new PDODBController();

            date_default_timezone_set("Asia/Vientiane");
            $username = $_SESSION["name"];
            $invoice_date = date("Y-m-d");

            $db->beginTran();

            $sql = "insert into invoice (register_id,year_id,invoice_date,username,status,amount,tax,discount,total,remark)
                    values ('$iv->register_id','$iv->year_id','$invoice_date','$username',0,'$iv->amount','$iv->tax','$iv->discount','$iv->total','$iv->remark')";
            $db->query($sql);
            $ID = $db->lastID();
            $subsql = "insert into invoice_detail (invoice_id,detail_name,status,quantity,price,total,last_update,remark) values";
            for ($i = 0; $i < sizeof($dt); $i++) {
                $detail_name = $dt[$i]['detail_name'];
                $quantity = $dt[$i]['quantity'];
                $price = $dt[$i]['price'];
                $total = $dt[$i]['total'];
                $remark = $dt[$i]['remark'];
                if ($i == sizeof($dt) - 1) {
                    $subsql .= "($ID,'$detail_name',0,$quantity,'$price','$total','$invoice_date','$remark')";
                } else {
                    $subsql .= "($ID,'$detail_name',0,$quantity,'$price','$total','$invoice_date','$remark'),";
                }
            }
            // echo $subsql;die();
            $db->query($subsql);

            $subsql2 = "update register set date_payment='$iv->date_payment' where register_id ='$iv->register_id' ";
            // echo $subsql2;die();
            $db->query($subsql2);

            $db->commit();
            
            PrintJSON("", "add invoice OK!", 1);
        } catch (Exception $e) {
            $db->rollback();
            PrintJSON("", "add invoice fail error: " . $e->getMessage(), 0);
        }
    }
    public function payment($iv)
    {
        try {
            $db = new DatabaseController();
            $sql = "update invoice set status = 1 where invoice_id='$iv->invoice_id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "payment  OK!", 1);
            } else {
                PrintJSON("", "payment failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function cancel($iv)
    {
        try {
            $db = new DatabaseController();
            $sql = "update invoice set status = 2 where invoice_id='$iv->invoice_id'";
            $data = $db->query($sql);
            if ($data) {
                PrintJSON("", "cancel invoice  OK!", 1);
            } else {
                PrintJSON("", "cancel invoice failed!", 0);
            }
        } catch (Exception $e) {
            print_r($e);
        }
    }
    public function invoiceList($get)
    {
        try {
            $db = new DatabaseController();

            if ($get->page == "" && $get->limit == "") {
                $sql = "select invoice_id,i.register_id,s.name,s.surname,i.year_id,y.year_name,invoice_date,username,i.status,amount,tax, discount,total,i.remark
                        from invoice as i
                        INNER JOIN register as r ON i.register_id = r.register_id
                        INNER JOIN student as s ON r.student_id = s.student_id
                        INNER JOIN school_year as y ON i.year_id = y.year_id order by invoice_id desc  ";
                $doquery = $db->query($sql);
                $list = json_encode($doquery);
                $json = "{\"Data\":$list}";
                echo $json;
            } else {
                $offset = (($get->page - 1) * $get->limit);

                $sql = "select invoice_id,i.register_id,s.name,s.surname,i.year_id,y.year_name,invoice_date,username,i.status,amount,tax, discount,total,i.remark
                        from invoice as i
                        INNER JOIN register as r ON i.register_id = r.register_id
                        INNER JOIN student as s ON r.student_id = s.student_id
                        INNER JOIN school_year as y ON i.year_id = y.year_id
                        where i.status != 2 and i.register_id ='$get->register_id' and i.year_id='$get->year_id' ";
                if (isset($get->keyword) && $get->keyword != "") {
                    $sql .= "and (
                        invoice_id like '%$get->keyword%' or
                        i.register_id like '%$get->keyword%' or
                        s.name like '%$get->keyword%' or
                        s.surname like '%$get->keyword%' or
                        i.year_id like '%$get->keyword%' or
                        y.year_name like '%$get->keyword%' or
                        i.invoice_date like '%$get->keyword%' or
                        username like '%$get->keyword%'
                          )";
                }
                $sql_page = "order by invoice_id desc limit $get->limit offset $offset  ";
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
    public function getInvoice($iv)
    {
        try {
            $db = new DatabaseController();
            $sql1 = "select invoice_id,i.register_id,r.class_id,c.class_name,c.level_id,l.level_name,s.name,s.surname,i.year_id,y.year_name,invoice_date,username,i.status,amount,tax, discount,total,i.remark
                    from invoice as i
                    INNER JOIN register as r ON i.register_id = r.register_id
                    INNER jOIN class as c ON r.class_id = c.class_id
                    INNER jOIN level as l ON c.level_id = l.level_id
                    INNER JOIN student as s ON r.student_id = s.student_id
                    INNER JOIN school_year as y ON i.year_id = y.year_id
                    where  i.status !=2  and invoice_id='$iv->invoice_id' ";
            $data1 = $db->query($sql1);
            
            $list1 = json_encode($data1[0]);

            $sql2 = "select * from invoice_detail
                    where status!=2 and invoice_id='$iv->invoice_id' ";
            $data2 = $db->query($sql2);
            $list2 = json_encode($data2);

            $json = "{ \"invoice\":$list1,
                      \"invoice_detail\":$list2
                      }";
            echo $json;

        } catch (Exception $e) {
            print_r($e);
        }
    }

}
