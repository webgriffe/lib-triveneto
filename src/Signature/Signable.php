<?php

namespace Webgriffe\LibTriveneto\Signature;

interface Signable
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
