<?php
defined('BASEPATH') OR exit('No direct script access allowed');

//Currency accept in the system.
//Currency (USD, EUR, THB, HKD, SGD, AUD)
$config['payment']['currecy'] = array(
                                  'usd'=>'US Dollar',
                                  'eur'=>'Euro',
                                  'thb'=>'Thai Baht',
                                  'hkd'=>'Hong Kong Dollar',
                                  'sgd'=>'Singapore Dollar',
                                  'aud'=>'Australian Dollar'
                                );

//payment gateway accept
$config['payment']['gateway'] = array('paypal','braintree');

//paypal setting
$config['paypal']['config'] = array('mode'=>'sandbox');
$config['paypal']['client_id'] = "AcblkoHpd_Nzuepx6a9kzpvS1Aog1XhgYSV4Z272TGi9Z4OsUnRi2zRllvGU6ho18Pba05FxkmDNq_42";
$config['paypal']['secret'] = "EBAb69Vik4sfzG8gHQqtxbAdBqg4vsJaSDAGZqbjKV7gLgfWkJrZv3w-dMGoMaJhy51Gf-KUf-39YPZq";
$config['paypal']['endpoint'] = "https://api.sandbox.paypal.com";
$config['paypal']['account'] = "jr.hqinterview-facilitator@gmail.com";

//braintree setting
$config['braintree']['merchantID'] = '4b43z4wjr5wtb78t';
$config['braintree']['publicKey'] = 'c23bwvv55q497dkm';
$config['braintree']['privateKey'] = '727fbab42cd04615c9fb8700bc3598e2';
$config['braintree']['enviroment'] = 'sandbox';
?>
