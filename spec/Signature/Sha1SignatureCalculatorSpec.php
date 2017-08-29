<?php

namespace spec\Webgriffe\LibTriveneto\Signature;

use PhpSpec\ObjectBehavior;
use Webgriffe\LibTriveneto\Signature\Signable;

class Sha1SignatureCalculatorSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith('signsecret');
        $this->shouldHaveType('Webgriffe\LibTriveneto\Signature\Sha1SignatureCalculator');
    }

    public function it_is_signable()
    {
        $this->beConstructedWith('signsecret');
        $this->shouldHaveType('Webgriffe\LibTriveneto\Signature\Signer');
    }

    public function it_should_compute_signature_of_signable_object(Signable $signable)
    {
        $this->beConstructedWith('signsecret');
        $signable->getSignatureData()->willReturn('abc');
        $signable->setSignature('b3032ab179c1e9af5f05bca2e59cb434fee73afa')->shouldBeCalled();
        $this->sign($signable);
    }
}
