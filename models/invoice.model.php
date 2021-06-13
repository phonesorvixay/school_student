<?php

class InvoiceModel
{
    public $invoice_id;
    public $year_id;
    public $status;
    public $amount;
    public $tax;
    public $discount;
    public $total;
    public $remark;
    public $date_payment;
    public $register_id;

    public function __construct($object)
    {
        if (!$object) {
            PrintJSON("", "data is empty!", 0);
            die();
        }
        foreach ($object as $property => $value) {
            if (property_exists('InvoiceModel', $property)) {
                $this->$property = $value;
            }
        }
    }
    public function checkAllProperties()
    {
        foreach ($this as $property => $value) {
            $this->validate($property);
        }
    }
    public function checkId()
    {
        $db = new DatabaseController();
        $sql = "select * from invoice where invoice_id='$this->invoice_id' ";
        $name = $db->query($sql);
        
        if ($name == 0) {
            PrintJSON(""," invoice ID: ".$this->invoice_id. " is not available!", 0);
            die();
        } 
    }
    public function validatePayment()
    {
        if ($this->pay_by == "") {
            PrintJSON("", "pay ment is empty!", 0);
            die();
        }
    }
    public function validate($p)
    {
        switch ($p) {
            case 'register_id':
                $this->validateRegister_id();
                break;
            case 'year_id':
                $this->validateYear_id();
                break;
            case 'amount':
                $this->validateAmount();
                break;
        }
    }
    public function validateRegister_id()
    {
        $db = new DatabaseController();
        $sql = "select * from register where register_id='$this->register_id' ";
        $name = $db->query($sql);
        
        if ($name == 0) {
            PrintJSON("", " register ID: " . $this->register_id . " is not available!", 0);
            die();
        }
    }
    public function validateYear_id()
    {
        $db = new DatabaseController();
        $sql = "select * from school_year where year_id='$this->year_id' ";
        $name = $db->query($sql);
        
        if ($name == 0) {
            PrintJSON("", " year ID: " . $this->year_id . " is not available!", 0);
            die();
        }
    }
    public function validateAmount()
    {
        if ($this->amount == "") {
            PrintJSON("", "amount is empty", 0);
            die();
        }
    }
}
