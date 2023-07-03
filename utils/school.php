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


        
    function get_school_results($school_reg_no, $year, $json = false){
        try{
            global $client;
            // convert to lowercase
            $school_reg_no = strtolower($school_reg_no);

            $school_result_link = "https://onlinesys.necta.go.tz/results/".$year."/csee/results/".$school_reg_no.".htm";

            $crawler = $client->request('GET', $school_result_link);

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
            if($json){
                return json_encode($dataframe);
            }
            return $dataframe;
        }
        catch(Exception $e){
            return array("Error" => "Something went wrong or School results are not found");
        }
        
    }
    
?>
