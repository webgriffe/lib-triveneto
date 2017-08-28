<?php

namespace Webgriffe\LibTriveneto;

interface SignableInterface
{
    /**
     * @return string
     */
    public function getSignatureData();

    /**
     * @param $signature
     * @return $this
     */
    public function setSignature($signature);
}
