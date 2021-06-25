<?php

	/**
	 * Copyright (C) ZubDev Digital Media - All Rights Reserved
	 *
	 * File: PaychantTest.php
	 * Author: Zubayr Ganiyu
	 *   Email: <seunexseun@gmail.com>
	 *   Website: https://zubdev.net
	 * Date: 25/06/2021
	 * Time: 08:52
	 */

	use PHPUnit\Framework\TestCase;
	use ZubDev\Paychant;


	class PaychantTest extends TestCase {

		/**
		 * @var $paychant
		 */
		protected $paychant;


		/**
		 * Setup testing environment
		 */
		public function setUp()
		: void
		{
			$env = 'sandbox';
			$apiKey = 'test';

			$this->paychant = new Paychant($env, $apiKey);
		}


		/**
		 *	Test error response in creating of order
		 */
		public function testCreateOrderForAccessDenied()
		{
			$request = [
				'amount' => 100
			];
			$data = $this->paychant->createNewOrder($request);

			$this->assertEquals('Access denied. Invalid token provided', $data);
		}

	}
