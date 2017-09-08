<?php

namespace spec\Webgriffe\LibTriveneto\NotificationMessage;

use PhpSpec\ObjectBehavior;

class RequestSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Webgriffe\LibTriveneto\NotificationMessage\Request');
    }

    public function it_is_signable()
    {
        $this->shouldHaveType('Webgriffe\LibTriveneto\Signature\CheckableSignature');
    }

    public function it_must_be_initialized_before_signature_can_be_checked()
    {
        $this->populateFromRequestData(
            [
                'paymentid' => '123',
                'tranid'    => '456',
                'result'    => 'APPROVED',
                'auth'      => '123456',
                //'postdate'  => '0829',
                'trackid'   => '100001',
                'udf1'      => '1pwd1100.00978ITA100001_bd7e588c91bf17480559382f56d00079fdfa50a1',
            ]
        );

        $this->shouldThrow(new \Exception("All values are required before checking signature"))->duringGetSignatureData();
    }

    public function it_must_be_filled_before_signature_can_be_checked()
    {
        $this->initConfigurationData('1', 'pwd', 1);

        $this->shouldThrow(new \Exception("All values are required before checking signature"))->duringGetSignatureData();
    }

    public function it_must_contain_all_values_before_signature_can_be_checked()
    {
        $this->initConfigurationData('1', '', 1);
        $this->populateFromRequestData(
            [
                'paymentid' => '123',
                'tranid'    => '456',
                'result'    => 'APPROVED',
                'auth'      => '123456',
                //'postdate'  => '0829',
                'trackid'   => '100001',
                'udf1'      => '1pwd1100.00978ITA100001_bd7e588c91bf17480559382f56d00079fdfa50a1',
            ]
        );

        $this->shouldThrow(new \Exception("All values are required before checking signature"))->duringGetSignatureData();
    }

    public function it_must_contain_all_values_before_signature_can_be_checked2()
    {
        $this->initConfigurationData('1', 'pwd', 1);
        $this->populateFromRequestData(
            [
                'paymentid' => '123',
                'tranid'    => '',
                'result'    => 'APPROVED',
                'auth'      => '123456',
                //'postdate'  => '0829',
                'trackid'   => '100001',
                'udf1'      => '1pwd1100.00978ITA100001_bd7e588c91bf17480559382f56d00079fdfa50a1',
            ]
        );

        $this->shouldThrow(new \Exception("All values are required before checking signature"))->duringGetSignatureData();
    }

    public function it_can_generate_signature_data()
    {
        $this->initConfigurationData('1', 'pwd', 1);
        $this->populateFromRequestData(
            [
                'paymentid' => '123',
                'tranid'    => '456',
                'result'    => 'APPROVED',
                'auth'      => '123456',
                //'postdate'  => '0829',
                'trackid'   => '100001',
                'udf1'      => '1pwd1100.00978ITA100001_bd7e588c91bf17480559382f56d00079fdfa50a1',
            ]
        );

        $this->getSignatureData()->shouldBe('1pwd1100.00978ITA100001');
    }
}
