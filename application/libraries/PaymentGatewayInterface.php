<?php
defined('BASEPATH') OR exit('No direct script access allowed');

interface PaymentGatewayInterface{
  public function getToken();
  public function directpay();
}
