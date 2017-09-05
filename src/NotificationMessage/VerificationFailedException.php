<?php
/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 05/09/17
 * Time: 16.23
 */

namespace Webgriffe\LibTriveneto\NotificationMessage;

class VerificationFailedException extends \Exception
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

    /**
     * VerificationFailedException constructor.
     *
     * @param string $paymentId
     * @param string $errorCode
     * @param string $errorDescription
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($paymentId, $errorCode, $errorDescription, $code = 0, \Exception $previous = null)
    {
        parent::__construct($this->buildExceptionMessage($errorCode, $errorDescription), $code, $previous);

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

    /**
     * @param string $errorCode
     * @param string $errorDescription
     * @return string
     */
    private function buildExceptionMessage($errorCode, $errorDescription)
    {
        return "{$errorCode}: {$errorDescription}";
    }
}
