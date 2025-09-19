<?php
class MaeManee
{
    private $accessKey;
    public $api_gateway = "https://slipsplus.com/api/mae_manee/";

    public function __construct($accessKey = null)
    {
        $this->accessKey = $accessKey;
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
                'access-key: ' . $this->accessKey
            ],
            CURLOPT_SSL_VERIFYPEER => false,
        ]);
        $response = curl_exec($curl);
        $response = json_decode($response);
        return $response;
    }

    public function GetInfo()
    {
        $request = $this->Request('/info/get');
        return $request;
    }

    public function GetTransactions()
    {
        $request = $this->Request('/transactions/get');
        return $request;
    }

    public function GenerateQrCode($merchant_id, $ref, $amount)
    {
        $request = $this->Request("/qrcode/generate/$merchant_id/$ref/$amount");
        return $request;
    }

}