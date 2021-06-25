<?php
	/**
	 * Copyright (C) ZubDev Digital Media - All Rights Reserved
	 *
	 * File: create_order.php
	 * Author: Zubayr Ganiyu
	 *   Email: <seunexseun@gmail.com>
	 *   Website: https://zubdev.net
	 * Date: 24/06/2021
	 * Time: 20:21
	 */

	use ZubDev\Paychant;

	require '../vendor/autoload.php';

	$env = 'sandbox'; // live or sandbox
	$apiKey = 'YOUR API KEY'; // YOUR API KEY

	$paychant = new Paychant($env, $apiKey);

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

	echo '<pre>';
	print_r($res);
	echo '</pre>';
 
