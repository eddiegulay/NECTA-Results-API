<?php

require 'src/Necta/Necta.php';

// Create a new instance of the Necta class
$necta = new Necta();

// Example usage: Get centers for a specific year
$year = 2021;
$centers = $necta->get_centers($year);

// Example usage: Get school results for a specific registration number and year
$school_reg_no = 'S6137';
$year = 2021;
$results = $necta->get_school_results($school_reg_no, $year);

// Display the results
echo "Centers for year {$year}: <pre>";
print_r($centers);
echo "</pre>";

echo "Results for school registration number {$school_reg_no} and year {$year}: <pre>";
print_r($results);
echo "</pre>";



?>