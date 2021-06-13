<?php

class ItemModel
{
    public $item_id;
    public $item_name;
    public $price;
    public $next_month;
    public $remark;

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
            if (property_exists('ItemModel', $property)) {
                $this->$property = $value;
            }
        }
    }
    public function checkId()
    {
        $db = new DatabaseController();
        $sql = "select * from item where item_id='$this->item_id' ";
        $name = $db->query($sql);
        
        if ($name == 0) {
            PrintJSON(""," item ID: ".$this->item_id. " is not available!", 0);
            die();
        } 
    }
   
    function validateItem_name()
    {
        $db = new DatabaseController();
        $sql = "select * from item where item_name='$this->item_name' and item_id !='$this->item_id' ";
        $name = $db->query($sql);
        
        if ($name > 0) {
            PrintJSON("", " item name: " . $this->item_name . " already exist", 0);
            die();
        }
        if (strlen($this->item_name) == "") {
            PrintJSON("", "item name is empty!", 0);
            die();
        }
    }
    function validatePrice()
    {
        if ($this->price == "") {
            PrintJSON("", "price is empty!", 0);
            die();
        }
    }
}
