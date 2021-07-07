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

	use GuzzleHttp\Client;
	use GuzzleHttp\Exception\GuzzleException;

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
		 * declare guzzle client
		 *
		 * @var
		 */
		protected $client;


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

			$this->client = new Client([
				'base_url' => 'https://api-sandbox.paychant.com/v1',
				'headers' => [
					"Authorization" => "Token $this->apiKey",
				],
			]);
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
		 * @return string|array
		 */
		public function createNewOrder(array $request)
		{
			try
			{
				// Send a post request to paychant endpoint
				$response = $this->client->post($this->environment('order'), [
					'json' => $request,
				]);

				$data = json_decode($response->getBody());

				// Redirect to payment page
				header("Location: " . $data->order->payment_url);
				exit();
			}
			catch (GuzzleException $exception)
			{
				$response = $exception->getResponse()
					->getBody()
					->getContents();

				return json_decode($response, JSON_PRETTY_PRINT);
			}
		}


		/**
		 * Get single order by order id
		 *
		 * @param   string  $orderID
		 *
		 * @return array
		 */
		public function getOrder(string $orderID)
		: array {
			try
			{
				// Send a get request to payment api endpoint
				$response = $this->client->get($this->environment('order', $orderID));

				return json_decode($response->getBody(), JSON_PRETTY_PRINT);
			}
			catch (GuzzleException $exception)
			{
				$response = $exception->getResponse()
					->getBody()
					->getContents();

				return json_decode($response, JSON_PRETTY_PRINT);
			}
		}


		/**
		 * List all orders
		 *
		 * This method retrieve all transaction carried out
		 *
		 * @return mixed
		 */
		public function listOrders()
		{
			try
			{
				$response = $this->client->get($this->environment('orders'));

				return json_decode($response->getBody(), JSON_PRETTY_PRINT);
			}
			catch (GuzzleException $exception)
			{
				$response = $exception->getResponse()
					->getBody()
					->getContents();

				return json_decode($response, JSON_PRETTY_PRINT);
			}
		}
	}
 
