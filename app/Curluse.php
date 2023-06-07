<?php

namespace App;

class Curluse
{
    
    
    public function Curldata($cUrl, $header){
            $cURLConnection = curl_init();
            curl_setopt($cURLConnection, CURLOPT_URL, $cUrl);
            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $header);

            $curl_data = curl_exec($cURLConnection);
           
            curl_close($cURLConnection);
            return $curl_data;
    }
    
    
    public function CurlPostdata($cUrl, $pixelData, $header){
            $cURLConnection = curl_init();
            curl_setopt($cURLConnection, CURLOPT_URL, $cUrl);
            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, 'POST');
            curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $pixelData);
            curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $header);

            $curl_data = curl_exec($cURLConnection);
            curl_close($cURLConnection);
            return $curl_data;
    }
    
    
    public function CurlPutdata($cUrl, $pixelData, $header){
            $cURLConnection = curl_init();
            curl_setopt($cURLConnection, CURLOPT_URL, $cUrl);
            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, 'PUT');
            curl_setopt($cURLConnection, CURLOPT_POSTFIELDS, $pixelData);
            curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $header);

            $curl_data = curl_exec($cURLConnection);
           
            curl_close($cURLConnection);
           
    }
    
    
     public function Curldeldata($cUrl, $header){
            $cURLConnection = curl_init();
            curl_setopt($cURLConnection, CURLOPT_URL, $cUrl);
            curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($cURLConnection, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($cURLConnection, CURLOPT_HTTPHEADER, $header);

            $curl_data = curl_exec($cURLConnection);
           
            curl_close($cURLConnection);
           
    }
    
}