<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once "PaymentGatewayInterface.php";
require_once APPPATH.'third_party/braintree/braintree_php/lib/Braintree.php';

class Braintree implements PaymentGatewayInterface{
  private $config;
  private $ci;

  public function __construct(){
    $this->ci =& get_instance();
    $this->config = $this->ci->config->item('payment');
    $btCfg = $this->ci->config->item('braintree');
    Braintree_Configuration::environment($btCfg['enviroment']);
    Braintree_Configuration::merchantId($btCfg['merchantID']);
    Braintree_Configuration::publicKey($btCfg['publicKey']);
    Braintree_Configuration::privateKey($btCfg['privateKey']);
  }

  public function getToken($var = array()){
    return Braintree_ClientToken::generate();
  }

  public function directpay($var = array()){
    $payment = array(
                "amount" => $var['postVal']['amount'],
                "creditCard" => array(
                                  "number" => $var['postVal']['ccNum'],
                                  "cvv" => $var['postVal']['ccCCV'],
                                  "cardholderName" => $var['postVal']['ccHolder'],
                                  "expirationMonth" => $var['postVal']['ccExpMM'],
                                  "expirationYear" => $var['postVal']['ccExpYY']
                ),
                "merchantAccountId" => $var['postVal']['cur'],
                "options" => array(
                  "submitForSettlement" => true
                )
    );

    $sale = Braintree_Transaction::sale($payment);

    $result = array();
    
    if ($sale->success) {
        $result['status'] = "200";
        $result['detail']['id'] = $sale->transaction->id;
        $result['detail']['sales_id'] = $sale->transaction->id;
        $result['detail']['state'] = $sale->transaction->status;
        $result['detail']['create_time'] = $sale->transaction->createdAt->format("Y-m-d H:i:s");
        $result['detail']['update_time'] = $sale->transaction->updatedAt->format("Y-m-d H:i:s");
        $result['detail']['currency'] = $sale->transaction->currencyIsoCode;
        $result['detail']['amount'] = $sale->transaction->amount;
        $result['detail']['gateway'] = "Braintree";
    } else if ($sale->transaction) {
        $result['status'] = $sale->transaction->processorResponseCode;
        $result['errMsg'] = $sale->message;
    } else {
        $result['status'] = "400";
        $errMsg = "";
        foreach (($sale->errors->deepAll()) as $error) {
            $errMsg .= ("- " . $error->message . "<br/>");
        }
        $result['errMsg'] = $errMsg;
    }

    return $result;

  }
}
