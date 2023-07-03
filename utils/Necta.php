<?php

require 'vendor/autoload.php';
require 'data.php';

use Goutte\Client;
use GuzzleHttp\Client as GuzzleClient;

class Necta
{
    private $client;
    private $center_data_link;

    public function __construct()
    {
        // Create a new Guzzle client with certificate verification enabled
        $guzzleClient = new GuzzleClient([
            'verify' => 'vendor/certificate/cacert-2023-05-30.pem' // Replace with the path to your CA certificate bundle file
        ]);

        // Create a new Goutte client with the Guzzle client
        $this->client = new Client();
        $this->client->setClient($guzzleClient);

        $this->center_data_link  = array(
            "year" => "data_link",
            "2021" => "https://onlinesys.necta.go.tz/results/2021/csee/csee.htm",
            "2020" => "https://onlinesys.necta.go.tz/results/2020/csee/csee.htm",
        );
    }

    // function to create data frame chunks
    private function generate_frame($school)
    {
        try {
            $str_arr = explode(" ", $school);
            $reg_no = $str_arr[0];
            $name = $school;
            $number = substr($reg_no, 1);
            $year = 2021;
            $data = array(
                "number" => $number,
                "reg_no" => $reg_no,
                "name" => $name,
                "link" => "https://onlinesys.necta.go.tz/results/" . $year . "/csee/results/p" . $number . ".htm"
            );
            return $data;
        } catch (Exception $e) {
            return array();
        }
    }

    public function get_centers($year, $json = false)
    {
        try {
            $crawler = $this->client->request('GET', $this->center_data_link[$year]);

            $table = $crawler->filter('body table')->last();
            $dataframe = [];
            $table->filter('tr')->each(function ($row) use (&$dataframe) {
                $rowData = [];
                $row->filter('td')->each(function ($cell) use (&$rowData) {
                    $school = $cell->text();
                    $data = $this->generate_frame($school);
                    if (count($data) > 0 && $data != null) {
                        $rowData[] = $data;
                    }
                });
                if (count($rowData) > 0) {
                    $dataframe[] = $rowData;
                }
            });
            if ($json) {
                return json_encode($dataframe);
            }
            return $dataframe;
        } catch (Exception $e) {
            return array("Error" => "Something went wrong or data not available");
        }
    }

    public function get_school_results($school_reg_no, $year, $json = false)
    {
        try {
            // convert to lowercase
            $school_reg_no = strtolower($school_reg_no);

            $school_result_link = "https://onlinesys.necta.go.tz/results/" . $year . "/csee/results/" . $school_reg_no . ".htm";

            $crawler = $this->client->request('GET', $school_result_link);

            $table = $crawler->filter('body table')->last();
            $dataframe = [];
            $table->filter('tr')->each(function ($row) use (&$dataframe) {
                $rowData = [];
                $row->filter('td')->each(function ($cell, $index) use (&$rowData) {
                    $columnData = $cell->text();
                    switch ($index) {
                        case 0:
                            $rowData['CNO'] = $columnData;
                            break;
                        case 1:
                            $rowData['SEX'] = $columnData;
                            break;
                        case 2:
                            $rowData['AGGT'] = $columnData;
                            break;
                        case 3:
                            $rowData['DIV'] = $columnData;
                            break;
                        case 4:
                            // extract grades
                            $rowData['DETAILED SUBJECTS'] = $columnData;
                            break;
                        default:
                            break;
                    }
                });
                if (!empty($rowData)) {
                    $dataframe[] = $rowData;
                }
            });
            if ($json) {
                return json_encode($dataframe);
            }
            return $dataframe;
        } catch (Exception $e) {
            return array("Error" => "Something went wrong or school results are not found");
        }
    }
}

?>