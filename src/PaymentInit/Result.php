<?php
/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 04/09/17
 * Time: 17.39
 */

namespace Webgriffe\LibTriveneto\PaymentInit;


class Result
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $paymentId;

    public function __construct($url, $paymentId)
    {
        $this->url = $url;
        $this->paymentId = $paymentId;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getPaymentId()
    {
        return $this->paymentId;
    }
}
