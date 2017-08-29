<?php

namespace Webgriffe\LibTriveneto\Signature;

interface Signable extends ComputableSignature
{
    /**
     * @param $signature
     * @return $this
     */
    public function setSignature($signature);
}
