<?php

namespace Webgriffe\LibTriveneto;

use Psr\Log\LoggerInterface;
use Webgriffe\LibTriveneto\Lists\Actions;
use Webgriffe\LibTriveneto\Lists\Currencies;
use Webgriffe\LibTriveneto\Lists\Languages;

class Client
{
    /**
     * @var LoggerInterface
     */
    private $logger = null;

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

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function init($userId, $password, $initUrl, $action)
    {
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

        $this->userId = $userId;
        $this->password = $password;
        $this->initUrl = $initUrl;
        $this->action = $action;
    }

    public function paymentInit($transactionId, $amount, $currencyCode, $languageId, $successUrl, $errorUrl)
    {
        if (!$this->wasInitCalled()) {
            throw new \Exception('Init was not called');
        }

        if (!$transactionId) {
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
    }

    public function paymentVerify()
    {
        if (!$this->wasInitCalled()) {
            throw new \Exception('Init was not called');
        }
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
}
