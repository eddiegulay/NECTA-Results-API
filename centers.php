<?php
    require 'vendor/autoload.php';
    require 'data.php';

    use Goutte\Client;
    use GuzzleHttp\Client as GuzzleClient;

    // Create a new Guzzle client with certificate verification enabled
    $guzzleClient = new GuzzleClient([
        'verify' => 'vendor/certificate/cacert-2023-05-30.pem' // Replace with the path to your CA certificate bundle file
    ]);

    // Create a new Goutte client with the Guzzle client
    $client = new Client();
    $client->setClient($guzzleClient);

    // function to create data frame chunks
    function generate_frame($school){
        try{
            $str_arr = explode(" ", $school);
            $reg_no = $str_arr[0];
            $name = $school;
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
        catch(Exception $e){
           return array();
        }
    }
    
    function get_centers($year, $json = false){
        global $client, $center_data_link;
        try{
            $crawler = $client->request('GET', $center_data_link[$year]);

            $table = $crawler->filter('body table')->last();
            $dataframe = []; 
            $table->filter('tr')->each(function ($row) use (&$dataframe) {
                $rowData = [];
                $row->filter('td')->each(function ($cell) use (&$rowData) {
                    $school = $cell->text();
                    $data = generate_frame($school);
                    if (count($data) > 0 && $data != null) {
                        $rowData[] = $data; 
                    }
                });
                if (count($rowData) > 0) {
                    $dataframe[] = $rowData; 
                }
            });
            if($json){
                return json_encode($dataframe);
            }
            return $dataframe;
        }
        catch(Exception $e){
            return array("Error" => "Something went wrong Or data not available");
        }
    }
?>