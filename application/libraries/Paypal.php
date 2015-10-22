<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once "PaymentGatewayInterface.php";
class Paypal implements PaymentGatewayInterface{
  private $config;

  public function __construct(){
    $ci =& get_instance();
    $this->config = $ci->config->item('payment');
  }

  public function getToken($var = array()){
    $url = $var['endpoint']."/v1/oauth2/token";

    $postVar = array(
      'grant_type' => 'client_credentials'
    );

    //curl connection
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Accept'=>'application/json','Accept-Language'=>'en_US'));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_USERPWD, $var['client_id'].":".$var['secret']);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($postVar));

    $response = curl_exec($ch);

    if (curl_errno ( $ch )) {
        die('Errno' . curl_error ( $ch ));
    }
    curl_close($ch);

    $json = json_decode($response);
    return $json->access_token;

  }

  public function directpay($var = array()){
    $url = $var['cfgGateway']['endpoint'].'/v1/payments/payment';

    $ccType = $this->convertCardType($var['ccType']);
    $ccExpYY = $this->convertExpYY($var['postVal']['ccExpYY']);
    $fname = $this->convertHolder($var['postVal']['ccHolder'],'0');
    $lname = $this->convertHolder($var['postVal']['ccHolder'],'99');
    $payment = array(
            		'intent' => 'sale',
            		'payer' => array(
            			'payment_method' => 'credit_card',
            			'funding_instruments' => array ( array(
            					'credit_card' => array (
            						'number' => $var['postVal']['ccNum'],
            						'type'   => $ccType,
            						'expire_month' => $var['postVal']['ccExpMM'],
            						'expire_year' => $ccExpYY,
            						'cvv2' => $var['postVal']['ccCCV'],
            						'first_name' => $fname,
            						'last_name' => $lname
            						)
            					))
            			),
            		'transactions' => array (array(
            				'amount' => array(
            					'total' => $var['postVal']['amount'],
            					'currency' => strtoupper($var['postVal']['cur'])
            					),
            				'description' => 'Direct pay via Paypal'
            				))
            	);
    $json = json_encode($payment);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
          'Authorization: Bearer '.$var['accessToken'],
          'Accept: application/json',
          'Content-Type: application/json'
          ));

    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);

    $response = curl_exec($ch);
  	if (empty($response)) {
  	    die(curl_error($ch));
  	    curl_close($ch);
  	}

  	$response = json_decode($response, TRUE);
    $result = array();

    if(!isset($response['name'])){
      $result['status'] = "200";
      $result['detail']['id'] = $response['id'];
      $result['detail']['sales_id'] = $response['transactions'][0]['related_resources'][0]['sale']['id'];
      $result['detail']['state'] = $response['state'];
      $result['detail']['create_time'] = $response['create_time'];
      $result['detail']['update_time'] = $response['update_time'];
      $result['detail']['currency'] = $response['transactions'][0]['amount']['currency'];
      $result['detail']['amount'] = $response['transactions'][0]['amount']['total'];
      $result['detail']['gateway'] = "Paypal";
    } else {
      $result['status'] = $response['name'];
      $result['errMsg'] = $response['message']."<br/>".$response['information_link'];
    }

    return $result;
  }

  private function convertCardType($ccType){
    switch($ccType){
      case "visa":
        return "visa";
        break;
      case "master":
        return "mastercard";
        break;
      case "amex":
        return "amex";
        break;
      default:
        return "discover";
        break;
    }
  }

  private function convertExpYY($ccExpYY){
    return "20".$ccExpYY;
  }

  private function convertHolder($name,$return){
     $names = explode(" ",$name);
     if($return == 0){
       return $names[0];
     } elseif($return == 99){
       $last = sizeof($names);
       return $names[$last-1];
     }
  }

}
