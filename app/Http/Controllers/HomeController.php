<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    public function build_url($path)
    {
        return "https://business-api.tiktok.com" . $path;
    }
    
    
    public function get($json_str,$ACCESS_TOKEN,$PATH)
    {
        //global $ACCESS_TOKEN, $PATH;
        $curl = curl_init();
    
        $args = json_decode($json_str, true);
    
        /* Values of querystring is also in JSON format */
        
        foreach ($args as $key => $value) {
            $args[$key] = is_string($value) ? $value : json_encode($value);
        }
    
        $url = $this->build_url($PATH) . "?" . http_build_query(
                $args
            );
    
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "Access-Token: " . $ACCESS_TOKEN,
            ),
        ));
    
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
    
    public function get_stats(Request $request)
    {
        
        $advertiser_id = "7146405922712076290";
        $start_date = "2022-10-01";
        $end_date = "2022-10-30";
        $pixel_ids_list= "CBLM2G3C77UDK33Q2PBG";
        $pixel_ids = json_encode($pixel_ids_list);
        
        $ACCESS_TOKEN = "1696c2895c8228d7f2a0d81a74ef5c8e878795b2";
        $PATH = "/open_api/v1.3/pixel/event/stats/";

        
        /* Args in JSON format */
        $my_args = sprintf("{\"advertiser_id\": \"%s\", \"date_range\": {\"start_date\": \"%s\", \"end_date\": \"%s\"}, \"pixel_ids\": %s}", $advertiser_id, $start_date, $end_date, $pixel_ids);
        return $this->get($my_args,$ACCESS_TOKEN,$PATH);
        
    }
    
}



