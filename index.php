<?php
if(isset($_POST['submit'])) {
    foreach($_POST as $key => $value) {
        $_POST[$key] = htmlentities($value);
    }
    $days_in_month = cal_days_in_month(CAL_GREGORIAN, $_POST['month'], $_POST['year']);
    $days_not_worked = explode(',',$_POST['nowork']);
    include('templates/timeclock.php');
    exit(0);
} else {
    include('templates/form.php');
}