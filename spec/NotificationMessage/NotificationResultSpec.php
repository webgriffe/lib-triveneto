<?php
/**
 * Created by PhpStorm.
 * User: andrea
 * Date: 30/08/17
 * Time: 15.31
 */

namespace spec\Webgriffe\LibTriveneto\NotificationMessage;

use PhpSpec\ObjectBehavior;

class NotificationResultSpec extends ObjectBehavior
{
    public function it_must_store_and_return_values()
    {
        $this->beConstructedWithResult('APPROVED');

        $this->getPaymentId()->shouldBe('123');
        $this->getIpgTransactionId()->shouldBe('456');
        $this->getResult()->shouldBe('APPROVED');
        $this->getAuthCode()->shouldBe('123456');
        $this->getPaymentDate()->shouldBe('0829');
        $this->getTransactionId()->shouldBe('0987654321');
        $this->getResponseCode()->shouldBe('00');
        $this->getCardType()->shouldBe('VISA');
        $this->getPaymentMethod()->shouldBe('CC');
        $this->getLiability()->shouldBe('Y');
        $this->getCardCountry()->shouldBe('IT');
        $this->getIpCountry()->shouldBe('IT');
    }

    public function it_must_report_success_on_approved_transactions()
    {
        $this->beConstructedWithResult('APPROVED');
        $this->getIsSuccess()->shouldBe(true);
    }

    public function it_must_report_success_on_captured_transactions()
    {
        $this->beConstructedWithResult('CAPTURED');
        $this->getIsSuccess()->shouldBe(true);
    }

    public function it_must_not_report_success_on_not_approved_transactions()
    {
        $this->beConstructedWithResult('NOT APPROVED');
        $this->getIsSuccess()->shouldBe(false);
    }

    public function it_must_not_report_success_on_not_captured_transactions()
    {
        $this->beConstructedWithResult('NOT CAPTURED');
        $this->getIsSuccess()->shouldBe(false);
    }

    public function it_must_not_report_success_on_denied_transactions()
    {
        $this->beConstructedWithResult('DENIED BY RISK');
        $this->getIsSuccess()->shouldBe(false);
    }

    public function it_must_not_report_success_on_timeout_transactions()
    {
        $this->beConstructedWithResult('HOST TIMEOUT');
        $this->getIsSuccess()->shouldBe(false);
    }

    public function it_must_not_report_success_on_issuer_unavailable_transactions()
    {
        $this->beConstructedWithResult('ISSUER UNAVAILABLE');
        $this->getIsSuccess()->shouldBe(false);
    }

    public function it_must_not_report_success_on_pending_transactions()
    {
        $this->beConstructedWithResult('PENDING');
        $this->getIsSuccess()->shouldBe(false);
    }

    public function it_must_report_pending_on_pending_transactions()
    {
        $this->beConstructedWithResult('PENDING');
        $this->getIsPending()->shouldBe(true);
    }

    public function it_must_not_report_pending_on_approved_transactions()
    {
        $this->beConstructedWithResult('APPROVED');
        $this->getIsPending()->shouldBe(false);
    }

    public function it_must_not_report_pending_on_not_approved_transactions()
    {
        $this->beConstructedWithResult('NOT APPROVED');
        $this->getIsPending()->shouldBe(false);
    }

    public function it_must_not_report_pending_on_captured_transactions()
    {
        $this->beConstructedWithResult('CAPTURED');
        $this->getIsPending()->shouldBe(false);
    }

    public function it_must_not_report_pending_on_not_captured_transactions()
    {
        $this->beConstructedWithResult('NOT CAPTURED');
        $this->getIsPending()->shouldBe(false);
    }

    public function it_must_not_report_pending_on_denied_transactions()
    {
        $this->beConstructedWithResult('DENIED BY RISK');
        $this->getIsPending()->shouldBe(false);
    }

    public function it_must_not_report_pending_on_timeout_transactions()
    {
        $this->beConstructedWithResult('HOST TIMEOUT');
        $this->getIsPending()->shouldBe(false);
    }

    public function it_must_not_report_pending_on_issuer_unavailable_transactions()
    {
        $this->beConstructedWithResult('ISSUER UNAVAILABLE');
        $this->getIsPending()->shouldBe(false);
    }

    private function beConstructedWithResult($result)
    {
        $this->beConstructedWith(
            '123',
            '456',
            $result,
            '123456',
            '0829',
            '0987654321',
            '00',
            'VISA',
            'CC',
            'Y',
            'IT',
            'IT'
        );
    }
}
