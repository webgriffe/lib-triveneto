<?php

namespace spec\Webgriffe\LibTriveneto;

use PhpSpec\ObjectBehavior;
use Psr\Log\LoggerInterface;

class ClientSpec extends ObjectBehavior
{
    public function it_is_initializable(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
        $this->shouldHaveType('Webgriffe\LibTriveneto\Client');
    }

    public function it_throws_exception_if_user_is_missing(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
        $this->shouldThrow(new \InvalidArgumentException("Missing user id"))->duringInit('', 'pwd', 'url', 1);
    }

    public function it_throws_exception_if_password_is_missing(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
        $this->shouldThrow(new \InvalidArgumentException("Missing password"))->duringInit('a', '', 'url', 1);
    }

    public function it_throws_exception_if_init_url_is_missing(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
        $this->shouldThrow(new \InvalidArgumentException("Missing payment init URL"))->duringInit('a', 'pwd', '', 1);
    }

    public function it_throws_exception_if_action_is_missing(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
        $this->shouldThrow(new \InvalidArgumentException("Missing payment action (accounting type)"))
            ->duringInit('a', 'pwd', 'url', '');
    }

    public function it_throws_exception_if_action_is_not_a_valid_value(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
        $this->shouldThrow(new \InvalidArgumentException('Invalid payment action specified: a'))
            ->duringInit('a', 'pwd', 'url', 'a');
    }

    public function it_throws_exception_if_init_was_not_called_before_calling_paymentinit(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
        $this->shouldThrow(new \Exception("Init was not called"))
            ->duringPaymentInit('10001', 100, 978, 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_init_was_not_called_before_calling_paymentverify(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
        $this->shouldThrow(new \Exception("Init was not called"))->duringPaymentVerify();
    }

    public function it_throws_exception_if_transaction_id_is_missing(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
        $this->init('a', 'pwd', 'url', 1);
        $this->shouldThrow(new \InvalidArgumentException('No transaction id provided'))
            ->duringPaymentInit('', 100, 978, 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_amount_is_missing(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
        $this->init('a', 'pwd', 'url', 1);
        $this->shouldThrow(new \InvalidArgumentException('Invalid amount'))
            ->duringPaymentInit('100001', '', 978, 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_amount_is_non_numeric(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
        $this->init('a', 'pwd', 'url', 1);
        $this->shouldThrow(new \InvalidArgumentException('Invalid amount'))
            ->duringPaymentInit('100001', 'a', 978, 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_amount_is_negative(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
        $this->init('a', 'pwd', 'url', 1);
        $this->shouldThrow(new \InvalidArgumentException('Invalid amount'))
            ->duringPaymentInit('100001', -10, 978, 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_amount_is_zero(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
        $this->init('a', 'pwd', 'url', 1);
        $this->shouldThrow(new \InvalidArgumentException('Invalid amount'))
            ->duringPaymentInit('100001', 0, 978, 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_amount_has_more_than_2_decimal_places(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
        $this->init('a', 'pwd', 'url', 1);
        $this->shouldThrow(new \InvalidArgumentException('Invalid amount'))
            ->duringPaymentInit('100001', 10.123, 978, 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_currency_is_missing(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
        $this->init('a', 'pwd', 'url', 1);
        $this->shouldThrow(new \InvalidArgumentException('Invalid currency'))
            ->duringPaymentInit('100001', 100, '', 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_currency_is_invalid(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
        $this->init('a', 'pwd', 'url', 1);
        $this->shouldThrow(new \InvalidArgumentException('Invalid currency'))
            ->duringPaymentInit('100001', 100, '', 'ITA', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_language_is_missing(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
        $this->init('a', 'pwd', 'url', 1);
        $this->shouldThrow(new \InvalidArgumentException('Invalid language'))
            ->duringPaymentInit('100001', 100, 978, '', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_language_is_invalid(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
        $this->init('a', 'pwd', 'url', 1);
        $this->shouldThrow(new \InvalidArgumentException('Invalid language'))
            ->duringPaymentInit('100001', 100, 978, 'ABC', 'http://response.com', 'http://error.com');
    }

    public function it_throws_exception_if_success_url_is_missing(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
        $this->init('a', 'pwd', 'url', 1);
        $this->shouldThrow(new \InvalidArgumentException('Missing success URL'))
            ->duringPaymentInit('100001', 100, 978, 'ITA', '', 'http://error.com');
    }

    public function it_throws_exception_if_error_url_is_missing(LoggerInterface $logger)
    {
        $this->beConstructedWith($logger);
        $this->init('a', 'pwd', 'url', 1);
        $this->shouldThrow(new \InvalidArgumentException('Missing error URL'))
            ->duringPaymentInit('100001', 100, 978, 'ITA', 'http://response.com', '');
    }
}
