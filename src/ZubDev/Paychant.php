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


		/**
		 * Get real time currency exchange rates
		 *
		 * @return mixed
		 */
		public function getExchangeRates()
		{
			try
			{
				$response = $this->client->get($this->environment('rates'));

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
		 * Paychant webhook
		 *
		 * @param   string  $secret
		 *
		 * @return mixed|void
		 */
		public function webhook(string $secret)
		{
			// Only a post method and headers that contain HTTP_PAYCHANT_SIGNATURE will be allowed
			if ((strtoupper($_SERVER['REQUEST_METHOD']) != 'POST' ) || !array_key_exists('HTTP_PAYCHANT_SIGNATURE', $_SERVER) ) {
				exit();
			}

			// Retrieve the request's body
			$input = @file_get_contents("php://input");

			// Remove escape slashes
			$inputClean = stripslashes($input);

			// SET the SECRET KEY
			define('PAYCHANT_WEBHOOK_SECRET_KEY', $secret);

			// Validate event
			if($_SERVER['HTTP_PAYCHANT_SIGNATURE'] !== hash_hmac('sha512', $inputClean, PAYCHANT_WEBHOOK_SECRET_KEY)){
				exit();
			}

			// Return status code 200 quickly
			http_response_code(200);

			// Do something with the event
			return json_decode($input);
		}
	}
 
