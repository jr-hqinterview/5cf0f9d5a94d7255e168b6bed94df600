<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment_model extends CI_Model{

    public function __construct()
    {
               parent::__construct();
               $this->load->database();
    }

    //identify credit card type and verify card number
    public function cc_identify($ccNum){
      if($this->cc_verify($ccNum)){
        if (preg_match("/^3[47][0-9]{13}$/", $ccNum)){
            return 'amex';
        } elseif (preg_match("/^30[0-5][0-9]{11}|36[0-9]{12}|54[0-9]{14}$/",$ccNum)){
          return "diners";
        } elseif (preg_match("/^6011[0-9]{12}|622[1-9][0-9]{12}|64[4-9][0-9]{13}|65[0-9]{14}$/", $ccNum)) {
            return 'discover';
        } elseif (preg_match("/^35[2-8][0-9]{13}$/", $ccNum)) {
            return 'jcb';
        } elseif (preg_match("/^5[1-5][0-9]{14}$/", $ccNum)) {
            return 'master';
        } elseif (preg_match("/^4[0-9]{15}?$/", $ccNum)) {
            return 'visa';
        } else {
          return "400";
        }
      } else {
        return "400";
      }
    }

    //verify the credit card number based on the luhn algorithm
    private function cc_verify($ccNum){
      $checksum = '';
      foreach (str_split(strrev($ccNum)) as $i => $d){
          $checksum .= ($i %2 !== 0 ? $d * 2 : $d);
      }
      return (array_sum(str_split($checksum)) % 10 === 0);
    }


    /*
    rules based on the requirement
     -amex with usd only
     -amex, paypal only
     -currency in (usd aud eur), use paypal
     -others use braintree
    */
    public function assign_gateway($ccType,$currency){
      if($ccType == "amex"){
        if($currency != "usd"){
          return 400;
        }
        return "paypal";
      } else {
        $paypal = array('usd','aud','eur');
        if(in_array($currency,$paypal)){
          return "paypal";
        } else {
          return "braintree";
        }
      }
    }

    public function startTransaction($detail){

      $gw = $detail['gateway'];
      $this->load->library($gw);
      $cfgGateway = $this->config->item($gw);
      $accessToken = $this->$gw->getToken($cfgGateway);
      $ccType = $detail['ccType'];
      $postVal = $detail['postVal'];
      $payArr = array(
        'accessToken' => $accessToken,
        'ccType' => $ccType,
        'postVal' => $postVal,
        'cfgGateway' => $cfgGateway
      );

      $result = $this->$gw->directpay($payArr);

      if($result['status'] == "200"){
        $db = array(
              'id' => $result['detail']['id'],
              'sales_id' => $result['detail']['sales_id'],
              'state' => $result['detail']['state'],
              'create_time' => $result['detail']['create_time'],
              'update_time' => $result['detail']['update_time'],
              'currency' => $result['detail']['currency'],
              'amount' => $result['detail']['amount'],
              'gateway' => $result['detail']['gateway']
          );
        $this->db->insert('transaction',$db);
      }

      return $result;
    }

}
?>
