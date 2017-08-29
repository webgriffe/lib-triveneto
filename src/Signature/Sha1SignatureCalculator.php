<?php

namespace Webgriffe\LibTriveneto\Signature;

class Sha1SignatureCalculator extends SignatureCalculator
{
    /**
     * @param ComputableSignature $signable
     * @return string
     */
    protected function computeSignature(ComputableSignature $signable)
    {
        return sha1($signable->getSignatureData() . $this->signSecret);
    }
}
