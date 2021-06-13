<?php

function validateScore($sc)
{
    $count = $sc>0?count($sc):"";
    for ($i = 0; $i < $count; $i++) {
        $score_number = $sc[$i]['score_number'];
        $register_id = $sc[$i]['register_id'];
        $month_id = $sc[$i]['month_id'];
        $subject_id = $sc[$i]['subject_id'];
        @$score_id = isset($sc[$i]['score_id']) && !empty($sc[$i]['score_id']) ? $sc[$i]['score_id'] : "";
        if(!empty($score_id)){
            checkID($score_id);
        }
        validateScoreNumber($score_number);
        validateregister_id($register_id);
        validateMonth_id($month_id);
        validateSubject_id($subject_id,$month_id,$register_id,$score_id);
    }
}

function checkID($score_id)
{
    $db = new DatabaseController();
    $sql = "select * from score where score_id='$score_id' ";
    $name = $db->query($sql);

    if ($name == 0) {
        PrintJSON("", " score ID: " . $score_id . " is not available!", 0);
        die();
    }
}
function validateScoreNumber($score_number)
{
    if (empty($score_number)) {
        PrintJSON("", "Score number is empty!", 0);
        die();
    }
}

function validateregister_id($register_id)
{
    if (!is_numeric($register_id)) {
        PrintJSON("", "register ID is number only!", 0);
        die();
    }
}

function validateMonth_id($month_id)
{
    if (!is_numeric($month_id)) {
        PrintJSON("", "month ID is number only!", 0);
        die();
    }
}
function validateSubject_id($subject_id,$month_id,$register_id,$score_id)
{
    $db = new DatabaseController();
    $sql = "select * from score where subject_id='$subject_id' and month_id='$month_id' and register_id='$register_id' and score_id<>'$score_id' ";
    $name = $db->query($sql);

    if ($name > 0) {
        PrintJSON("", "This student: {$subject_id} availabled score for this subject: {$subject_id} ", 0);
        die();
    }
}