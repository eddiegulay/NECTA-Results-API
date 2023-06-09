<?php

$str = "P0167 KIDUGALA SEMINARY CENTRE";
function generate_frame($school){
    $str_arr = explode(" ", $school);
    $reg_no = $str_arr[0];
    $name = $str_arr[1];
    $number = substr($reg_no, 1);
    $year = 2021;
    $data = array(
        "number" => $number,
        "reg_no" => $reg_no,
        "name" => $name,
        "link" => "https://onlinesys.necta.go.tz/results/".$year."/csee/results/p".$number.".htm"
    );

    return $data;
}
print_r(generate_frame($str));
?>