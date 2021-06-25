<?php
	/**
	 * Copyright (C) ZubDev Digital Media - All Rights Reserved
	 *
	 * File: get_order.php
	 * Author: Zubayr Ganiyu
	 *   Email: <seunexseun@gmail.com>
	 *   Website: https://zubdev.net
	 * Date: 25/06/2021
	 * Time: 16:56
	 */

	use ZubDev\Paychant;

	require '../vendor/autoload.php';

	$env = 'sandbox'; // live or sandbox
	$apiKey = 'YOUR API KEY'; // YOUR API KEY

	$paychant = new Paychant($env, $apiKey);

	$data = $paychant->getOrder('55IA55MU');

	echo '<pre>';
	print_r($data);
	echo '</pre>';
 
