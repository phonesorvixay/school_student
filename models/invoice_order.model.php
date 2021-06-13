<?php

function validateInvoice_order($order){

    for($i = 0; $i < sizeof($order); $i++ ){
        $detail_name = $order[$i]['detail_name'];
        $quantity = $order[$i]['quantity'];
        $price = $order[$i]['price'];
        $total = $order[$i]['total'];
        $remark = $order[$i]['remark'];

        validateDetail_name($detail_name);
        validateQuantity($quantity);
        validatePrice($price);
        validateTotal($total);
    }
}
function validateDetail_name($data){
    if($data == ""){
        PrintJSON("","Detail name is empty!",0);
        die();
    }
}
function validateQuantity($data){
    if($data == ""){
        PrintJSON("","quantity is empty!",0);
        die();
    }
}
function validatePrice($data){
    if($data == ""){
        PrintJSON("","price is empty!",0);
        die();
    }
}
function validateTotal($data){
    if($data == ""){
        PrintJSON("","Total is empty!",0);
        die();
    }
}

?>
