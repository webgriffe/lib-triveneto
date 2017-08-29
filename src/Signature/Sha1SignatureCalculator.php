<?php

namespace Webgriffe\LibTriveneto\Signature;

class Sha1SignatureCalculator implements Signer
{
    public function sign(Signable $signable)
    {
        $signable->setSignature(sha1($signable->getSignatureData()));
    }
}
