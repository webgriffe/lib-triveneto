<?php
/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 28/08/17
 * Time: 15.48
 */

namespace Webgriffe\LibTriveneto\PaymentInit;

use Webgriffe\LibTriveneto\Signature\Signable;

class Request implements Signable
{
    private $id;
    
    private $password;
    
    private $action;
    
    private $amt;
    
    private $currencycode;
    
    private $langid;
    
    private $notifyUrl;
    
    private $errorUrl;
    
    private $trackid;
    
    private $udf1;

    /**
     * @param mixed $id
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;
        $this->udf1 = null;
        return $this;
    }

    /**
     * @param mixed $password
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;
        $this->udf1 = null;
        return $this;
    }

    /**
     * @param mixed $action
     * @return $this
     */
    public function setAction($action)
    {
        $this->action = $action;
        $this->udf1 = null;
        return $this;
    }

    /**
     * @param mixed $amt
     * @return $this
     */
    public function setAmt($amt)
    {
        $this->amt = number_format($amt, 2, '.', '');
        $this->udf1 = null;
        return $this;
    }

    /**
     * @param mixed $currencycode
     * @return $this
     */
    public function setCurrencycode($currencycode)
    {
        $this->currencycode = $currencycode;
        $this->udf1 = null;
        return $this;
    }

    /**
     * @param mixed $langid
     * @return $this
     */
    public function setLangid($langid)
    {
        $this->langid = $langid;
        $this->udf1 = null;
        return $this;
    }

    /**
     * @param mixed $notifyUrl
     * @return $this
     */
    public function setNotifyUrl($notifyUrl)
    {
        $this->notifyUrl = $notifyUrl;
        $this->udf1 = null;
        return $this;
    }

    /**
     * @param mixed $errorUrl
     * @return $this
     */
    public function setErrorUrl($errorUrl)
    {
        $this->errorUrl = $errorUrl;
        $this->udf1 = null;
        return $this;
    }

    /**
     * @param mixed $trackid
     * @return $this
     */
    public function setTrackid($trackid)
    {
        $this->trackid = $trackid;
        $this->udf1 = null;
        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function getSignatureData()
    {
        if (!$this->isAllDataSet()) {
            throw new \Exception('All values are required before signing request');
        }

        return $this->id.
            $this->password.
            $this->action.
            $this->amt.
            $this->currencycode.
            $this->langid.
            //$this->notifyURL.   These are too long to add them to the udf1 field
            //$this->errorUrl.
            $this->trackid;
    }

    /**
     * @param $signature
     * @return $this
     */
    public function setSignature($signature)
    {
        $this->udf1 = $this->getSignatureData().'_'.$signature;
        return $this;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function generateQueryString()
    {
        if (!$this->isAllDataSet()) {
            throw new \Exception("All values are required before generating query string");
        } elseif (!$this->udf1) {
            throw new \Exception("Signature must be calculated before generating query string");
        }

        $params = array(
            'id'            => $this->id,
            'password'      => $this->password,
            'action'        => $this->action,
            'amt'           => $this->amt,
            'currencycode'  => $this->currencycode,
            'langid'        => $this->langid,
            'responseURL'   => $this->notifyUrl,
            'errorURL'      => $this->errorUrl,
            'trackid'       => $this->trackid,
            'udf1'          => $this->udf1,
        );

        return http_build_query($params);
    }

    /**
     * @return bool
     */
    private function isAllDataSet()
    {
        return $this->id && $this->password && $this->action && $this->amt && $this->currencycode && $this->langid &&
            $this->notifyUrl && $this->errorUrl && $this->trackid;
    }
}
