<?php

namespace spec\Webgriffe\LibTriveneto\PaymentInit;

use PhpSpec\ObjectBehavior;

class RequestSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Webgriffe\LibTriveneto\PaymentInit\Request');
    }

    public function it_is_signable()
    {
        $this->shouldHaveType('Webgriffe\LibTriveneto\Signature\Signable');
    }

    public function it_must_be_filled_before_being_signed()
    {
        $this->setId('1');
        $this->setPassword('pwd');
        //$this->setAction(1);
        $this->setAmt(100);
        $this->setCurrencycode(978);
        $this->setLangid('ITA');
        $this->setNotifyURL('http://notify.com');
        $this->setErrorUrl('http://error.com');
        $this->setTrackid('100001');

        $this->shouldThrow(new \Exception("All values are required before signing request"))->duringGetSignatureData();
    }

    public function it_must_be_filled_before_being_signed_2()
    {
        $this->setId('1');
        $this->setPassword('pwd');
        $this->setAction(1);
        $this->setAmt(100);
        $this->setCurrencycode(978);
        //$this->setLangid('ITA');
        $this->setNotifyURL('http://notify.com');
        $this->setErrorUrl('http://error.com');
        $this->setTrackid('100001');

        $this->shouldThrow(new \Exception("All values are required before signing request"))->duringGetSignatureData();
    }

    public function it_generates_a_signable_string()
    {
        $this->setId('1');
        $this->setPassword('pwd');
        $this->setAction(1);
        $this->setAmt(100);
        $this->setCurrencycode(978);
        $this->setLangid('ITA');
        $this->setNotifyURL('http://notify.com');
        $this->setErrorUrl('http://error.com');
        $this->setTrackid('100001');

        $this->getSignatureData()->shouldBe('1pwd1100.00978ITA100001');
    }

    public function it_must_be_filled_before_generating_the_query_string()
    {
        $this->setId('1');
        $this->setPassword('pwd');
        $this->setAction(1);
        $this->setAmt(100);
        $this->setCurrencycode(978);
        //$this->setLangid('ITA');
        $this->setNotifyURL('http://notify.com');
        $this->setErrorUrl('http://error.com');
        $this->setTrackid('100001');

        $this->shouldThrow(new \Exception("All values are required before generating query string"))->duringGenerateQueryString();
    }

    public function it_must_be_signed_before_generating_the_query_string()
    {
        $this->setId('1');
        $this->setPassword('pwd');
        $this->setAction(1);
        $this->setAmt(100);
        $this->setCurrencycode(978);
        $this->setLangid('ITA');
        $this->setNotifyURL('http://notify.com');
        $this->setErrorUrl('http://error.com');
        $this->setTrackid('100001');

        $this->shouldThrow(new \Exception("Signature must be calculated before generating query string"))->duringGenerateQueryString();
    }

    public function it_can_generate_a_query_string()
    {
        $this->setId('1');
        $this->setPassword('pwd');
        $this->setAction(1);
        $this->setAmt(100);
        $this->setCurrencycode(978);
        $this->setLangid('ITA');
        $this->setNotifyURL('http://notify.com');
        $this->setErrorUrl('http://error.com');
        $this->setTrackid('100001');

        $this->setSignature('signature');

        $this->generateQueryString()->shouldBe(
            'id=1&password=pwd&action=1&amt=100.00&currencycode=978&langid=ITA&responseURL=http%3A%2F%2Fnotify.com&'.
            'errorURL=http%3A%2F%2Ferror.com&trackid=100001&udf1=1pwd1100.00978ITA100001_signature'
        );
    }

    public function it_resets_the_signature_when_changing_some_data()
    {
        $this->setId('1');
        $this->setPassword('pwd');
        $this->setAction(1);
        $this->setAmt(100);
        $this->setCurrencycode(978);
        $this->setLangid('ITA');
        $this->setNotifyURL('http://notify.com');
        $this->setErrorUrl('http://error.com');
        $this->setTrackid('100001');

        $this->setSignature('signature');

        $this->setAmt(200);

        $this->shouldThrow(new \Exception("Signature must be calculated before generating query string"))->duringGenerateQueryString();
    }
}
