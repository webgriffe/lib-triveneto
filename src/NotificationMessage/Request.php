<?php
/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 29/08/17
 * Time: 16.48
 */

namespace Webgriffe\LibTriveneto\NotificationMessage;

use Webgriffe\LibTriveneto\Signature\CheckableSignature;

class Request implements CheckableSignature
{
    private $id;

    private $password;

    private $action;

    private $paymentid;

    private $tranid;

    private $result;

    private $auth;

    private $postdate;

    private $trackid;

    private $udf1;

    public function initConfigurationData($id, $password, $action)
    {
        $this->id = $id;
        $this->password = $password;
        $this->action = $action;
    }

    public function populateFromRequestData(array $requestParams)
    {
        $this->paymentid    = $requestParams['paymentid'];
        $this->tranid       = $requestParams['tranid'];
        $this->result       = $requestParams['result'];
        $this->auth         = $requestParams['auth'];
        $this->postdate     = array_key_exists('postdate', $requestParams) ? $requestParams['postdate'] : null;
        $this->trackid      = $requestParams['trackid'];
        $this->udf1         = $requestParams['udf1'];
    }

    public function getSignatureData()
    {
        if (!$this->isAllDataSet()) {
            throw new \Exception('All values are required before checking signature');
        }

        $receivedSignatureData = substr($this->udf1, 0, strrpos($this->udf1, '|'));

        //The brutal way
        $amtCurrencyLangString = substr(
            $receivedSignatureData,
            strlen($this->id) + strlen($this->password) + strlen($this->action),
            -strlen($this->trackid)
        );

        return $this->id.
            $this->password.
            $this->action.
            $amtCurrencyLangString.
            $this->trackid;
    }

    public function getSignature()
    {
        return substr($this->udf1, strrpos($this->udf1, '|') + 1);
    }

    /**
     * @return bool
     */
    private function isAllDataSet()
    {
        return $this->id && $this->password && $this->action && $this->paymentid && $this->tranid && $this->result &&
            $this->auth && $this->trackid && $this->udf1;
    }
}
