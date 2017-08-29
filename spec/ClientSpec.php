<?php

namespace spec\Webgriffe\LibTriveneto;

use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;
use Webgriffe\LibTriveneto\PaymentInit\RequestSender;

class ClientSpec extends ObjectBehavior
{
    public function it_is_initializable(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
        $this->shouldHaveType('Webgriffe\LibTriveneto\Client');
    }

    public function it_throws_exception_if_user_is_missing(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
        $this->shouldThrow(new \InvalidArgumentException("Missing user id"))->duringInit('', 'pwd', 'url', 1);
    }

    public function it_throws_exception_if_password_is_missing(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
        $this->shouldThrow(new \InvalidArgumentException("Missing password"))->duringInit('a', '', 'url', 1);
    }

    public function it_throws_exception_if_init_url_is_missing(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
        $this->shouldThrow(new \InvalidArgumentException("Missing payment init URL"))->duringInit('a', 'pwd', '', 1);
    }

    public function it_throws_exception_if_action_is_missing(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
        $this->shouldThrow(new \InvalidArgumentException("Missing payment action (accounting type)"))
            ->duringInit('a', 'pwd', 'url', '');
    }

    public function it_throws_exception_if_action_is_not_a_valid_value(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
        $this->shouldThrow(new \InvalidArgumentException('Invalid payment action specified: a'))
            ->duringInit('a', 'pwd', 'url', 'a');
    }

    public function it_throws_exception_if_init_was_not_called_before_calling_paymentinit(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
        $this->shouldThrow(new \Exception("Init was not called"))
            ->duringPaymentInit('10001', 100, 978, 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_transaction_id_is_missing(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
        $this->init('a', 'pwd', 'url', 1);
        $this->shouldThrow(new \InvalidArgumentException('No transaction id provided'))
            ->duringPaymentInit('', 100, 978, 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_amount_is_missing(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
        $this->init('a', 'pwd', 'url', 1);
        $this->shouldThrow(new \InvalidArgumentException('Invalid amount'))
            ->duringPaymentInit('100001', '', 978, 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_amount_is_non_numeric(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
        $this->init('a', 'pwd', 'url', 1);
        $this->shouldThrow(new \InvalidArgumentException('Invalid amount'))
            ->duringPaymentInit('100001', 'a', 978, 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_amount_is_negative(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
        $this->init('a', 'pwd', 'url', 1);
        $this->shouldThrow(new \InvalidArgumentException('Invalid amount'))
            ->duringPaymentInit('100001', -10, 978, 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_amount_is_zero(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
        $this->init('a', 'pwd', 'url', 1);
        $this->shouldThrow(new \InvalidArgumentException('Invalid amount'))
            ->duringPaymentInit('100001', 0, 978, 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_amount_has_more_than_2_decimal_places(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
        $this->init('a', 'pwd', 'url', 1);
        $this->shouldThrow(new \InvalidArgumentException('Invalid amount'))
            ->duringPaymentInit('100001', 10.123, 978, 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_currency_is_missing(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
        $this->init('a', 'pwd', 'url', 1);
        $this->shouldThrow(new \InvalidArgumentException('Invalid currency'))
            ->duringPaymentInit('100001', 100, '', 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_currency_is_invalid(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
        $this->init('a', 'pwd', 'url', 1);
        $this->shouldThrow(new \InvalidArgumentException('Invalid currency'))
            ->duringPaymentInit('100001', 100, '', 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_language_is_missing(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
        $this->init('a', 'pwd', 'url', 1);
        $this->shouldThrow(new \InvalidArgumentException('Invalid language'))
            ->duringPaymentInit('100001', 100, 978, '', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_language_is_invalid(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
        $this->init('a', 'pwd', 'url', 1);
        $this->shouldThrow(new \InvalidArgumentException('Invalid language'))
            ->duringPaymentInit('100001', 100, 978, 'ABC', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_success_url_is_missing(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
        $this->init('a', 'pwd', 'url', 1);
        $this->shouldThrow(new \InvalidArgumentException('Missing success URL'))
            ->duringPaymentInit('100001', 100, 978, 'ITA', '', 'http://error.com');
    }

    public function it_throws_exception_if_error_url_is_missing(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
        $this->init('a', 'pwd', 'url', 1);
        $this->shouldThrow(new \InvalidArgumentException('Missing error URL'))
            ->duringPaymentInit('100001', 100, 978, 'ITA', 'http://response.com', '');
    }

    public function it_does_not_block_sender_exceptions(LoggerInterface $logger, RequestSender $sender)
    {
        $queryString = 'id=a&password=pwd&action=1&amt=100.00&currencycode=978&langid=ITA&responseURL=http%3A%2F%2Fresponse.com&errorURL=http%3A%2F%2Ferror.com&trackid=100001&udf1=e6383d1504bf424e7026abc7e2391328c4dea22a';
        $sender->post('url', $queryString)->willThrow(new \Exception('Test error'));

        $this->beConstructedWith($logger, $sender);
        $this->init('a', 'pwd', 'url', 1);
        $this->shouldThrow(new \Exception('Test error'))
            ->duringPaymentInit('100001', 100, 978, 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_when_gateway_reports_an_error(LoggerInterface $logger, RequestSender $sender)
    {
        $queryString = 'id=a&password=pwd&action=1&amt=100.00&currencycode=978&langid=ITA&responseURL=http%3A%2F%2Fresponse.com&errorURL=http%3A%2F%2Ferror.com&trackid=100001&udf1=e6383d1504bf424e7026abc7e2391328c4dea22a';
        $sender->post('url', $queryString)->willReturn('!ERROR!PY10000 Internal error');

        $this->beConstructedWith($logger, $sender);
        $this->init('a', 'pwd', 'url', 1);
        $this->shouldThrow(new \Exception('PY10000 Internal error'))
            ->duringPaymentInit('100001', 100, 978, 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_generates_signs_and_sends_paymentinit_message(LoggerInterface $logger, RequestSender $sender)
    {
        $queryString = 'id=a&password=pwd&action=1&amt=100.00&currencycode=978&langid=ITA&responseURL=http%3A%2F%2Fresponse.com&errorURL=http%3A%2F%2Ferror.com&trackid=100001&udf1=e6383d1504bf424e7026abc7e2391328c4dea22a';
        $sender->post('url', $queryString)->willReturn('123456:http://redirect.com');

        $this->beConstructedWith($logger, $sender);
        $this->init('a', 'pwd', 'url', 1);
        $this->paymentInit('100001', 100, 978, 'ITA', 'http://response.com', 'http://error.com')->shouldBe('http://redirect.com?PaymentID=123456');
    }

    public function it_throws_exception_if_init_was_not_called_before_calling_paymentverify(LoggerInterface $logger, RequestSender $sender)
    {
        $this->beConstructedWith($logger, $sender);
        $this->shouldThrow(new \Exception("Init was not called"))->duringPaymentVerify();
    }
}
