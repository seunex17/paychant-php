# Table of contents

* [Introduction](#introduction)
* [Installation](#installation)
    * [Via Composer](#via-composer)
* [Usage](#usage)
    * [Composer autoloader](#composer-autoloader)
    * [Create new order](#create-new-order)
    * [Get order](#get-order)
* [Contributing](#contributing)    

- - -
# Introduction
Paychant is a cryptocurrency payment gateway. Founded in 2019, our mission is to increase the adoption of cryptocurrency payment in Africa, providing solutions where cryptocurrencies are spent like cash, a platform that lets buyers use their favorite cryptocurrency to pay sellers (merchants).
We offer businesses an entire cryptocurrency ecosystem by providing full payment integration and instant payment settlements for merchants in either Nigerian Naira, Bitcoin, or Ethereum.

### Cryptocurrency Payment Gateway API for Merchant
The Paychant API is designed for businesses that want to accept cryptocurrencies as a means of payment on their platforms without extensive technical expertise and risks related to cryptocurrency exchange rate fluctuations. The API is, therefore, suitable for applications from basic projects, to enterprise-level integration.

Paychant payment gateway provides a process of accepting Bitcoin, Ethereum, and Tether while generating unique addresses for each created order, real-time exchange rates for the payer, and a dashboard system for merchants to manage payment transactions and payouts.

The implementation of our API for payment processing on websites is very straightforward. The API credentials for connectivity can be generated from the Paychant merchant dashboard. We have also provided a Sandbox environment, where the API integration can be tested using Bitcoin and Ethereum testnet tokens, this will help developers performs test transactions before going to live mode.

Website (https://paychant.com)

# Installation
## Via Composer
### Recommended
```
composer require seunex17/paychant-php
```


- - -

# Usage
## Composer autoloader
```php
<?php

use ZubDev\Paychant;

require './vendor/autoload.php';

$paychant = new Paychant('ENVIRONMENT', 'YOUR API KEY');
```

## Create new order
```php
<?php

use ZubDev\Paychant;

require './vendor/autoload.php';

$paychant = new Paychant('ENVIRONMENT', 'YOUR API KEY');

// Create new transaction
	$request = [
		'amount' => 100, // Product price
		'currency' => 'NGN', // Available current are (NGN, USD, GBP, EUR, AUD, CAD, JPY, CNY)
		'title' => 'Sample product name', // Title of the order
		'payer_info' => 'johndoe@example.com', // Payer information
		'description' => 'Sample order description', // Description your order
		'cancel_url' => 'https://example.com/cancel', // Page to redirect to when user cancel payment
		'success_url' => 'https://example.com/success', // Page to redirect to for payment verification
		'callback_url' => 'https://example.com/webhook', // Webhook page for instant notification of order status
		//'token' => '', // If you will to generate a custom token you can fill in this Max 50
	];

	// Send request to payment page
	$res = $paychant->createNewOrder($request);
```

## Get order
```php
<?php

use ZubDev\Paychant;

require './vendor/autoload.php';

$paychant = new Paychant('ENVIRONMENT', 'YOUR API KEY');
$data = $paychant->getOrder('55IA55MU');

echo '<pre>';
print_r($data);
echo '</pre>';
```
---

#Contributing
#### Contributing is highly welcome fix errors add new features
