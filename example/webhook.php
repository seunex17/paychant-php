<?php
	/**
	 * Copyright (C) ZubDev Digital Media - All Rights Reserved
	 *
	 * File: webhook.php
	 * Author: Zubayr Ganiyu
	 *   Email: <seunexseun@gmail.com>
	 *   Website: https://zubdev.net
	 * Date: 10/09/2021
	 * Time: 21:08
	 */

	use ZubDev\Paychant;

	$env = 'sandbox'; // live or sandbox
	$apiKey = 'YOUR API KEY'; // YOUR API KEY
	$webhookKey = 'YOUR WEBHOOK SECRET KEY';

	$paychant = new Paychant($env, $apiKey);

	/*
	 * Webhook will always return an array
	 */

	var_dump($paychant->webhook($webhookKey)); // This return an array
 
