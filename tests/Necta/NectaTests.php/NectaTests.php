<?php

require_once __DIR__ . '/../../src/Necta/Necta.php';

use Necta\Necta;
use PHPUnit\Framework\TestCase;

class NectaTests extends TestCase
{
    public function testGetCenters()
    {
        $necta = new Necta();

        // Example usage: Get centers for a specific year
        $year = 2021;
        $centers = $necta->get_centers($year);

        // Assert that the centers are not empty
        $this->assertNotEmpty($centers);

        // Additional assertions for the centers data can be added here
    }

    public function testGetSchoolResults()
    {
        $necta = new Necta();

        // Example usage: Get school results for a specific registration number and year
        $school_reg_no = 'S6137';
        $year = 2021;
        $results = $necta->get_school_results($school_reg_no, $year);

        // Assert that the results are not empty
        $this->assertNotEmpty($results);

        // Additional assertions for the school results data can be added here
    }
}
