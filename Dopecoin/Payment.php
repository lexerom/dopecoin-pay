<?php
namespace Dopecoin;

use GuzzleHttp\Client as HttpClient;

class Payment
{
    const BASE_API_URI = 'http://payment.dopecoin.com/api';
    const ORDER_CREATE_PATH = 'order/create';
    
    const API_VERSION_1 = 'v1';
    
    const RESPONSE_STATUS_OK = 200;
    const RESPONSE_STATUS_ERROR = 500;
    const RESPONSE_STATUS_DENIED = 403;
    
    protected $apiVersion = 'v1';

    /**
     *
     * @var string 
     */
    protected $apiKey;
    
    /**
     *
     * @var HttpClient 
     */
    protected $httpClient;
    
    /**
     * 
     * @param string $apiKey Api key provided by payment.dopecoin.com
     */
    public function __construct($apiKey, $apiVersion = self::API_VERSION_1)
    {
        $this->apiKey = $apiKey;
        $this->httpClient = new HttpClient();
        $this->apiVersion = $apiVersion;
    }


    /**
     * This method returns redirect url (on success) where user must be redirected to proceed with payment.
     * 
     * @param float $amountUsd
     * @param string $description
     * @param string $successUrl
     * @param string $cancelUrl
     * @param string $notifyUrl
     * @param string $param1
     * @param string $param2
     * @return mixed
     */
    public function createOrder($amountUsd, $description, $successUrl, $cancelUrl, $notifyUrl, $param1 = null, $param2 = null)            
    {
        $responseJson = $this->httpClient->post(self::BASE_API_URI . '/' . $this->apiVersion . '/' . self::ORDER_CREATE_PATH, [
            'api_key' => $this->apiKey,
            'amount_usd' => $amountUsd,
            'description' => $description,
            'success_url' => $successUrl,
            'cancel_url' => $cancelUrl,
            'notify_url' => $notifyUrl,
            'p1' => $param1,
            'p2' => $param2
        ]);
        
        return \GuzzleHttp\json_decode($responseJson);                
    }
}