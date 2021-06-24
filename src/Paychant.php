<?php
	/**
	 * Copyright (C) ZubDev Digital Media - All Rights Reserved
	 *
	 * File: Paychant.php
	 * Author: Zubayr Ganiyu
	 *   Email: <seunexseun@gmail.com>
	 *   Website: https://zubdev.net
	 * Date: 24/06/2021
	 * Time: 20:12
	 */

	namespace Paychant;

	class Paychant {

		/**
		 * Access the Merchant API key
		 *
		 * @var
		 */
		protected $apiKey;


		/**
		 * Environment can be either Sandbox or Live
		 *
		 * @var
		 */
		protected $env;


		/**
		 * Paychant API endpoint
		 *
		 * @var
		 */
		protected $baseUrl;


		/**
		 * Paychant constructor.
		 *
		 * @param $env
		 * @param $apiKey
		 */
		public function __construct($env, $apiKey)
		{
			$this->apiKey = $apiKey;
			$this->env = $env;
		}


		/**
		 * Paychant Environment
		 *
		 * This environment can either be a Sandbox or Live
		 *
		 * @return string
		 */
		protected  function environment()
		{
			if ($this->env === 'live')
			{
				return 'https://api-live.paychant.com/v1/order';
			}

			return 'https://api-sandbox.paychant.com/v1/order';
		}


		/**
		 * Create an order
		 *
		 * @param   array  $request
		 *
		 * @return string
		 */
		public function createNewOrder(array $request)
		{
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => $this->environment(),
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => json_encode($request),
				CURLOPT_HTTPHEADER => array(
					"Authorization: Token $this->apiKey",
					'Content-Type: application/json'
				),
			));

			$response = curl_exec($curl);

			curl_close($curl);

			try
			{
				$data = json_decode($response);

				if ($data->status === 'success')
				{
					//* Redirect to payment page
					header("Location: ".$data->order->payment_url);
					exit();
				}

				return $data->message;
			}
			catch (\Exception $e)
			{
				return $e->getMessage();
			}
		}
	}
 
