<?php
/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 30/08/17
 * Time: 14.24
 */

namespace Webgriffe\LibTriveneto\NotificationMessage;

class NotificationResult
{
    /**
     * @var string
     */
    private $successUrl;

    /**
     * @var string
     */
    private $errorUrl;

    /**
     * @var string
     */
    private $paymentId;

    /**
     * @var string
     */
    private $ipgTransactionId;

    /**
     * @var string
     */
    private $result;

    /**
     * @var string
     */
    private $authCode;

    /**
     * @var string
     */
    private $paymentDate;

    /**
     * @var string
     */
    private $merchantTransactionId;

    /**
     * @var string
     */
    private $transactionId;

    /**
     * @var string
     */
    private $responseCode;

    /**
     * @var string
     */
    private $cardType;

    /**
     * @var string
     */
    private $paymentMethod;

    /**
     * @var string
     */
    private $liability;

    /**
     * @var string
     */
    private $cardCountry;

    /**
     * @var string
     */
    private $ipCountry;

    public function __construct(
        $successUrl,
        $errorUrl,
        $paymentId,
        $ipgTransactionId,
        $result,
        $authCode,
        $paymentDate,
        $merchantTransactionId,
        $transactionId,
        $responseCode,
        $cardType,
        $paymentMethod,
        $liability,
        $cardCountry,
        $ipCountry
    ) {
        $this->successUrl = $successUrl;
        $this->errorUrl = $errorUrl;

        $this->paymentId = $paymentId;
        $this->ipgTransactionId = $ipgTransactionId;
        $this->result = $result;
        $this->authCode = $authCode;
        $this->paymentDate = $paymentDate;
        $this->merchantTransactionId = $merchantTransactionId;
        $this->transactionId = $transactionId;
        $this->responseCode = $responseCode;
        $this->cardType = $cardType;
        $this->paymentMethod = $paymentMethod;
        $this->liability = $liability;
        $this->cardCountry = $cardCountry;
        $this->ipCountry = $ipCountry;
    }

    /**
     * @return bool
     */
    public function getIsSuccess()
    {
        return strcasecmp($this->result, 'APPROVED') === 0 || strcasecmp($this->result, 'CAPTURED') === 0;
    }

    /**
     * @return bool
     */
    public function getIsPending()
    {
        return strcasecmp($this->result, 'PENDING') === 0;
    }

    /**
     * @return string
     */
    public function generateResponse()
    {
        $url = $this->errorUrl;
        if ($this->getIsSuccess() || $this->getIsPending()) {
            $url = $this->successUrl;
        }

        return "REDIRECT={$url}";
    }

    /**
     * @return string
     */
    public function getPaymentId()
    {
        return $this->paymentId;
    }

    /**
     * @return string
     */
    public function getIpgTransactionId()
    {
        return $this->ipgTransactionId;
    }

    /**
     * @return string
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return string
     */
    public function getAuthCode()
    {
        return $this->authCode;
    }

    /**
     * @return string
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * @return string
     */
    public function getMerchantTransactionId()
    {
        return $this->merchantTransactionId;
    }

    /**
     * @return string
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @return string
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * @return string
     */
    public function getCardType()
    {
        return $this->cardType;
    }

    /**
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @return string
     */
    public function getLiability()
    {
        return $this->liability;
    }

    /**
     * @return string
     */
    public function getCardCountry()
    {
        return $this->cardCountry;
    }

    /**
     * @return string
     */
    public function getIpCountry()
    {
        return $this->ipCountry;
    }
}