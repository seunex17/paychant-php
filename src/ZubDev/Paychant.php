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

	namespace ZubDev;

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
		 * @param         $param
		 * @param   null  $arg
		 *
		 * @return string
		 */
		protected function environment($param, $arg = null)
		: string {
			if ($this->env === 'live')
			{
				return "https://api-live.paychant.com/v1/$param/$arg";
			}

			return "https://api-sandbox.paychant.com/v1/$param/$arg";
		}


		/**
		 * Create an order
		 *
		 * @param   array  $request
		 *
		 * @return string
		 */
		public function createNewOrder(array $request)
		: string {
			$curl = curl_init();

			curl_setopt_array($curl, [
				CURLOPT_URL => $this->environment('order'),
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => json_encode($request),
				CURLOPT_HTTPHEADER => [
					"Authorization: Token $this->apiKey",
					'Content-Type: application/json',
				],
			]);

			$response = curl_exec($curl);

			curl_close($curl);

			try
			{
				$data = json_decode($response);

				if ($data->status === 'success')
				{
					//* Redirect to payment page
					header("Location: " . $data->order->payment_url);
					exit();
				}

				// Throw and error if error occur
				return $data->message;
			}
			catch (\Exception $e)
			{
				return $e->getMessage();
			}
		}


		/**
		 * Get single order by order id
		 *
		 * @param   string  $orderID
		 *
		 * @return array|string
		 */
		public function getOrder(string $orderID)
		{
			$curl = curl_init();

			curl_setopt_array($curl, [
				CURLOPT_URL => $this->environment('order', $orderID),
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_HTTPHEADER => [
					"Authorization: Token $this->apiKey",
					'Content-Type: application/json',
				],
			]);

			$response = curl_exec($curl);

			curl_close($curl);

			try
			{
				return (array) json_decode($response);
			}
			catch (\Exception $e)
			{
				return $e->getMessage();
			}
		}
	}
 
