<?php
class lztMarket
{
    private $token;
    public $api_gateway = "https://api.lzt.market/";

    public function __construct($token = null)
    {
        $this->token = $token;
    }

    public function CustomRequest($api = null)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->api_gateway,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_SSL_VERIFYPEER => false,
        ]);
        $response = curl_exec($curl);
        $response = json_decode($response);
        return $response;
    }

    public function Request($api_path = null)
    {
        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => $this->api_gateway . ltrim($api_path, "/"),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                'Authorization: Bearer ' . $this->token
            ],
            CURLOPT_SSL_VERIFYPEER => false,
        ]);
        $response = curl_exec($curl);
        $response = json_decode($response);
        return $response;
    }

    public function GetSteam($page = 1)
    {
        $request = $this->Request('/steam?page=' . $page);
        return $request;
    }

    public function ToThaiBaht(float $usd)
    {
        return $usd * 36.7056452469;
    }

}