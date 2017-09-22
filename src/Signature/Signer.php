<?php

namespace Webgriffe\LibTriveneto\Signature;

interface Signer
{
    public function sign(Signable $signable);
}
