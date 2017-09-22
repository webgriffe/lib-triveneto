<?php
/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 05/09/17
 * Time: 16.59
 */

namespace Webgriffe\LibTriveneto\NotificationMessage\Result;

class NotificationErrorResult implements NotificationResultInterface
{
    /**
     * @var string
     */
    private $paymentId;

    /**
     * @var string
     */
    private $errorCode;

    /**
     * @var string
     */
    private $errorDescription;

    public function __construct($paymentId, $errorCode, $errorDescription)
    {
        $this->paymentId = $paymentId;
        $this->errorCode = $errorCode;
        $this->errorDescription = $errorDescription;
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
    public function getErrorCode()
    {
        return $this->errorCode;
    }

    /**
     * @return string
     */
    public function getErrorDescription()
    {
        return $this->errorDescription;
    }
}
