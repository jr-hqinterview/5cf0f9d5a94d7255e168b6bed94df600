# PHP-Round1 for Hotelquickly interview

I competed the task with PHP framework - Codeigniter.

## Installation

1. Clone it from github
2. setup the apache directory point to public. or http://localhost/public
3. No configuration require.
4. Database connection have been preset. I used AWS RDS.

## How would you handle security for saving credit cards?

First of all, the site will be running in the secure enviroment(HTTPS) for the client

Each user should have their own account for making a payment and each account will have the unique identified code.

Credit card number, expiration date, card holder name and CVV is required for transaction, for the saving. CVV will not be consider to store because it is the authentication data and prevent system failure to make transaction automatically.

Before save into the database, three of the value will be combine into an json value and then encrypt the json with specific algorithm and self encryption key.

The encrypted value will not use basic encryption method, such as md5, sha512. Those method is easy to decrypt by some programs and self system can not decrypt the value to make the transaction.

The encrypted json value will store in the delicated table. The table just have two field, name and value. The name is the user unique identified code and the value is the encrypted json.

## File short description

- application/config/payment.php
  Payment configuration, including gateway self config, currency and gateway which accpet in the system.

- application/controllers/Payment.php
  The main controller for this assignment. Handling the payment form, transaction and the result.

- application/controllers/Test.php
  This controller provide the basic unit test page, transaction record query, credit card sample and the bonus question answer.

- application/core/MY_Controller.php
  It's extend from the CI original controller. enhance the load view method.

- application/libraries/PaymentGatewayInterface.php
  Abstract class for the payment gateway library.

- application/libraries/Paypal.php
  Handling the transaction with the Paypal Rest API.
  implement from the PaymentGatewayInterface

- application/libraries/Paypal.php  
  Handling the transaction with the Braintree PHP Library.
  implement from the PaymentGatewayInterface

- application/models/Payment_model.php
  Providing the credit card identify function.
  Based on the assignment rules to assign which payment gateway function.

- application/third_party/braintree/*
  Braintree PHP Library

- application/views/templates/*
  The header and footer for the view.

- application/views/payment/*
  View files for the Payment Controller

- application/views/*
  View files for the Test Controller

- public/asset/*
  css, image and javascript files.
