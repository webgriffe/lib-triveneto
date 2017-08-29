<?php

namespace Webgriffe\LibTriveneto;

use Psr\Log\LoggerInterface;
use Webgriffe\LibTriveneto\Lists\Actions;
use Webgriffe\LibTriveneto\Lists\Currencies;
use Webgriffe\LibTriveneto\Lists\Languages;
use Webgriffe\LibTriveneto\PaymentInit\Request;
use Webgriffe\LibTriveneto\PaymentInit\RequestSender;
use Webgriffe\LibTriveneto\Signature\Sha1SignatureCalculator;
use Webgriffe\LibTriveneto\Signature\Signer;

class Client
{
    /**
     * @var LoggerInterface
     */
    private $logger = null;

    /**
     * @var RequestSender
     */
    private $sender = null;

    /**
     * @var string
     */
    private $userId = null;

    /**
     * @var string
     */
    private $password = null;

    /**
     * @var string
     */
    private $initUrl = null;

    /**
     * @var int
     */
    private $action = null;

    /**
     * @var string
     */
    private $signSecret;

    public function __construct(LoggerInterface $logger, RequestSender $sender)
    {
        $this->logger = $logger;
        $this->sender = $sender;
    }

    public function init($userId, $password, $initUrl, $action, $signSecret)
    {
        if (!extension_loaded('curl') || !function_exists('curl_init')) {
            throw new \Exception('This library needs PHP cURL to work');
        }

        if (!$userId) {
            throw new \InvalidArgumentException('Missing user id');
        }

        if (!$password) {
            throw new \InvalidArgumentException('Missing password');
        }

        if (!$initUrl) {
            throw new \InvalidArgumentException('Missing payment init URL');
        }

        if (!$action) {
            throw new \InvalidArgumentException('Missing payment action (accounting type)');
        } elseif (!$this->isValidPaymentAction($action)) {
            throw new \InvalidArgumentException('Invalid payment action specified: '.$action);
        }

        if (!$signSecret || strlen($signSecret) < 8) {
            throw new \InvalidArgumentException('Sign secret must be at least 8 chars long');
        }

        $this->userId = $userId;
        $this->password = $password;
        $this->initUrl = $initUrl;
        $this->action = $action;
        $this->signSecret = $signSecret;
    }

    /**
     * @param string $merchantTransactionId Identifier of the payment for the merchant. Usually this is the order id
     * @param float $amount Payment amount
     * @param string $currencyCode Code that identifies the payment currency. Currently only 978 (Euro) is supported
     * @param string $languageId Code of the payment page language
     * @param string $successUrl URL to redirect the customer to after a succesful payment
     * @param string $errorUrl URL to redirect the customer to after a failed payment
     *
     * @return string The URL to redirect the customer to in order to perform the payment
     *
     * @throws \Exception
     */
    public function paymentInit($merchantTransactionId, $amount, $currencyCode, $languageId, $successUrl, $errorUrl)
    {
        if (!$this->wasInitCalled()) {
            throw new \Exception('Init was not called');
        }

        if (!$merchantTransactionId) {
            throw new \InvalidArgumentException('No transaction id provided');
        }

        //Only accept positive numbers with at most 2 decimal places
        if (!$amount || !is_numeric($amount) || $amount <= 0 || round($amount, 2) != $amount) {
            throw new \InvalidArgumentException('Invalid amount');
        }

        if (!$currencyCode || !$this->isValidCurrencyCode($currencyCode)) {
            throw new \InvalidArgumentException('Invalid currency');
        }

        if (!$languageId || !$this->isValidLanguageId($languageId)) {
            throw new \InvalidArgumentException('Invalid language');
        }

        if (!$successUrl) {
            throw new \InvalidArgumentException('Missing success URL');
        }

        if (!$errorUrl) {
            throw new \InvalidArgumentException('Missing error URL');
        }

        $request = new Request();
        $request->setId($this->userId);
        $request->setPassword($this->password);
        $request->setAction($this->action);
        $request->setAmt($amount);
        $request->setCurrencycode($currencyCode);
        $request->setLangid($languageId);
        $request->setResponseURL($successUrl);
        $request->setErrorUrl($errorUrl);
        $request->setTrackid($merchantTransactionId);

        $this->getSigner()->sign($request);

        $queryString = $request->generateQueryString();

        $response = $this->sender->post($this->initUrl, $queryString);

        if (strpos($response, '!ERROR!') === 0) {
            $errorMessage = substr($response, 7);
            throw new \Exception($errorMessage);
        }

        $pos = strpos($response, ':http');
        $paymentId = substr($response, 0, $pos);
        $paymentUrl = substr($response, $pos + 1);

        return "{$paymentUrl}?PaymentID={$paymentId}";
    }

    public function paymentVerify(array $requestParams)
    {
        if (!$this->wasInitCalled()) {
            throw new \Exception('Init was not called');
        }

        array_change_key_case($requestParams, CASE_LOWER);

        if (array_key_exists('error', $requestParams)) {
            $errorCode = $requestParams['error'];
            $errorDesc = $requestParams['errortext'];

            throw new \Exception("{$errorCode}: {$errorDesc}");
        }

        $paymentid = $requestParams['paymentid'];
        $tranid = $requestParams['tranid'];
        $result = $requestParams['result'];
        $auth = $requestParams['auth'];
        $postdate = $requestParams['postdate'];
        $trackid = $requestParams['trackid'];
        $udf1 = $requestParams['udf1'];
    }

    private function wasInitCalled()
    {
        return !is_null($this->userId) && !is_null($this->password) && !is_null($this->initUrl) &&
            !is_null($this->action);
    }

    private function isValidPaymentAction($action)
    {
        $actionsList = new Actions();
        return in_array($action, $actionsList->getList());
    }

    private function isValidCurrencyCode($currencyCode)
    {
        $currencyList = new Currencies();
        return in_array($currencyCode, $currencyList->getList());
    }

    private function isValidLanguageId($languageId)
    {
        $languagesList = new Languages();
        return in_array($languageId, $languagesList->getList());
    }

    /**
     * @return Signer
     */
    private function getSigner()
    {
        return new Sha1SignatureCalculator($this->signSecret);
    }
}
