<?php

namespace App\Helpers;

class ImgurUploadHelper{
    private $apiUrl;
    private $clientId;

    public function __construct($apiUrl, $clientId){
        $this->apiUrl = $apiUrl;
        $this->clientId = $clientId;
    }

    public function upload($filename){
        try{
            $cf = new \CURLFile($filename);
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $this->apiUrl);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, ["image" => $cf]);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt( $ch, CURLOPT_HTTPHEADER, 
            [ 
                'Authorization: Client-ID ' . $this->clientId 
            ]);
            $result = curl_exec($ch);
            $result = json_decode($result);
            curl_close($ch);
        }
        catch(\Exception $e){
            return null;
        }
        if ($result->status != 200){
            return null;
        }
        return $result->data->link;
    }
}