<?php
require 'school.php';

$year = 2021;
$school_reg_no = "p0104";

$res = get_school_results($school_reg_no, $year);

print_r($res);

?>

