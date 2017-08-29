<?php

namespace spec\Webgriffe\LibTriveneto\Signature;

use PhpSpec\ObjectBehavior;
use Webgriffe\LibTriveneto\Signature\Signable;

class Sha1SignatureCalculatorSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Webgriffe\LibTriveneto\Signature\Sha1SignatureCalculator');
    }

    public function it_is_signable()
    {
        $this->shouldHaveType('Webgriffe\LibTriveneto\Signature\Signer');
    }

    public function it_should_compute_signature_of_signable_object(Signable $signable)
    {
        $signable->getSignatureData()->willReturn('abc');
        $signable->setSignature('a9993e364706816aba3e25717850c26c9cd0d89d')->shouldBeCalled();
        $this->sign($signable);
    }
}
