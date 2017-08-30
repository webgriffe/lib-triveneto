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
    private $paymentId;

    private $ipgTransactionId;

    private $result;

    private $suthCode;

    private $paymentDate;

    private $transactionId;

    private $responseCode;

    private $cardType;

    private $paymentMethod;

    private $liability;

    private $cardCountry;

    private $ipCountry;

    public function __construct(
        $paymentId,
        $ipgTransactionId,
        $result,
        $suthCode,
        $paymentDate,
        $transactionId,
        $responseCode,
        $cardType,
        $paymentMethod,
        $liability,
        $cardCountry,
        $ipCountry
    ) {
        $this->paymentId = $paymentId;
        $this->ipgTransactionId = $ipgTransactionId;
        $this->result = $result;
        $this->suthCode = $suthCode;
        $this->paymentDate = $paymentDate;
        $this->transactionId = $transactionId;
        $this->responseCode = $responseCode;
        $this->cardType = $cardType;
        $this->paymentMethod = $paymentMethod;
        $this->liability = $liability;
        $this->cardCountry = $cardCountry;
        $this->ipCountry = $ipCountry;
    }

    public function getIsSuccess()
    {
        return strcasecmp($this->result, 'APPROVED') === 0 || strcasecmp($this->result, 'CAPTURED') === 0;
    }

    public function getIsPending()
    {
        return strcasecmp($this->result, 'PENDING') === 0;
    }

    /**
     * @return mixed
     */
    public function getPaymentId()
    {
        return $this->paymentId;
    }

    /**
     * @return mixed
     */
    public function getIpgTransactionId()
    {
        return $this->ipgTransactionId;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @return mixed
     */
    public function getSuthCode()
    {
        return $this->suthCode;
    }

    /**
     * @return mixed
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * @return mixed
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @return mixed
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * @return mixed
     */
    public function getCardType()
    {
        return $this->cardType;
    }

    /**
     * @return mixed
     */
    public function getPaymentMethod()
    {
        return $this->paymentMethod;
    }

    /**
     * @return mixed
     */
    public function getLiability()
    {
        return $this->liability;
    }

    /**
     * @return mixed
     */
    public function getCardCountry()
    {
        return $this->cardCountry;
    }

    /**
     * @return mixed
     */
    public function getIpCountry()
    {
        return $this->ipCountry;
    }
}