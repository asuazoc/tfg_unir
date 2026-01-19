<?php
/*
Licensed to the Apache Software Foundation (ASF) under one
or more contributor license agreements.  See the NOTICE file
distributed with this work for additional information
regarding copyright ownership.  The ASF licenses this file
to you under the Apache License, Version 2.0 (the
"License"); you may not use this file except in compliance
with the License.  You may obtain a copy of the License at

http://www.apache.org/licenses/LICENSE-2.0

Unless required by applicable law or agreed to in writing,
software distributed under the License is distributed on an
"AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY
KIND, either express or implied.  See the License for the
specific language governing permissions and limitations
under the License.

File:		SermepaPaymentGateway.php (SERMEPA)
Function:	Create a valid form and hash for SERMEPA Gateway
 */

include 'apiRedsys.php';
define('DEBUG_TPV', false);
if (DEBUG_TPV) {
	error_reporting(E_ALL);
	ini_set('display_errors', 'On');
	ini_set('log_errors', 'On');
	ini_set('error_log', "errors.log");
}

class SermepaPaymentGatewayException extends Exception {
};

class SermepaPaymentGateway {
	const VERSION = "HMAC_SHA256_V1";

	private $redsysClient;
	private $url_tpvv;
	private $secret;
	private $code;
	private $name;
	private $terminal;
	private $currency;
	private $transactionType;
	private $urlMerchant;
	private $consumerLanguage;
	private $merchantUrlOK;
	private $merchantUrlKO;
	private $merchantData;

	function __construct($config) {
		$this->redsysClient = new RedsysAPI;
		if (empty($config)) {
			throw new SermepaPaymentGatewayException('Provide a valid config array');
		}
		$this->validateConfig($config);
		$this->config($config);
	}

	private function config($config) {

		//obligatory
		$this->url_tpvv = $config['url_tpvv'];
		$this->secret = $config['secret'];
		$this->redsysClient->setParameter("DS_MERCHANT_CONSUMERLANGUAGE", $config['consumerLanguage']);
		$this->redsysClient->setParameter("DS_MERCHANT_MERCHANTNAME", $config['name']);
		$this->redsysClient->setParameter("DS_MERCHANT_MERCHANTCODE", $config['code']);
		$this->redsysClient->setParameter("DS_MERCHANT_CURRENCY", $config['currency']);
		$this->redsysClient->setParameter("DS_MERCHANT_TRANSACTIONTYPE", $config['transactionType']);
		$this->redsysClient->setParameter("DS_MERCHANT_TERMINAL", $config['terminal']);
		$this->redsysClient->setParameter("DS_MERCHANT_MERCHANTURL", $config['urlMerchant']);
		$this->redsysClient->setParameter("DS_MERCHANT_URLOK", $config['merchantUrlOK']);
		$this->redsysClient->setParameter("DS_MERCHANT_URLKO", $config['merchantUrlKO']);
		$this->redsysClient->setParameter("DS_MERCHANT_MERCHANTDATA", $config['merchantData']);
	}

	private function validateConfig($config) {

		if (!isset($config['url_tpvv'])) {
			throw new SermepaPaymentGatewayException('TPV url is a mandatory param');
		}
		if (!isset($config['secret'])) {
			throw new SermepaPaymentGatewayException('Secret is a mandatory param');
		}
		if (!isset($config['code'])) {
			throw new SermepaPaymentGatewayException('Code is a mandatory param');
		}
		if (!isset($config['name'])) {
			throw new SermepaPaymentGatewayException('Name is a mandatory param');
		}
		if (!isset($config['terminal'])) {
			throw new SermepaPaymentGatewayException('Terminal is a mandatory param');
		}
		if (!isset($config['currency'])) {
			throw new SermepaPaymentGatewayException('Currency is a mandatory param');
		}
		if (!isset($config['transactionType'])) {
			throw new SermepaPaymentGatewayException('TransactionType is a mandatory param');
		}
		if (!isset($config['consumerLanguage'])) {
			throw new SermepaPaymentGatewayException('ConsumerLanguage is a mandatory param');
		}

	}

	private function numberNormalizer($price) {
		$integers = "";
		if ($price == "") {
			throw new SermepaPaymentGatewayException("Empty price");
		} else {
			$price = preg_replace('/[^0-9\.,]/', '', $price); //only allow numbers and "." or "," characters
			$price = str_replace(",", ".", $price);
			$pa = explode(".", $price); //split the decimal part
			if (sizeof($pa) == 1) {
				return $price . "00";
			} else if (sizeof($pa) == 2) {
				$integers = $pa[0];
				$decimals = $pa[1];
				if (strlen($decimals) > 2) {
					throw new SermepaPaymentGatewayException("Too much decimals (2 max.)");
				} else if (strlen($decimals) == 2) {
					return $integers . $decimals;
				} else if (strlen($decimals) == 1) {
					return $integers . $decimals . "0";
				} else if (strlen($decimals) == 0) {
					return $integers . "00";
				}

			} else {
				throw new SermepaPaymentGatewayException("Malformed number");
			}

		}
	}

	private function showDebugInfo() {
		$info = "";
		$info .= "<pre>";
		$info .= $this->redsysClient->arrayToJson();
		$info .= "</pre>";
		return $info;
	}

	public function getForm($amount, $order, $show_button = true, $form_name = 'tpv_sermepa') {

		$amount = $this->numberNormalizer($amount);
		$this->redsysClient->setParameter("DS_MERCHANT_AMOUNT", $amount);
		$this->redsysClient->setParameter("DS_MERCHANT_ORDER", strval($order));

		$form = '';
		if (DEBUG_TPV) {
			$form .= $this->showDebugInfo();
		}
		$params = $this->redsysClient->createMerchantParameters();
		$signature = $this->redsysClient->createMerchantSignature($this->secret);
		$form .= '<form name="' . $form_name . '" id="' . $form_name . '" action="' . $this->url_tpvv . '" method="post">';
		$form .= '<input type="hidden" name="Ds_SignatureVersion" value="' . self::VERSION . '"/>';
		$form .= '<input type="hidden" name="Ds_MerchantParameters" value="' . $params . '"/>';
		$form .= '<input type="hidden" name="Ds_Signature" value="' . $signature . '"/>';
		if ($show_button) {
			$form .= '<input type="submit" value="Comprar">';
		}
		$form .= '</form>';
		return $form;
	}

	public function getResponse($params) {
		return json_decode($this->redsysClient->decodeMerchantParameters($params),true);
	}

	public function isValidMessage($params, $remoteSignature) {
		$signature = $this->redsysClient->createMerchantSignatureNotif($this->secret, $params);
		return ($signature === $remoteSignature);
	}

	public function isValidResponse($response) {
		return ($response < 101);
	}
}
